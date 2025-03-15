<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Artwork;
use App\Models\Delivery;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::where('client_id', Auth::user()->id)
            ->with(['items.artwork.images', 'items.artwork.category', 'items.artwork.artist', 'delivery'])->latest()
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

        // Check if the artwork has an active discount
        if ($artwork->discount && $artwork->discount->status === 'active') {
            if ($artwork->discount->value_type === 'percentage') {
            $price -= ($price * ($artwork->discount->value / 100));
            } else {
            $price -= $artwork->discount->value;
            }
        }

        $delivery = Delivery::create([
            'address_id' => $user->address->id,
            'expected_delivery' => now()->addDays(7),
            'status' => 'pending',
        ]);

        $order = Order::create([
            'client_id' => $user->id,
            'total' => $price,
            'status' => 'pending',
            'delivery_id' => $delivery->id,
        ]);

        $order->items()->create([
            'artwork_id' => $artwork->id,
            'price' => $price,
        ]);

        $artwork->update(['status' => 'sold']);
        $artwork->discount->update(['status' => 'inactive']);

        return redirect()->route('client.order.index')->with('success', 'Order placed successfully!');
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->items()->each(function ($item) {
            $item->artwork->update(['status' => 'sale']);
        });

        $order->status->update(['status' => 'cancelled']);
        $order->delivery->update(['status' => 'cancelled']);

        return redirect()->route('client.order.index')->with('success', 'Order deleted successfully!');
    }
}
