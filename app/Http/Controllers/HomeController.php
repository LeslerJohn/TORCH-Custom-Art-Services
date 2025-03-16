<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ArtistProfile;
use App\Models\Artwork;
use App\Models\Category;
use App\Models\ClientLiked;
use App\Models\CommissionReview;
use App\Models\OrderReview;
use App\Models\Service;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $artworks = Artwork::latest()->take(9)->get();
        $artists = ArtistProfile::latest()->take(9)->get();
        $services = Service::latest()->take(9)->get();
        $orderReviews = OrderReview::where('rating', 5)
            ->whereNotNull('review')
            ->with('order.client')
            ->latest()
            ->take(3)
            ->get();

        $commissionReviews = CommissionReview::where('rating', 5)
            ->whereNotNull('review')
            ->with('commission.request.client')
            ->latest()
            ->take(3)
            ->get();

        $reviews = $commissionReviews->merge($orderReviews)->shuffle();
        // dd(compact('artworks', 'artists', 'services', 'reviews'));

        return view('dashboard', compact('artworks', 'artists', 'services', 'reviews'));
    }

    public function artist(Request $request)
    {
        $query = ArtistProfile::with('user');

        // 🔍 Search by name, email, or username
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%");
            })->orWhere('username', 'LIKE', "%{$search}%");
        }

        // 🎯 Filter by Verified Artists
        if ($request->filled('verified')) {
            $query->whereHas('user', function ($q) {
                $q->where('verified', true);
            });
        }

        // 🎯 Filter by Availability (Open / Closed)
        if ($request->has('available')) {
            $query->where('available', $request->available);
        }

        // 🎯 Filter by Category (Artists belong to a category through their services)
        if ($request->filled('category')) {
            $query->whereHas('services', function ($q) use ($request) {
                $q->where('category_id', $request->category);
            });
        }

        // 🎯 Filter by Tags (Artists must offer services with selected tags)
        if ($request->has('tags') && !empty($request->tags)) {
            $tagIds = is_array($request->tags) ? $request->tags : explode(',', $request->tags);
            $query->whereHas('tags', function ($q) use ($tagIds) {
                $q->whereIn('tag.id', $tagIds);
            });
        }

        // 🔀 Sorting (Random / Latest)
        if ($request->input('sort') === 'random') {
            $query->inRandomOrder();
        } else {
            $query->latest();
        }

        // ✅ Get paginated results
        $artists = $query->paginate(9);
        $categories = Category::all();
        $tags = Tag::all();

        return view('client.artist', compact('artists', 'categories', 'tags'));
    }




    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $tags = $request->input('tags');

        $artworks = Artwork::query();
        $artists = ArtistProfile::query();
        $services = Service::query();

        if ($keyword) {
            $artworks->where('title', 'like', "%{$keyword}%")
                ->orWhere('description', 'like', "%{$keyword}%");
            $artists->where('name', 'like', "%{$keyword}%")
                ->orWhere('bio', 'like', "%{$keyword}%");
            $services->where('name', 'like', "%{$keyword}%")
                ->orWhere('description', 'like', "%{$keyword}%");
        }

        if ($tags) {
            $artworks->whereHas('tags', function ($query) use ($tags) {
                $query->whereIn('name', $tags);
            });
            $artists->whereHas('tags', function ($query) use ($tags) {
                $query->whereIn('name', $tags);
            });
            $services->whereHas('tags', function ($query) use ($tags) {
                $query->whereIn('name', $tags);
            });
        }

        $artworks = $artworks->paginate(9);
        $artists = $artists->paginate(9);
        $services = $services->paginate(9);

        return view('client.search-results', compact('artworks', 'artists', 'services', 'keyword', 'tags'));
    }

    public function artwork(Request $request)
    {
        $query = Artwork::with(['artist.user', 'category', 'images.attachment', 'tags']);

        // Filtering logic
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        if ($request->filled('tags')) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->whereIn('tag_id', $request->tags);
            });
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('showcase')) {
            $query->where('is_showcase', true);
        }
        if ($request->filled('min_price') && $request->filled('max_price')) {
            $query->whereBetween('price', [$request->min_price, $request->max_price]);
        }
        if ($request->filled('discounted')) {
            $query->whereHas('discount', function ($q) {
            $q->where('status', 'active');
            });
        }
        if ($request->filled('sort')) {
            $query->orderBy($request->sort == 'latest' ? 'created_at' : 'id', $request->sort == 'latest' ? 'desc' : 'asc');
        }

        // Paginate results
        $artworks = $query->paginate(12);

        // Fetch random artworks for fallback if no results
        $featuredArtworks = Artwork::inRandomOrder()->limit(6)->get();

        return view('client.artwork', [
            'artworks' => $artworks,
            'categories' => Category::all(),
            'tags' => Tag::all(),
            'featuredArtworks' => $featuredArtworks,
        ]);
    }


    public function service(Request $request)
    {
        $query = Service::with(['category', 'tags', 'artist.user', 'images.attachment']);

        // 🎯 Filter by Availability (Open / Closed)
        if ($request->filled('available')) {
            $query->where('status', $request->available ? 'open' : 'closed');
        }

        // 🎯 Filter by Category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // 🎯 Filter by Tags
        if ($request->has('tags') && !empty($request->tags)) {
            $tagIds = is_array($request->tags) ? $request->tags : explode(',', $request->tags);
            $query->whereHas('tags', function ($q) use ($tagIds) {
                $q->whereIn('tag.id', $tagIds);
            });
        }

        // 🔀 Sorting (Random / Latest)
        if ($request->input('sort') === 'random') {
            $query->inRandomOrder();
        } else {
            $query->latest();
        }

        // ✅ Get paginated results
        $services = $query->paginate(9);
        $categories = Category::all();
        $tags = Tag::all();

        return view('client.service', compact('services', 'categories', 'tags'));
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
