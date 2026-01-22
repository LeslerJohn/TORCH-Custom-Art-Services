<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payout;
use Illuminate\Http\Request;

class PayoutController extends Controller
{
    public function index()
    {
        $payouts = Payout::with(['artist', 'artist.user'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.payout.index', compact('payouts'));
    }

    public function show(Payout $payout)
    {
        $payout->load('artist.user');
        return view('admin.payout.show', compact('payout'));
    }

    public function update(Request $request, Payout $payout)
    {
        if ($payout->status === 'ready') {
            $payout->update(['status' => 'completed']);
            return redirect()->route('admin.payout.index')->with('success', 'Payout completed successfully.');
        }

        return redirect()->route('admin.payout.index')->with('error', 'Payout cannot be processed.');
    }

    public function bulkPayAll()
    {
        $payouts = Payout::where('status', 'ready')->get();
        foreach ($payouts as $payout) {
            $payout->update(['status' => 'completed']);
        }
        return redirect()->route('admin.payout.index')->with('success', 'All ready payouts have been processed.');
    }

    public function bulkPayByArtist($artistId)
    {
        $payouts = Payout::where('status', 'ready')->where('artist_id', $artistId)->get();
        foreach ($payouts as $payout) {
            $payout->update(['status' => 'completed']);
        }
        return redirect()->route('admin.payout.index')->with('success', 'All ready payouts for the selected artist have been processed.');
    }

    public function processPayout(Payout $payout)
    {
        if ($payout->status !== 'ready') {
            return back()->with('error', 'Payout can only be processed if the status is "ready".');
        }

        // Simulate payout processing logic
        $payout->update([
            'status' => 'completed',
            'transaction_id' => 'TXN-' . uniqid(),
        ]);

        return back()->with('success', 'Payout processed successfully.');
    }

    public function processAllReadyPayouts()
    {
        $readyPayouts = Payout::where('status', 'ready')->get();

        foreach ($readyPayouts as $payout) {
            $payout->update([
                'status' => 'completed',
                'transaction_id' => 'TXN-' . uniqid(),
            ]);
        }

        return back()->with('success', 'All ready payouts processed successfully.');
    }
}
