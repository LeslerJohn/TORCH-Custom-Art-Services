<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Http\Controllers\Controller;
use App\Models\Artwork;
use App\Models\CartItem;
use App\Models\Delivery;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

        $delivery = Delivery::create([
            'address_id' => Auth::user()->address->id,
            'status' => 'pending',
            'expected_delivery' => now()->addDays(7),
        ]);

        // Group selected items by artist
        $groupedItems = $cart->items->whereIn('id', $request->selected_items)->groupBy('artwork.artist_id');

        foreach ($groupedItems as $artistId => $items) {
            $total = 0;

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

                $total += $price;
            }

            if ($total == 0) {
                continue;
            }

            $order = Order::create([
                'client_id' => Auth::user()->id,
                'total' => $total,
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
        }

        return redirect()->route('client.order.index')->with('success', 'Your order has been placed successfully.');
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
