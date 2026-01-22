<?php

namespace App\Http\Controllers\Artist;

use App\Http\Controllers\Controller;
use App\Mail\CommissionTrackingMail;
use App\Mail\DraftSentMail;
use App\Models\Attachment;
use App\Models\Commission;
use App\Models\Delivery;
use App\Models\Draft;
use App\Models\Extension;
use App\Models\ProofOfDelivery;
use App\Models\Request as ModelsRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\RequestAcceptedMail;
use App\Mail\DeadlineExtensionRequestMail;

class CommissionController extends Controller
{
    public function index()
    {
        $commissions = Commission::whereHas('request.service', function ($query) {
            $query->where('artist_id', Auth::user()->artist->id);
        })->latest()->get();

        $requests = ModelsRequest::whereHas('service', function ($query) {
            $query->where('artist_id', Auth::user()->artist->id);
        })->latest()->get();

        return view('artist.commission.index', compact('commissions', 'requests'));
    }

    public function showRequest(ModelsRequest $request)
    {
        return view('artist.commission.show-request', compact('request'));
    }

    public function show(Commission $commission)
    {
        return view('artist.commission.show', compact('commission'));
    }

    public function accept(ModelsRequest $request)
    {
        $request->update([
            'status' => 'accepted',
        ]);

        $delivery = Delivery::create([
            'address_id' => $request->client->user->address->id,
            'expected_delivery' => Carbon::parse($request->deadline)->addDays(7),
            'status' => 'pending',
        ]);

        $commission = Commission::create([
            'deadline' => $request->deadline,
            'status' => 'ready',
            'delivery_id' => $delivery->id,
            'request_id' => $request->id,
        ]);

        Mail::to($request->client->user->email)->send(new RequestAcceptedMail(
            $request->client->user->name,
            Auth::user()->artist->name,
            'Description: ' . $request->description . ', Price: ' . $request->total_price . ', Deadline: ' . $request->deadline
        ));

        return redirect()->route('artist.commission.show', $commission);
    }

    public function reject(ModelsRequest $request)
    {
        $request->update([
            'status' => 'rejected',
        ]);

        Mail::to($request->client->user->email)->send(new CommissionTrackingMail(
            $request->client->user->name,
            'Rejected',
            'Your service request has been rejected by the artist. If you have any questions, please contact us.'
        ));

        return redirect()->route('artist.request.show', $request);
    }

    public function start(Commission $commission) {
        $commission->update([
            'status' => 'wip',
        ]);

        Mail::to($commission->request->client->user->email)->send(new CommissionTrackingMail(
            $commission->request->client->user->name,
            'In-progress',
            'Your commission is now in progress. We will notify you once it is completed.'
        ));

        return redirect()->route('artist.commission.show', $commission);
    }

    public function done(Commission $commission) {
        $commission->update([
            'status' => 'done',
        ]);

        Mail::to($commission->request->client->user->email)->send(new CommissionTrackingMail(
            $commission->request->client->user->name,
            'Done',
            'Your commission is now done. Please check your email for the delivery details.'
        ));

        return redirect()->route('artist.commission.show', $commission);
    }

    public function deliver(Commission $commission) {
        $commission->delivery->update([
            'status' => 'in-transit',
        ]);

        Mail::to($commission->request->client->user->email)->send(new CommissionTrackingMail(
            $commission->request->client->user->name,
            'In-transit',
            'Your commission is now in transit. You can track it using the tracking number: ' . $commission->delivery->id . '.'
        ));

        return redirect()->route('artist.commission.show', $commission);
    }

    public function delivered(Request $request, Commission $commission)
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
                    'delivery_id' => $commission->delivery->id,
                    'attachment_id' => $attachment->id,
                ]);

                $commission->delivery->update(['status' => 'delivered']);
            }

            Mail::to($commission->request->client->user->email)->send(new CommissionTrackingMail(
                $commission->request->client->user->name,
                'Delivered',
                'Your commission has been delivered. You can view the proof of delivery in your account.'
            ));
        }

        return redirect()->route('artist.commission.show', $commission);
    }

    public function draft(Request $request, Commission $commission) {
        $request->validate([
            'description' => 'required|string',
            'image' => 'required|image',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $path = $image->store('drafts', 'public');

            $attachment = Attachment::create([
                'filename' => $image->getClientOriginalName(),
                'path' => $path,
                'mime_type' => $image->getMimeType(),
            ]);

            Draft::create([
                'description' => $request->description,
                'commission_id' => $commission->id,
                'attachment_id' => $attachment->id,
            ]);
        }

        Mail::to($commission->request->client->user->email)->send(new DraftSentMail(
            $commission->request->client->user->name,
            'A draft has been sent for your review. Please check your account for the details.'
        ));

        return redirect()->route('artist.commission.show', $commission);
    }

    public function requestExtension(Request $request, Commission $commission)
    {
        $request->validate([
            'reason' => 'required|string',
        ]);

        $extension = Extension::create([
            'commission_id' => $commission->id,
            'status' => 'pending',
            'reason' => $request->reason,
            'artist_id' => Auth::user()->artist->id,
        ]);

        // Notify the client about the extension request
        Mail::to($commission->request->client->user->email)->send(new DeadlineExtensionRequestMail(
            $commission->request->client->user->name,
            Auth::user()->artist->name,
            $request->reason
        ));
        

        return redirect()->route('artist.commission.show', $commission)->with('success', 'Deadline extension request sent successfully!');
    }
}
