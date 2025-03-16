<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Commission;
use App\Models\Delivery;
use App\Models\Request as ModelsRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommissionController extends Controller
{
    public function index()
    {
        //
    }

    public function show(Commission $commission)
    {
        return view('client.request.show-commission', compact('commission'));
    }

    public function store(Request $request, ModelsRequest $modelrequest)
    {
        $request->validate([
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
            'address_id' => $address->id,
            'expected_delivery' => Carbon::parse($modelrequest->deadline)->addDays(7),
            'status' => 'pending',
        ]);

        Commission::create([
            'deadline' => $modelrequest->deadline,
            'status' => 'ready',
            'delivery_id' => $delivery->id,
            'request_id' => $modelrequest->id,
        ]);

        return redirect()->route('client.request.index')->with('success', 'Commission placed successfully!');
    }

    public function receive(Commission $commission)
    {
        $commission->update([
            'status' => 'completed',
        ]);

        $commission->delivery->update([
            'status' => 'completed',
        ]);

        return redirect()->route('client.commission.show', $commission)->with('success', 'Commission received!');
    }
}
