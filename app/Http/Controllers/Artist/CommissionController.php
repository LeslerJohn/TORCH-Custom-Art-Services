<?php

namespace App\Http\Controllers\Artist;

use App\Http\Controllers\Controller;
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

        return redirect()->route('artist.commission.show', $commission);
    }

    public function reject(ModelsRequest $request)
    {
        $request->update([
            'status' => 'rejected',
        ]);

        return redirect()->route('artist.request.show', $request);
    }

    public function start(Commission $commission) {
        $commission->update([
            'status' => 'wip',
        ]);

        return redirect()->route('artist.commission.show', $commission);
    }

    public function done(Commission $commission) {
        $commission->update([
            'status' => 'done',
        ]);

        return redirect()->route('artist.commission.show', $commission);
    }

    public function deliver(Commission $commission) {
        $commission->delivery->update([
            'status' => 'in-transit',
        ]);

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

        return redirect()->route('artist.commission.show', $commission);
    }
}
