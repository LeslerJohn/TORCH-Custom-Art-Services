<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\ArtistProfile;
use App\Models\ClientLiked;
use App\Models\ClientProfile;
use App\Models\CommissionReview;
use App\Models\Order;
use App\Models\OrderReview;
use GuzzleHttp\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function showClientProfile()
    {
        $client = ClientProfile::where('id', Auth::id())->first();
        $collections = Order::where('client_id', Auth::id())->get();
        $liked = ClientLiked::where('client_id', Auth::id())->get();
        return view('client.profile.show', compact('client', 'collections', 'liked'));
    }

    public function showArtistProfile(ArtistProfile $artist)
    {
        $services = $artist->services()->get();
        $artworks = $artist->artworks()->get();
        $isOwner = Auth::check() && Auth::id() === $artist->id;

        $order_reviews = OrderReview::whereHas('order.items.artwork', function ($query) use ($artist) {
            $query->whereHas('artist', function ($q) use ($artist) {
                $q->where('id', $artist->id);
            });
        })
            ->whereNotNull('review')
            ->with([
                'order.client',
                'order.items.artwork.images.attachment',
                'order.items.artwork.category',
                'order.items.artwork.artist'
            ])
            ->latest()
            ->get();

        $commission_reviews = CommissionReview::whereHas('commission.request', function ($query) use ($artist) {
            $query->whereHas('service', function ($q) use ($artist) {
                $q->whereHas('artist', function ($subQ) use ($artist) {
                    $subQ->where('id', $artist->id);
                });
            });
        })
            ->whereNotNull('review')
            ->with([
                'commission.request.client',
                'commission.request.images.attachment',
                'commission.request.service.category',
                'commission.request.service.artist'
            ])
            ->latest()
            ->get();

        $reviews = $commission_reviews->merge($order_reviews);

        $collections = $isOwner ? Order::whereHas('items.artwork', function ($query) use ($artist) {
            $query->where('artist_id', $artist->id);
        })->get() : collect();
        $liked = $isOwner ? ClientLiked::where('artist_id', $artist->id)->get() : collect();

        return view('artist.profile.show', compact('artist', 'services', 'artworks', 'reviews', 'collections', 'liked', 'isOwner'));
    }
}
