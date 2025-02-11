<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ArtistProfile;
use App\Models\Artwork;
use App\Models\Service;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $artworks = Artwork::latest()->get();
        $artists = ArtistProfile::latest()->get();
        $services = Service::latest()->get();

        return view('dashboard', compact('artworks', 'artists', 'services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show_artwork(Artwork $artwork)
    {
        return view('client.show-artwork', compact('artwork'));
    }

    public function show_service(Service $service)
    {
        return view('client.show-service', compact('service'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
