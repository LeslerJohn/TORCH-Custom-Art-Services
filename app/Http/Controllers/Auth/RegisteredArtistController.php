<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ArtistPortfolio;
use App\Models\ArtistProfile;
use App\Models\Attachment;
use App\Models\ClientProfile;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredArtistController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $tags = Tag::all();
        return view('auth.register-artist', compact('tags'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        //dd($request->tags);
        $request->merge(['email' => strtolower($request->email)]);

        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'birthdate' => ['required', 'date'],
            'gender' => ['required', 'string', 'max:255'],
            'contact_number' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255'],
            'bio' => ['required', 'string'],
            'portfolio' => ['nullable', 'file', 'mimes:pdf,doc,docx'],
            'portfolio_link' => ['nullable', 'url'],
            'tags' => ['nullable'],
        ]);

        $portfolio = null;
        if ($request->hasFile('portfolio')) {
            $file = $request->file('portfolio');
            $filePath = $file->store('portfolios', 'public');
            $portfolio = [
            'file_path' => $filePath,
            'file_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getClientMimeType(),
            ];
        }

        $user = User::create([
            'name' => trim($request->first_name . ' ' . ($request->middle_name ? $request->middle_name . ' ' : '') . $request->last_name),
            'email' => $request->email,
            'phone_number' => $request->contact_number,
            'password' => Hash::make($request->password),
            'role' => 'artist',
        ]);

        $client = ClientProfile::create([
            'id' => $user->id,
            'rating' => 0,
            'is_suspended' => false,
        ]);

        $artist = ArtistProfile::create([
            'id' => $user->id,
            'birthdate' => $request->birthdate,
            'gender' => $request->gender,
            'location' => $request->location,
            'bio' => $request->bio,
            'username' => $request->username,
            'status' => 'pending',
            'is_suspended' => false,
            'rating' => 0,
            'available' => true,
        ]);

        if ($portfolio) {
            $newPortfolio = Attachment::create(['path' => $portfolio['file_path'], 'filename' => $portfolio['file_name'], 'mime_type' => $portfolio['mime_type']]);
            ArtistPortfolio::create([
                'artist_id' => $artist->id,
                'portfolio_id' => $newPortfolio->id,
                'link' => $request->portfolio_link,
                'status' => 'pending',
            ]);
        }

        if (!empty($request->tags) && count($request->tags) > 0) {
            $tags = array_filter(explode(',', $request->tags[0])); // Remove empty values
            if (!empty($tags)) {
                $artist->tags()->attach($tags);
            }
        }        

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
