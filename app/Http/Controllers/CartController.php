<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Http\Controllers\Controller;
use App\Models\Artwork;
use App\Models\CartItem;
use App\Models\Delivery;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Payout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cart = Cart::where('client_id', Auth::user()->id)->with('items.artwork.artist')->first();

        return view('client.cart.index', compact('cart'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function checkout(Request $request, Cart $cart)
    {
        $request->validate([
            'selected_items' => 'required|array|min:1',
        ]);

        $cart = Cart::where('client_id', Auth::user()->id)->first();

        if (!$cart) {
            return redirect()->route('client.cart.index')->with('error', 'Cart not found.');
        }

        $user = Auth::user();
        $lineItems = [];
        $total = 0;

        foreach ($cart->items->whereIn('id', $request->selected_items) as $item) {
            $artwork = $item->artwork;
            $price = $artwork->price;

            if ($artwork->discount && $artwork->discount->status === 'active') {
                if ($artwork->discount->value_type === 'percentage') {
                    $price -= $price * $artwork->discount->value / 100;
                } else {
                    $price -= $artwork->discount->value;
                }
            }

            $lineItems[] = [
                'amount' => $price * 100,
                'description' => $artwork->description,
                'currency' => 'PHP',
                'name' => $artwork->title,
                'quantity' => 1,
                // 'images' => [
                //     'https://images.unsplash.com/photo-1612346903007-b5ac8bb135bb?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1740&q=80'
                // ],
            ];

            $total += $price;
        }

        $data = [
            'data' => [
                'attributes' => [
                    'billing' => [
                        'address' => [
                            'city' => 'Zamboanga',
                            'country' => 'PH',
                            'line1' => $user->address->house_number . ' ' . $user->address->street . ' ' . $user->address->barangay,
                            'line2' => 'address line 2',
                            'postal_code' => '7000',
                            'state' => 'PH-MNL'
                        ],
                        'email' => $user->email,
                        'name' => $user->name,
                        'phone' => $user->phone_number
                    ],
                    'line_items' => $lineItems,
                    'payment_method_types' => [
                        'gcash',
                        'paymaya',
                    ],
                    'default_payment_method_type' => 'gcash',
                    "merchant" => "Paymongo Test Account",
                    'success_url' => route('client.cart.success', ['selected_items' => json_encode($request->selected_items)]),
                    'cancel_url' => route('client.cart.index'),
                    'description' => 'Order Payment',
                    'statement_descriptor' => 'Torch Payment',
                    "send_email_receipt" => true,
                    "show_description" => true,
                    "show_line_items" => true,
                ]
            ]
        ];

        $response = Http::withOptions(['verify' => false])->withHeaders([
            'Content-Type' => 'application/json',
            'accept' => 'application/json',
            'Authorization' => 'Basic ' . env('AUTH_PAY')
        ])->post('https://api.paymongo.com/v1/checkout_sessions', $data)->object();

        if (isset($response->data)) {
            Session::put(['checkout_session_id' => $response->data->id]);
            return redirect($response->data->attributes->checkout_url);
        } else {
            return redirect()->back()->withErrors(['error' => 'Payment creation failed.']);
        }
    }

    public function success($selected_items)
    {
        $cart = Cart::where('client_id', Auth::user()->id)->first();

        if (!$cart) {
            return redirect()->route('client.cart.index')->with('error', 'Cart not found.');
        }

        $checkout_session_id = Session::get('checkout_session_id');

        if (!$checkout_session_id) {
            return response()->json(['error' => 'Checkout session ID not found'], 400);
        }

        // Step 1: Fetch Checkout Session Data
        $checkoutSession = Http::withOptions(['verify' => false])->withHeaders([
            'Content-Type' => 'application/json',
            'accept' => 'application/json',
            'Authorization' => 'Basic ' . env('AUTH_PAY')
        ])->get("https://api.paymongo.com/v1/checkout_sessions/{$checkout_session_id}")->object();

        // Debugging: Check the response structure
        // dd($checkoutSession);

        if (!isset($checkoutSession->data->attributes->payments) || empty($checkoutSession->data->attributes->payments)) {
            return response()->json(['error' => 'No payments found in the checkout session'], 400);
        }

        // Step 2: Extract Payment ID from Checkout Session
        $payment_id = $checkoutSession->data->attributes->payments[0]->id ?? null;

        if (!$payment_id) {
            return response()->json(['error' => 'Payment ID not found'], 400);
        }

        // Step 3: Fetch Payment Details Using Payment ID
        $payment = Http::withOptions(['verify' => false])->withHeaders([
            'Content-Type' => 'application/json',
            'accept' => 'application/json',
            'Authorization' => 'Basic ' . env('AUTH_PAY')
        ])->get("https://api.paymongo.com/v1/payments/{$payment_id}")->object();

        if ($payment->data->attributes->status === 'paid') {
            // Group selected items by artist
            $selected_items_array = json_decode($selected_items, true);
            $groupedItems = $cart->items->whereIn('id', $selected_items_array)->groupBy('artwork.artist_id');

            foreach ($groupedItems as $artistId => $items) {
                $orderTotal = 0;

                foreach ($items as $item) {
                    $artwork = $item->artwork;

                    // Check if the artwork is for sale
                    if ($artwork->status != 'sale') {
                        continue;
                    }

                    $price = $artwork->price;

                    // Check if the artwork has a discount
                    $discount = $artwork->discount()->where('status', 'active')->first();
                    if ($discount) {
                        if ($discount->value_type == 'percentage') {
                            $price -= ($price * ($discount->value / 100));
                        } else {
                            $price -= $discount->value;
                        }
                    }

                    $orderTotal += $price;
                }

                if ($orderTotal == 0) {
                    continue;
                }

                $delivery = Delivery::create([
                    'address_id' => Auth::user()->address->id,
                    'status' => 'pending',
                    'expected_delivery' => now()->addDays(7),
                ]);

                $order = Order::create([
                    'client_id' => Auth::user()->id,
                    'total' => $orderTotal,
                    'status' => 'pending',
                    'delivery_id' => $delivery->id,
                ]);

                foreach ($items as $item) {
                    $artwork = $item->artwork;

                    // Check if the artwork is for sale
                    if ($artwork->status != 'sale') {
                        continue;
                    }

                    $price = $artwork->price;

                    // Apply discount again for order item
                    $discount = $artwork->discount()->where('status', 'active')->first();
                    if ($discount) {
                        if ($discount->value_type == 'percentage') {
                            $price -= ($price * ($discount->value / 100));
                        } else {
                            $price -= $discount->value;
                        }
                    }

                    $order->items()->create([
                        'artwork_id' => $artwork->id,
                        'price' => $price,
                    ]);

                    CartItem::where('cart_id', $cart->id)
                        ->where('artwork_id', $artwork->id)
                        ->delete();

                    $artwork->update([
                        'status' => 'sold',
                    ]);

                    if ($discount) {
                        $discount->update([
                            'status' => 'inactive',
                        ]);
                    }
                }
                CartItem::where('cart_id', $cart->id)
                    ->where('artwork_id', $artwork->id)
                    ->delete();

                $artwork->update([
                    'status' => 'sold',
                ]);

                if ($discount) {
                    $discount->update([
                        'status' => 'inactive',
                    ]);
                }

                $paymentCreated = Payment::create([
                    'client_id' => Auth::user()->id,
                    'order_id' => $order->id,
                    'amount' => $payment->data->attributes->amount / 100,
                    'payment_method' => $payment->data->attributes->source->type === 'gcash' ? 'GCash' : 'PayMaya',
                    'transaction_id' => $payment->data->id,
                    'status' => 'completed'
                ]);
    
                // Calculate the payout amount for the artist
                $serviceFeePercentage = 3;
                $serviceFee = ($orderTotal * $serviceFeePercentage) / 100;
                $netAmount = $orderTotal - $serviceFee;
    
                Payout::create([
                    'artist_id' => $artistId,
                    'payment_id' => $paymentCreated->id,
                    'amount' => $orderTotal,
                    'service_fee' => $serviceFeePercentage,
                    'net_amount' => $netAmount,
                    'company_cut' => $serviceFee,
                    'payout_type' => 'order',
                    'payout_method' => $payment->data->attributes->source->type === 'gcash' ? 'GCash' : 'PayMaya',
                    'transaction_id' => $payment->data->id,
                    'status' => 'pending',
                ]);

                return redirect()->route('client.order.show', $order)->with('success', 'Order placed successfully!');
            }
        } else {
            return redirect()->route('client.order.index')->withErrors(['error' => 'Payment failed.']);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Artwork $artwork)
    {
        $cart = Cart::where('client_id', Auth::user()->id)->first();

        if (!$cart) {
            $cart = Cart::create([
                'client_id' => Auth::user()->id,
            ]);
        }

        $cartItem = $cart->items()->where('artwork_id', $artwork->id)->first();

        if ($cartItem) {
            $cartItem->save();
        } else {
            $cart->items()->create([
                'artwork_id' => $artwork->id
            ]);
        }

        return redirect()->route('client.cart.index');
    }
    /**
     * Display the specified resource.
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Artwork $artwork)
    {
        $cart = Cart::where('client_id', Auth::id())->first();

        if (!$cart) {
            return redirect()->route('client.cart.index')->with('error', 'Cart not found.');
        }

        $cartItem = $cart->items()
            ->where('artwork_id', $artwork->id)
            ->where('cart_id', $cart->id)
            ->first();

        if (!$cartItem) {
            return redirect()->route('client.cart.index')->with('error', 'Item not found in your cart.');
        }

        CartItem::where('cart_id', $cart->id)
            ->where('artwork_id', $artwork->id)
            ->delete();

        return redirect()->route('client.cart.index')->with('success', 'Item removed from cart successfully!');
    }
}
