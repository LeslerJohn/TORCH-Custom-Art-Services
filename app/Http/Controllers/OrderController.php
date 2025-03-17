<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Artwork;
use App\Models\Attachment;
use App\Models\Delivery;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Refund;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::where('client_id', Auth::user()->id)
            ->with(['items.artwork.images', 'items.artwork.category', 'items.artwork.artist', 'delivery'])
            ->latest()
            ->get();

        return view('client.order.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Artwork $artwork)
    {
        $user = $request->user();
        $price = $artwork->price;

        if ($artwork->discount && $artwork->discount->status === 'active') {
            if ($artwork->discount->value_type === 'percentage') {
                $price -= ($price * ($artwork->discount->value / 100));
            } else {
                $price -= $artwork->discount->value;
            }
        }

        $quantity = 1;

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
                    'line_items' => [
                        [
                            'amount' => $price * 100,
                            'description' => $artwork->description,
                            'currency' => 'PHP',
                            'name' => $artwork->title,
                            'quantity' => $quantity,
                            // 'images' => [
                            //     'https://images.unsplash.com/photo-1612346903007-b5ac8bb135bb?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1740&q=80'
                            // ],
                        ]
                    ],
                    'payment_method_types' => [
                        'gcash',
                        'paymaya',
                    ],
                    'default_payment_method_type' => 'gcash',
                    "merchant" => "Paymongo Test Account",
                    'success_url' => route('client.order.success', ['request' => $request, 'artwork' => $artwork]),
                    'cancel_url' => route('client.order.index'),
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
            // Session::put(['payment_id' => $response->data->attributes->payments[0]->id]);
            Session::put(['checkout_session_id' => $response->data->id]);
            return redirect($response->data->attributes->checkout_url);
        } else {
            return redirect()->back()->withErrors(['error' => 'Payment creation failed.']);
        }
    }

    public function success(Request $request, Artwork $artwork)
    {
        // Retrieve Checkout Session ID from session storage
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
            $delivery = Delivery::create([
                'status' => 'pending',
                'address_id' => Auth::user()->address->id,
                'expected_delivery' => now()->addDays(7)
            ]);

            $order = Order::create([
                'client_id' => Auth::user()->id,
                'status' => 'pending',
                'total' => $payment->data->attributes->amount / 100,
                'delivery_id' => $delivery->id
            ]);

            $order->items()->create([
                'artwork_id' => $artwork->id,
                'quantity' => 1,
                'price' => $artwork->discount && $artwork->discount->status === 'active' ?
                    ($artwork->discount->value_type === 'percentage' ?
                        $artwork->price - ($artwork->price * ($artwork->discount->value / 100)) :
                        $artwork->price - $artwork->discount->value) :
                    $artwork->price
            ]);

            $artwork->update(['status' => 'sold']);
            if ($artwork->discount) {
                $artwork->discount->update(['status' => 'inactive']);
            }

            Payment::create([
                'client_id' => Auth::user()->id,
                'order_id' => $order->id,
                'amount' => $payment->data->attributes->amount / 100,
                'payment_method' => $payment->data->attributes->source->type === 'gcash' ? 'GCash' : 'PayMaya',
                'transaction_id' => $payment->data->id,
                'status' => 'completed'
            ]);

            return redirect()->route('client.order.show', $order)->with('success', 'Order placed successfully!');
        } else {
            return redirect()->route('client.order.index')->withErrors(['error' => 'Payment failed.']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $order->load([
            'items.artwork.images',
            'items.artwork.category',
            'items.artwork.artist.user',
            'client.user',
            'delivery'
        ]);

        return view('client.order.show', compact('order'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function return(Request $request, Order $order)
    {
        $request->validate([
            'reason' => 'required|string',
            'evidence' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $file = $request->file('evidence');
        $path = $file->store('evidences', 'public');

        $attachment = Attachment::create([
            'filename' => $file->getClientOriginalName(),
            'path' => $path,
            'mime_type' => $file->getMimeType(),
        ]);

        // Company cut (10% fee) on refund amount
        $company_cut = $order->total * 0.10; // Adjust percentage as needed
        $refund_amount = $order->total - $company_cut;

        // Create a refund request
        Refund::create([
            'payment_id' => $order->payment->id,
            'order_id' => $order->id,
            'client_id' => $order->client_id,
            'artist_id' => $order->items->first()->artwork->artist_id,
            'amount' => $refund_amount,
            'reason' => $request->reason,
            'attachment_id' => $attachment->id,
            'refund_method' => $order->payment->payment_method === 'GCash' ? 'GCash' : 'PayMaya',
            'status' => 'pending',
            'admin_approved' => false
        ]);

        $order->update(['status' => 'hold']);
        if ($order->delivery) {
            $order->delivery->update(['status' => 'hold']);
        }

        return redirect()->route('client.order.show', $order)->with('success', 'Order return request sent.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Order $order)
    {
        $order->update([
            'status' => 'completed'
        ]);
        $order->delivery->update([
            'status' => 'completed'
        ]);

        return redirect()->route('client.order.show', $order)->with('success', 'Order status updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function cancel(Order $order)
    {
        if ($order->status === 'completed' || $order->delivery->status === 'in-transit') {
            dd('Cannot cancel a completed order.');
            return redirect()->route('client.order.index')->withErrors(['error' => 'Cannot cancel a completed order.']);
        }

        $refund_amount = $order->total;

        // Call PayMongo Refund API
        $response = Http::withOptions(['verify' => false])->withHeaders([
            'Content-Type' => 'application/json',
            'accept' => 'application/json',
            'Authorization' => 'Basic ' . env('AUTH_PAY'),
        ])->post('https://api.paymongo.com/v1/refunds', [
            'data' => [
            'attributes' => [
                'amount' => $refund_amount * 100, // Convert to centavos
                'payment_id' => $order->payment->transaction_id,
                'reason' => 'requested_by_customer',
                "send_email_receipt" => true,
                'payment_method_types' => [
                    'gcash',
                    'paymaya',
                ],
                'default_payment_method_type' => 'gcash',
                "merchant" => "Paymongo Test Account",
                'success_url' => route('client.order.show', $order),
                'cancel_url' => route('client.order.index'),
                'notes' => 'Order Cancellation',
                'statement_descriptor' => 'Torch Payment',
                "show_description" => true,
            ]
            ]
        ]);

        $response_data = $response->json();

        // Check if refund is successful
        if (isset($response_data['data'])) {
            // Save refund in the database
            Refund::create([
                'payment_id' => $order->payment->id,
                'order_id' => $order->id,
                'client_id' => $order->client_id,
                'artist_id' => $order->items->first()->artwork->artist_id,
                'amount' => $refund_amount,
                'reason' => 'Client cancelled order',
                'refund_method' => $order->payment->payment_method === 'GCash' ? 'GCash' : 'Bank Transfer',
                'status' => 'approved',
                'transaction_id' => $response_data['data']['id'],
                'admin_approved' => true, // Mark as approved
            ]);

            // Update order and delivery statuses
            $order->update(['status' => 'cancelled']);
            if ($order->delivery) {
                $order->delivery->update(['status' => 'cancelled']);
            }

            return redirect()->route('client.order.index')->with('success', 'Order cancelled and refund processed successfully.');
        } else {
            return redirect()->route('client.order.index')->with('error', 'Refund failed. Please try again.');
        }
    }
}
