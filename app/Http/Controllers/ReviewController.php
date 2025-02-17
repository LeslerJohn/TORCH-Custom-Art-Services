<?php

namespace App\Http\Controllers;

use App\Models\OrderReview;
use App\Http\Controllers\Controller;
use App\Models\Commission;
use App\Models\CommissionReview;
use App\Models\Order;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function order(Request $request, Order $order)
    {
        $request->validate([
            'rating' => 'required|numeric|min:1|max:5',
            'comment' => 'required|string',
        ]);

        OrderReview::create([
            'order_id' => $order->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->route('client.order.show', $order);
    }

    public function commission(Request $request, Commission $commission)
    {
        $request->validate([
            'rating' => 'required|numeric|min:1|max:5',
            'comment' => 'required|string',
        ]);

        CommissionReview::create([
            'commission_id' => $commission->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->route('client.commission.show', $commission);
    }

    /**
     * Display the specified resource.
     */
    public function show(OrderReview $review)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OrderReview $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OrderReview $review)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrderReview $review)
    {
        //
    }
}
