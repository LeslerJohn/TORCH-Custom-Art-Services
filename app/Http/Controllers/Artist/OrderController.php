<?php

namespace App\Http\Controllers\Artist;

use App\Models\Order;
use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\ProofOfDelivery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::whereHas('items.artwork', function ($query) {
            $query->where('artist_id', Auth::user()->id);
        })->with('items.artwork')->latest()->get();

        return view('artist.order.index', compact('orders'));
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        return view('artist.order.show', compact('order'));
    }

    public function deliver(Order $order)
    {
        $order->delivery->update(['status' => 'in-transit']);
        $order->update(['status' => 'accepted']);

        return redirect()->route('artist.order.show', $order);
    }

    
    public function delivered(Request $request, Order $order)
    {
        $request->validate([
            'proof_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('proof_images')) {
            foreach ($request->file('proof_images') as $image) {
                $path = $image->store('proof_of_delivery', 'public');

                $attachment = Attachment::create([
                    'filename' => $image->getClientOriginalName(),
                    'path' => $path,
                    'mime_type' => $image->getMimeType(),
                ]);

                ProofOfDelivery::create([
                    'delivery_id' => $order->delivery->id,
                    'attachment_id' => $attachment->id,
                ]);

                $order->delivery->update(['status' => 'delivered']);
            }
        }

        return redirect()->route('artist.order.show', $order);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
