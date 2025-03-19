<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Commission;
use App\Models\Extension;
use App\Models\Refund;
use App\Models\Request as ModelsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CommissionController extends Controller
{
    public function index(Request $request)
    {
        $query = Commission::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->whereHas('request.service.artist.user', function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%");
            })->orWhereHas('request.client.user', function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        $commissions = $query->get();

        $refunds = Refund::whereHas('commission', function ($q) use ($request) {
            $q->whereIn('status', ['hold', 'returned']);
            if ($request->has('search')) {
            $search = $request->input('search');
            $q->whereHas('request.service.artist.user', function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%");
            })->orWhereHas('request.client.user', function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%");
            });
            }
        })->get();

        $cancellations = Refund::whereHas('commission', function ($q) use ($request) {
            $q->where('status', 'cancelled');
            if ($request->has('search')) {
            $search = $request->input('search');
            $q->whereHas('request.service.artist.user', function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%");
            })->orWhereHas('request.client.user', function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%");
            });
            }
        })->get();

        $extensions = Extension::whereHas('commission', function ($q) use ($request) {
            if ($request->has('search')) {
                $search = $request->input('search');
                $q->whereHas('request.service.artist.user', function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('email', 'LIKE', "%{$search}%");
                })->orWhereHas('request.client.user', function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('email', 'LIKE', "%{$search}%");
                });
            }
        })->get();

        $table = $request->has('table');
        return view('admin.commission.index', compact('commissions', 'refunds', 'cancellations', 'extensions', 'table'));
    }

    public function show(Commission $commission)
    {
        return view('admin.commission.show', compact('commission'));
    }

    public function updateStatus(Request $request, Commission $commission)
    {
        $request->validate([
            'status' => 'required|in:pending,ready,wip,done,completed,hold,returned',
        ]);

        $commission->status = $request->input('status');
        $commission->save();

        return redirect()->route('admin.commission.show', $commission)->with('success', 'Commission status updated successfully.');
    }

    public function updateDeliveryStatus(Request $request, Commission $commission)
    {
        $request->validate([
            'delivery_status' => 'required|in:pending,in-transit,completed,cancelled,returned,delivered,hold',
        ]);

        $commission->delivery->status = $request->input('delivery_status');
        $commission->delivery->save();

        return redirect()->route('admin.commission.show', $commission)->with('success', 'Delivery status updated successfully.');
    }

    public function extendDeadline(Request $request, Commission $commission)
    {
        $request->validate([
            'count' => 'required|integer|min:1',
        ]);

        $newDeadline = \Carbon\Carbon::parse($commission->deadline)->addDays((int) $request->input('count'));
        $commission->extended_deadline = $newDeadline;
        $commission->is_extended = true;
        $commission->save();

        $commission->delivery->update([
            'expected_delivery' => $newDeadline->addDays(5),
        ]);

        $commission->extension->update([
            'status' => 'approved',
        ]);

        return redirect()->route('admin.commission.show', $commission)->with('success', 'Commission deadline extended successfully.');
    }

    public function rejectExtension(Request $request, Commission $commission)
    {
        $request->validate([
            'count' => 'required|integer|min:1',
        ]);

        $commission->extension->update([
            'status' => 're',
        ]);

        return redirect()->route('admin.commission.show', $commission)->with('success', 'Commission deadline has been denied.');
    }

    public function approveRefund(Commission $commission)
    {
        $refund_amount = (int) ($commission->refund->amount * 100);

        // Call PayMongo Refund API
        $response = Http::withOptions(['verify' => false])->withHeaders([
            'Content-Type' => 'application/json',
            'accept' => 'application/json',
            'Authorization' => 'Basic ' . env('AUTH_PAY'),
        ])->post('https://api.paymongo.com/v1/refunds', [
            'data' => [
                'attributes' => [
                    'amount' => $refund_amount, // Convert to centavos
                    'payment_id' => $commission->refund->payment->transaction_id,
                    'reason' => 'requested_by_customer',
                    "send_email_receipt" => true,
                    'payment_method_types' => [
                        'gcash',
                        'paymaya',
                    ],
                    'default_payment_method_type' => 'gcash',
                    "merchant" => "Paymongo Test Account",
                    'success_url' => route('client.commission.show', $commission),
                    'cancel_url' => route('client.commission.index'),
                    'notes' => 'Commission Refund',
                    'statement_descriptor' => 'Torch Payment',
                    "show_description" => true,
                ]
            ]
        ]);

        $response_data = $response->json();

        if (isset($response_data['data'])) {
            $commission->refund->update([
                'status' => 'approved',
                'admin_approved' => true,
                'transaction_id' => $response_data['data']['id'],
            ]);

            $commission->update([
                'status' => 'returned',
            ]);

            $commission->delivery->update([
                'status' => 'returned',
            ]);

            $refund_fee = ($commission->request->total_price * $commission->request->quantity) * 0.15;
            $net_amount = ($commission->request->total_price * $commission->request->quantity) - $refund_fee;

            $commission->request->payout->update([
                'amount' => $commission->request->total_price * $commission->request->quantity,
                'service_fee' => 15,
                'net_amount' => $net_amount,
                'company_cut' => $refund_fee,
                'payout_type' => 'refund',
                'transaction_id' => $response_data['data']['id'],
                'status' => 'ready',
            ]);

            return redirect()->route('admin.commission.show', $commission)->with('success', 'Commission refund has been approved.');
        }

        return redirect()->route('admin.commission.show', $commission)->with('success', 'Commission refund has been approved.');
    }

    public function refund()
    {
        return view('admin.commission.refund');
    }

    public function cancel()
    {
        return view('admin.commission.cancel');
    }
}
