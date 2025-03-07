<?php

namespace App\Http\Controllers\Artist;

use App\Models\Artwork;
use App\Http\Controllers\Controller;
use App\Models\ArtworkImage;
use App\Models\Attachment;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArtworkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $artworks = Artwork::where('artist_id', Auth::user()->id)->get();
        return view('artist.artwork.index', compact('artworks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('artist.artwork.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:category,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'width' => 'required|numeric',
            'height' => 'required|numeric',
            'unit' => 'required|string',
            'price' => 'required|numeric',
            'is_showcase' => 'nullable|boolean',
            'tags' => 'nullable',
            'thumbnails.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5120',
        ]);

        $artwork = Artwork::create([
            'artist_id' => Auth::user()->id,
            'category_id' => $request->category_id,
            'is_showcase' => $request->is_showcase ?? false,
            'title' => $request->title,
            'description' => $request->description,
            'width' => $request->width,
            'height' => $request->height,
            'unit' => $request->unit,
            'price' => $request->price,
        ]);

        if ($request->hasFile('thumbnails')) {
            foreach ($request->file('thumbnails') as $image) {
                $path = $image->store('uploads', 'public');

                $attachment = Attachment::create([
                    'filename' => $image->getClientOriginalName(),
                    'path' => $path,
                    'mime_type' => $image->getMimeType(),
                ]);
    
                ArtworkImage::create([
                    'artwork_id' => $artwork->id,
                    'attachment_id' => $attachment->id,
                ]);
            }
        }

        if ($request->tags) {
            $tags = explode(',', $request->tags[0]);
            $artwork->tags()->attach($tags);
        }

        return redirect()->route('artist.artwork.index')->with('success', 'Artwork created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Artwork $artwork)
    {
        return view('artist.artwork.show', compact('artwork'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Artwork $artwork)
    {
        $categories = Category::all();
        return view('artist.artwork.edit', compact('artwork', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Artwork $artwork)
    {
        $request->validate([
            'category_id' => 'required|exists:category,id',
            'is_showcase' => 'nullable|boolean',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'width' => 'required|numeric',
            'height' => 'required|numeric',
            'unit' => 'required|string',
            'price' => 'required|numeric',
            'tags' => 'nullable',
            'thumbnails.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5120',
        ]);

        $artwork->update([
            'category_id' => $request->category_id,
            'is_showcase' => $request->is_showcase ?? false,
            'title' => $request->title,
            'description' => $request->description,
            'width' => $request->width,
            'height' => $request->height,
            'unit' => $request->unit,
            'price' => $request->price,
        ]);

        // Check if there are new thumbnails uploaded
        if ($request->hasFile('thumbnails')) {
            // Delete existing attachments and their associated service images
            foreach ($artwork->images as $artworkImage) {
            // Delete the file from storage
            Storage::disk('public')->delete($artworkImage->attachment->path);
            
            // Delete the attachment and service image records
            $artworkImage->attachment->delete();
            $artworkImage->delete();
            }

            // Store new thumbnails
            foreach ($request->file('thumbnails') as $image) {
            $path = $image->store('uploads', 'public');

            $attachment = Attachment::create([
                'filename' => $image->getClientOriginalName(),
                'path' => $path,
                'mime_type' => $image->getMimeType(),
            ]);

            ArtworkImage::create([
                'artwork_id' => $artwork->id,
                'attachment_id' => $attachment->id,
            ]);
            }
        }

        if ($request->tags) {
            $tags = explode(',', $request->tags[0]);
            $artwork->tags()->sync($tags);
        }

        return redirect()->route('artist.artwork.index')->with('success', 'Artwork updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Artwork $artwork)
    {
        $artwork->delete();
        return redirect()->route('artist.artwork.index')->with('success', 'Artwork deleted successfully');
    }
}
