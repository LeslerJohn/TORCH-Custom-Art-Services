<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
        <div class="flex items-center justify-between w-full mb-4">
            <h2 class="text-xl font-bold">Artworks</h2>
        </div>

        <!-- Filters -->
        <form method="GET" action="{{ route('client.artwork') }}" class="mb-4">
            <div class="flex items-center gap-2 overflow-x-auto whitespace-nowrap py-2 border rounded-lg shadow-sm">

                <!-- Search -->
                <input type="text" name="search" placeholder="Search by title..."
                    class="px-4 py-1 border rounded-lg bg-gray-200 text-black" value="{{ request('search') }}"
                    onchange="this.form.submit()">

                <!-- Status Filter -->
                <select name="status" onchange="this.form.submit()"
                    class="px-4 py-1 border rounded-lg bg-gray-200 text-black">
                    <option value="">All Status</option>
                    <option value="sale" {{ request('status') == 'sale' ? 'selected' : '' }}>For Sale</option>
                    <option value="sold" {{ request('status') == 'sold' ? 'selected' : '' }}>Sold</option>
                </select>

                <!-- Showcase -->
                <button type="submit" name="showcase" value="1"
                    class="px-4 py-1 border rounded-full {{ request('showcase') ? 'bg-black text-white' : 'bg-gray-200 text-black' }}">
                    Showcases
                </button>

                <!-- Category Filter -->
                <select name="category" onchange="this.form.submit()"
                    class="px-4 py-1 border rounded-lg bg-gray-200 text-black">
                    <option value="">All Categories</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>

                <!-- Tags (Scrollable) -->
                <div class="flex items-center gap-2 overflow-x-auto no-scrollbar">
                    @foreach ($tags as $tag)
                        <label
                            class="px-4 py-1 border rounded-full cursor-pointer
                    {{ in_array($tag->id, request()->input('tags', [])) ? 'bg-black text-white' : 'bg-gray-200 text-black' }}">
                            <input type="checkbox" name="tags[]" value="{{ $tag->id }}" class="hidden"
                                onchange="this.form.submit()"
                                {{ in_array($tag->id, request()->input('tags', [])) ? 'checked' : '' }}>
                            {{ $tag->name }}
                        </label>
                    @endforeach
                </div>

                <!-- Price Range -->
                <div class="flex items-center gap-2">
                    <input type="number" name="min_price" placeholder="Min Price"
                        class="w-24 px-2 py-1 border rounded-lg bg-gray-200 text-black"
                        value="{{ request('min_price') }}" onchange="this.form.submit()">
                    <input type="number" name="max_price" placeholder="Max Price"
                        class="w-24 px-2 py-1 border rounded-lg bg-gray-200 text-black"
                        value="{{ request('max_price') }}" onchange="this.form.submit()">
                </div>

                <!-- Sort Options -->
                <button type="submit" name="sort" value="random"
                    class="px-4 py-1 border rounded-full {{ request('sort') == 'random' ? 'bg-black text-white' : 'bg-gray-200 text-black' }}">
                    Random
                </button>
                <button type="submit" name="sort" value="latest"
                    class="px-4 py-1 border rounded-full {{ request('sort') == 'latest' ? 'bg-black text-white' : 'bg-gray-200 text-black' }}">
                    Latest
                </button>

            </div>
        </form>


        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @if ($artworks->count() > 0)
                @foreach ($artworks as $artwork)
                    <div class="relative w-full h-[250px] rounded-lg overflow-hidden shadow-lg">
                        <a href="{{ route('artwork.show', $artwork) }}">
                            <!-- Background Image -->
                            <img src="{{ $artwork->images->first()?->attachment ? asset('storage/' . $artwork->images->first()->attachment->path) : asset('images/default-image.jpg') }}"
                                alt="{{ $artwork->title }}" class="w-full h-full object-cover">

                            <!-- Overlay -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>

                            <!-- Text Content -->
                            <div class="absolute bottom-4 left-4 text-white">
                                <h2 class="text-lg font-bold">{{ $artwork->title }}</h2>
                                <p class="text-sm">| {{ $artwork->category->name }}</p>

                                <!-- Artist Info -->
                                <div class="flex items-center gap-2 mt-2">
                                    <img src="{{ asset('images/profile.default.jpg') }}" alt="Artist"
                                        class="w-6 h-6 rounded-full border border-white">
                                    <p class="text-sm font-medium flex items-center">
                                        {{ $artwork->artist->user->name }}
                                    </p>
                                </div>
                            </div>

                            <!-- Price -->
                            <div class="absolute bottom-4 right-4 text-white text-lg font-semibold">
                                <span class="text-xl">₱{{ number_format($artwork->price, 0, '.', ',') }}</span>
                            </div>
                        </a>
                    </div>
                @endforeach
            @else
                <div class="col-span-full text-center text-gray-500 py-8">
                    <h3 class="text-lg font-semibold">No artworks found</h3>
                    <p class="text-sm">Try adjusting your filters or search criteria.</p>

                    <h4 class="mt-6 text-lg font-semibold text-gray-700">Explore Featured Artworks</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-4">
                        @foreach ($featuredArtworks as $artwork)
                            <div class="relative w-full h-[250px] rounded-lg overflow-hidden shadow-lg">
                                <a href="{{ route('artwork.show', $artwork) }}">
                                    <img src="{{ $artwork->images->first()?->attachment ? asset('storage/' . $artwork->images->first()->attachment->path) : asset('images/default-image.jpg') }}"
                                        alt="{{ $artwork->title }}" class="w-full h-full object-cover">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                                    <div class="absolute bottom-4 left-4 text-white">
                                        <h2 class="text-lg font-bold">{{ $artwork->title }}</h2>
                                        <p class="text-sm">| {{ $artwork->category->name }}</p>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>


        <!-- Pagination -->
        <div class="mt-6">
            {{ $artworks->withQueryString()->links() }}
        </div>
    </div>
</x-app-layout>

<style>
    /* Hide scrollbar for Chrome, Safari and Opera */
.no-scrollbar::-webkit-scrollbar {
    display: none;
}
</style>
