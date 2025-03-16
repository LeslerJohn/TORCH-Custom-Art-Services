<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Commission;
use Illuminate\Http\Request;

class CommissionController extends Controller
{
    public function index()
    {
        $commissions = Commission::all();
        return view('admin.commission.index', compact('commissions'));
    }

    public function show(Commission $commission)
    {
        return view('admin.commission.show', compact('commission'));
    }

    public function updateStatus(Request $request, Commission $commission)
    {
        $request->validate([
            'status' => 'required|in:pending,ready,wip,done,completed',
        ]);

        $commission->status = $request->input('status');
        $commission->save();

        return redirect()->route('admin.commission.show', $commission)->with('success', 'Commission status updated successfully.');
    }

    public function updateDeliveryStatus(Request $request, Commission $commission)
    {
        $request->validate([
            'delivery_status' => 'required|in:pending,in-transit,completed,cancelled',
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

        return redirect()->route('admin.commission.show', $commission)->with('success', 'Commission deadline extended successfully.');
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
