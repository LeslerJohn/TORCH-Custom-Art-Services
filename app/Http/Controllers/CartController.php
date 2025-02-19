<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Http\Controllers\Controller;
use App\Models\Artwork;
use App\Models\CartItem;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    public function create()
    {
        //
    }

    public function checkout(Request $request)
    {

        dd($request->all());
        // $request->validate([
        //     'selected_items' => 'required|array',
        // ]);

        // $cart = Cart::where('client_id', Auth::user()->id)->first();

        // if (!$cart) {
        //     return redirect()->route('client.cart.index')->with('error', 'Cart not found.');
        // }

        // // Group selected items by artist
        // $groupedItems = $cart->items->whereIn('id', $request->selected_items)->groupBy('artwork.artist_id');

        // foreach ($groupedItems as $artistId => $items) {
        //     $order = Order::create([
        //         'client_id' => Auth::user()->id,
        //         'total' => $items->sum(fn($item) => $item->artwork->price),
        //     ]);

        //     foreach ($items as $item) {
        //         $order->items()->create([
        //             'artwork_id' => $item->artwork->id,
        //             'price' => $item->artwork->price,
        //         ]);

        //         // Remove from cart
        //         $item->delete();
        //     }
        // }

        // return redirect()->route('client.order.index')->with('success', 'Your order has been placed successfully.');
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
        $cart = Cart::where('client_id', Auth::user()->id)->first();
    
        if (!$cart) {
            return redirect()->route('client.cart.index')->with('error', 'Cart not found.');
        }
    
        $cartItem = $cart->items()->where('artwork_id', $artwork->id)->first();
    
        if (!$cartItem) {
            return redirect()->route('client.cart.index')->with('error', 'Item not found in your cart.');
        }
    
        $cartItem->delete();
    
        return redirect()->route('client.cart.index')->with('success', 'Item removed from cart successfully!');
    }    
}
