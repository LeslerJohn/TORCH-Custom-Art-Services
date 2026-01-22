<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\CommissionTrackingMail;
use App\Models\Address;
use App\Models\Attachment;
use App\Models\Commission;
use App\Models\Delivery;
use App\Models\Payout;
use App\Models\Refund;
use App\Models\Request as ModelsRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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

        $commission->request->payout->update([
            'status' => 'ready',
        ]);

        Mail::to($commission->request->client->user->email)->send(new CommissionTrackingMail(
            $commission->request->client->user->name,
            'Completed',
            'Your commission has been completed. Thank you for your patronage!'
        ));

        return redirect()->route('client.commission.show', $commission)->with('success', 'Commission received!');
    }

    public function return(Request $request, Commission $commission)
    {
        $request->validate([
            'reason' => 'required|string',
            'evidence' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $file = $request->file('evidence');
        $path = $file->store('evidences', 'public');

        $attachment = Attachment::create([
            'filename' => $file->getClientOriginalName(),
            'path' => $path,
            'mime_type' => $file->getMimeType(),
        ]);

        // Calculate the total deduction (15% of the total amount)
        $total_deduction = ($commission->request->total_price * $commission->request->quantity) * 0.15;

        // Calculate the refund amount after deductions
        $refund_amount = ($commission->request->total_price * $commission->request->quantity) - $total_deduction;

        // Create a refund request
        $refund = Refund::create([
            'payment_id' => $commission->request->payment->id,
            'commission_id' => $commission->id,
            'client_id' => $commission->request->client_id,
            'artist_id' => $commission->request->service->artist_id,
            'amount' => $refund_amount,
            'reason' => $request->reason,
            'attachment_id' => $attachment->id,
            'refund_method' => $commission->request->payment->payment_method === 'GCash' ? 'GCash' : 'PayMaya',
            'status' => 'pending',
            'admin_approved' => false
        ]);

        $commission->update(['status' => 'hold']);
        if ($commission->delivery) {
            $commission->delivery->update(['status' => 'hold']);
        }

        return redirect()->route('client.commission.show', $commission)->with('success', 'Order return request sent.');
    }
}
