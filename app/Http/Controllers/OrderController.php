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
        $request->validate([
            'contact_number' => 'required|string|max:15',
            'barangay' => 'required|string|max:255',
            'street' => 'required|string|max:255',
            'house_number' => 'required|string|max:255',
        ]);

        $address = Address::create([
            'client_id' => Auth::user()->id,
            'barangay' => $request->barangay,
            'street' => $request->street,
            'house_number' => $request->house_number,
        ]);

        $delivery = Delivery::create([
            'contact_number' => $request->contact_number,
            'address_id' => $address->id,
            'expected_delivery' => now()->addDays(7),
            'status' => 'pending',
        ]);

        $order = Order::create([
            'client_id' => Auth::user()->id,
            'total' => $artwork->price,
            'status' => 'pending',
            'delivery_id' => $delivery->id,
        ]);

        $order->items()->create([
            'artwork_id' => $artwork->id,
            'price' => $artwork->price,
        ]);

        $artwork->update(['status' => 'sold']);

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
        $order->delete();

        return redirect()->route('client.order.index')->with('success', 'Order deleted successfully!');
    }
}
