<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Address;
use App\Models\ArtistProfile;
use App\Models\Attachment;
use App\Models\ClientLiked;
use App\Models\ClientProfile;
use App\Models\CommissionReview;
use App\Models\Order;
use App\Models\OrderReview;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
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

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // Handle profile image removal
        if ($request->has('remove_profile_image') && $request->remove_profile_image == '1') {
            if ($user->profile_image_id) {
                // Delete the existing profile image from storage
                $profileImage = Attachment::find($user->profile_image_id);
                if ($profileImage) {
                    Storage::disk('public')->delete($profileImage->path);

                    // Remove the foreign key reference before deleting
                    $user->profile_image_id = null;
                    $user->save();

                    // Now delete the attachment
                    $profileImage->delete();
                }
            }
        }

        // Handle cover image removal
        if ($request->has('remove_cover_image') && $request->remove_cover_image == '1') {
            if ($user->cover_image_id) {
                // Delete the existing cover image from storage
                $coverImage = Attachment::find($user->cover_image_id);
                if ($coverImage) {
                    Storage::disk('public')->delete($coverImage->path);

                    // Remove the foreign key reference before deleting
                    $user->cover_image_id = null;
                    $user->save();

                    // Now delete the attachment
                    $coverImage->delete();
                }
            }
        }

        // Handle new profile image upload
        if ($request->hasFile('profile_image')) {
            // Delete the existing profile image if it exists
            if ($user->profile_image_id) {
                $profileImage = Attachment::find($user->profile_image_id);
                if ($profileImage) {
                    Storage::disk('public')->delete($profileImage->path);

                    // Remove the foreign key reference before deleting
                    $user->profile_image_id = null;
                    $user->save();

                    // Now delete the attachment
                    $profileImage->delete();
                }
            }

            // Store the new profile image
            $file = $request->file('profile_image');
            $path = $file->store('profile_images', 'public');
            $attachment = Attachment::create([
                'filename' => $file->getClientOriginalName(),
                'path' => $path,
                'mime_type' => $file->getMimeType(),
            ]);
            $user->profile_image_id = $attachment->id;
        }

        // Handle new cover image upload
        if ($request->hasFile('cover_image')) {
            // Delete the existing cover image if it exists
            if ($user->cover_image_id) {
                $coverImage = Attachment::find($user->cover_image_id);
                if ($coverImage) {
                    Storage::disk('public')->delete($coverImage->path);

                    // Remove the foreign key reference before deleting
                    $user->cover_image_id = null;
                    $user->save();

                    // Now delete the attachment
                    $coverImage->delete();
                }
            }

            // Store the new cover image
            $file = $request->file('cover_image');
            $path = $file->store('cover_images', 'public');
            $attachment = Attachment::create([
                'filename' => $file->getClientOriginalName(),
                'path' => $path,
                'mime_type' => $file->getMimeType(),
            ]);
            $user->cover_image_id = $attachment->id;
        }

        // Update phone number
        if ($request->has('phone_number')) {
            $user->phone_number = $request->input('phone_number');
        }

        // Update artist-specific fields
        if ($user->isArtist()) {
            $artistProfile = $user->artist;
            $artistProfile->location = $request->input('location');
            $artistProfile->birthdate = $request->input('birthdate');
            $artistProfile->gender = $request->input('gender');
            $artistProfile->username = $request->input('username');
            $artistProfile->max_commissions = $request->input('max_commissions');
            $artistProfile->bio = $request->input('bio');
            $artistProfile->save();
        }

        $user->save();

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
        $collections = Order::where('client_id', Auth::id())
            ->where('status', 'completed')
            ->whereHas('items.artwork')
            ->with('items.artwork')
            ->latest()
            ->get();

        $liked = ClientLiked::where('client_id', Auth::id())
            ->with('artwork')
            ->latest()
            ->get();

        return view('client.profile.show', compact('client', 'collections', 'liked'));
    }

    public function showArtistProfile(ArtistProfile $artist)
    {
        $services = $artist->services()->get();
        $artworks = $artist->artworks()->get();
        $isOwner = Auth::check() && Auth::id() === $artist->id;

        $order_reviews = OrderReview::whereHas('order.items.artwork.artist', function ($query) use ($artist) {
            $query->where('id', $artist->id);
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

        $commission_reviews = CommissionReview::whereHas('commission.request.service.artist', function ($query) use ($artist) {
            $query->where('id', $artist->id);
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

        $collections = Order::where('client_id', Auth::id())
            ->where('status', 'completed')
            ->whereHas('items.artwork')
            ->with('items.artwork')
            ->latest()
            ->get();

        $liked = ClientLiked::where('client_id', $artist->id)
            ->with('artwork')
            ->latest()
            ->get();

        return view('artist.profile.show', compact('artist', 'services', 'artworks', 'reviews', 'collections', 'liked', 'isOwner'));
    }

    public function updateAddress(Request $request)
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

        return Redirect::route('profile.edit')->with('success', 'Address updated successfully!');
    }

    public function storeAddress(Request $request, User $user)
    {
        $request->validate([
            'barangay' => 'required|string|max:255',
            'street' => 'required|string|max:255',
            'house_number' => 'required|string|max:255',
        ]);

        $address = Address::create([
            'client_id' => $user->id,
            'barangay' => $request->barangay,
            'street' => $request->street,
            'house_number' => $request->house_number,
        ]);

        return Redirect::route('client.profile')->with('success', 'Address added successfully!');
    }

    public function updatePaymentMethod(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|string|max:255',
            'payment_name' => 'required|string|max:255',
            'payment_number' => 'required|string|max:10',
        ]);

        $user = Auth::user()->artist->payment;
        $user->payment_method = $request->input('payment_method');
        $user->account_name = $request->input('payment_name');
        $user->account_number = $request->input('payment_number');
        $user->save();

        return Redirect::route('profile.edit')->with('status', 'payment-method-updated');
    }
}
