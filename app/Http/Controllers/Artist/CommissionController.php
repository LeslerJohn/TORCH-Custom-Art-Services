<?php

namespace App\Http\Controllers\Artist;

use App\Http\Controllers\Controller;
use App\Models\Commission;
use App\Models\Request as ModelsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommissionController extends Controller
{
    public function index()
    {
        $commissions = Commission::whereHas('request.service', function ($query) {
            $query->where('artist_id', Auth::user()->artist->id);
        })->get();

        $requests = ModelsRequest::whereHas('service', function ($query) {
            $query->where('artist_id', Auth::user()->artist->id);
        })->get();

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

        return redirect()->route('artist.request.show', $request);
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

        return redirect()->route('artist.commission.index');
    }

    public function done(Commission $commission) {
        $commission->update([
            'status' => 'done',
        ]);

        return redirect()->route('artist.commission.index');
    }

    public function deliver(Commission $commission) {
        $commission->delivery->update([
            'status' => 'in-transit',
        ]);

        return redirect()->route('artist.commission.index');
    }

    public function delivered(Commission $commission) {
        $commission->delivery->update([
            'status' => 'delivered',
        ]);

        return redirect()->route('artist.commission.index');
    }

    public function draft(Request $request, Commission $commission) {
        $request->validate([
            'description' => 'required|string',
            'image' => 'required|image',
        ]);

        return redirect()->route('artist.commission.index');
    }
}
