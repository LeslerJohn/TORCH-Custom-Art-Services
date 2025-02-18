<?php

namespace App\Http\Controllers\Artist;

use App\Models\Service;
use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\Category;
use App\Models\ServiceImage;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::where('artist_id', Auth::user()->id)->get();
        return view('artist.service.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('artist.service.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:category,id',
            'price_rate' => 'required|numeric',
            'rush_price_rate' => 'required|numeric',
            'normal_timeframe' => 'required|numeric',
            'rush_timeframe' => 'required|numeric',
            'tags' => 'nullable',
            'thumbnails.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5120',
        ]);

        $service = Service::create([
            'artist_id' => Auth::user()->id,
            'category_id' => $request->category_id,
            'price_rate' => $request->price_rate,
            'rush_price_rate' => $request->rush_price_rate,
            'normal_timeframe' => $request->normal_timeframe,
            'rush_timeframe' => $request->rush_timeframe,
        ]);

        if ($request->hasFile('thumbnails')) {
            foreach ($request->file('thumbnails') as $image) {
                $path = $image->store('uploads', 'public');

                $attachment = Attachment::create([
                    'filename' => $image->getClientOriginalName(),
                    'path' => $path,
                    'mime_type' => $image->getMimeType(),
                ]);
    
                ServiceImage::create([
                    'service_id' => $service->id,
                    'attachment_id' => $attachment->id,
                ]);
            }
        }

        if ($request->tags) {
            $tags = explode(',', $request->tags[0]);
            $service->tags()->attach($tags);
        }

        return redirect()->route('artist.service.index')->with('success', 'Service created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        return view('artist.service.show', compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        $categories = Category::all();
        return view('artist.service.edit', compact('service', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        $request->validate([
            'category_id' => 'required|exists:category,id',
            'price_rate' => 'required|numeric',
            'rush_price_rate' => 'required|numeric',
            'normal_timeframe' => 'required|numeric',
            'rush_timeframe' => 'required|numeric',
            'tags' => 'nullable',
            'thumbnails.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5120',
        ]);

        $service->update([
            'category_id' => $request->category_id,
            'price_rate' => $request->price_rate,
            'rush_price_rate' => $request->rush_price_rate,
            'normal_timeframe' => $request->normal_timeframe,
            'rush_timeframe' => $request->rush_timeframe,
        ]);

        // Check if there are new thumbnails uploaded
        if ($request->hasFile('thumbnails')) {
            // Delete existing attachments and their associated service images
            foreach ($service->images as $serviceImage) {
            // Delete the file from storage
            Storage::disk('public')->delete($serviceImage->attachment->path);
            
            // Delete the attachment and service image records
            $serviceImage->attachment->delete();
            $serviceImage->delete();
            }

            // Store new thumbnails
            foreach ($request->file('thumbnails') as $image) {
            $path = $image->store('uploads', 'public');

            $attachment = Attachment::create([
                'filename' => $image->getClientOriginalName(),
                'path' => $path,
                'mime_type' => $image->getMimeType(),
            ]);

            ServiceImage::create([
                'service_id' => $service->id,
                'attachment_id' => $attachment->id,
            ]);
            }
        }

        if ($request->tags) {
            $tags = explode(',', $request->tags[0]);
            $service->tags()->sync($tags);
        }

        return redirect()->route('artist.service.index')->with('success', 'Service updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('artist.service.index')->with('success', 'Service deleted successfully');
    }
}
