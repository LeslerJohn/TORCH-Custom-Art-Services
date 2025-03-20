<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Refund;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->whereHas('items.artwork.artist.user', function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%");
            })->orWhereHas('client.user', function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        $orders = $query->latest()->get();

        $refunds = Refund::whereHas('order', function ($q) use ($request) {
            $q->whereIn('status', ['hold', 'returned']);
            if ($request->has('search')) {
            $search = $request->input('search');
            $q->whereHas('items.artwork.artist.user', function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%");
            })->orWhereHas('client.user', function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%");
            });
            }
        })->latest()->get();

        $cancellations = Refund::whereHas('order', function ($q) use ($request) {
            $q->where('status', 'cancelled');
            if ($request->has('search')) {
            $search = $request->input('search');
            $q->whereHas('items.artwork.artist.user', function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%");
            })->orWhereHas('client.user', function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%");
            });
            }
        })->latest()->get();

        $table = $request->has('table');
        return view('admin.order.index', compact('orders', 'refunds', 'cancellations', 'table'));
    }

    public function show(Order $order)
    {
        return view('admin.order.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,accepted,in-transit,completed,cancelled,returned,hold',
        ]);

        $order->status = $request->input('status');
        $order->save();

        return redirect()->route('admin.order.show', $order)->with('success', 'Order status updated successfully.');
    }

    public function updateDeliveryStatus(Request $request, order $order)
    {
        $request->validate([
            'delivery_status' => 'required|in:pending,in-transit,completed,cancelled,returned,delivered,hold',
        ]);

        $order->delivery->status = $request->input('delivery_status');
        $order->delivery->save();

        return redirect()->route('admin.order.show', $order)->with('success', 'Delivery status updated successfully.');
    }

    public function approveRefund(Order $order)
    {
        $refund_amount = (int) ($order->refund->amount * 100);

        // Call PayMongo Refund API
        $response = Http::withOptions(['verify' => false])->withHeaders([
            'Content-Type' => 'application/json',
            'accept' => 'application/json',
            'Authorization' => 'Basic ' . env('AUTH_PAY'),
        ])->post('https://api.paymongo.com/v1/refunds', [
            'data' => [
                'attributes' => [
                    'amount' => $refund_amount, // Convert to centavos
                    'payment_id' => $order->refund->payment->transaction_id,
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
                    'notes' => 'order Refund',
                    'statement_descriptor' => 'Torch Payment',
                    "show_description" => true,
                ]
            ]
        ]);

        $response_data = $response->json();

        if (isset($response_data['data'])) {
            $order->refund->update([
                'status' => 'approved',
                'admin_approved' => true,
                'transaction_id' => $response_data['data']['id'],
            ]);

            $order->update([
                'status' => 'returned',
            ]);

            $order->delivery->update([
                'status' => 'returned',
            ]);

            $refund_fee = $order->total * 0.10;
            $net_amount = $order->total - $refund_fee;

            $order->payout->update([
                'amount' => $order->total,
                'service_fee' => 10,
                'net_amount' => $net_amount,
                'company_cut' => $refund_fee,
                'payout_type' => 'refund',
                'transaction_id' => $response_data['data']['id'],
                'status' => 'ready',
            ]);

            foreach ($order->items as $item) {
                $item->artwork->update([
                    'status' => 'sale',
                ]);

                if ($item->artwork->discount) {
                    $item->artwork->update([
                        'status' => 'active',
                    ]);
                }
            }

            return redirect()->route('admin.order.show', $order)->with('success', 'order refund has been approved.');
        }

        return redirect()->route('admin.order.show', $order)->with('success', 'order refund has been approved.');
    }

}
