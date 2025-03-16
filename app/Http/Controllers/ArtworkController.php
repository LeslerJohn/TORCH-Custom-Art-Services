<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Artwork;
use App\Models\ClientLiked;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArtworkController extends Controller
{
    public function show(Artwork $artwork)
    {
        $user = Auth::user();
        $hasLiked = false;
        if ($user) {
            $hasLiked = ClientLiked::query()
                ->where('client_id', $user->id)
                ->where('artwork_id', $artwork->id)
                ->exists();
        }

        return view('client.show-artwork', compact('artwork', 'hasLiked'));
    }

    public function like(Artwork $artwork)
    {
        ClientLiked::create([
            'client_id' => Auth::user()->id,
            'artwork_id' => $artwork->id,
        ]);

        return back();
    }

    public function unlike(Artwork $artwork)
    {
        ClientLiked::where('client_id', Auth::user()->id)
            ->where('artwork_id', $artwork->id)
            ->delete();

        return back();
    }
}
