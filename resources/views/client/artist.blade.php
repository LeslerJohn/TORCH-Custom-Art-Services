<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
        <div class="flex items-center justify-between w-full mb-4">
            <h2 class="text-xl font-bold">Artists</h2>

            <!-- Search Form -->
            <form method="GET" action="{{ route('client.artist') }}" class="flex items-center max-w-sm mr-8">
                <input type="text" name="search" id="search"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5"
                    placeholder="Search artist name..." value="{{ request('search') }}" />
                <button type="submit" class="p-2.5 ms-2 text-white bg-blue-700 rounded-lg">Search</button>
            </form>
        </div>

        <!-- Filters -->
        <form method="GET" action="{{ route('client.artist') }}" class="mb-4">
            <div class="flex items-center gap-2 overflow-x-auto whitespace-nowrap py-2 border rounded-lg shadow-sm">

                <!-- Verified -->
                <button type="submit" name="verified" value="1"
                    class="px-4 py-1 text-black font-medium rounded-full 
                    {{ request('verified') == '1' ? 'bg-black text-white' : 'bg-gray-200 text-black' }}">
                    Verified
                </button>

                <!-- Availability -->
                <button type="submit" name="available" value="1"
                    class="px-4 py-1 border rounded-full 
                    {{ request('available') == '1' ? 'bg-black text-white' : 'bg-gray-200 text-black' }}">
                    Availability
                </button>

                <!-- Sort Options -->
                <button type="submit" name="sort" value="random"
                    class="px-4 py-1 border rounded-full 
                    {{ request('sort') == 'random' ? 'bg-black text-white' : 'bg-gray-200 text-black' }}">
                    Random
                </button>
                <button type="submit" name="sort" value="latest"
                    class="px-4 py-1 border rounded-full 
                    {{ request('sort') == 'latest' ? 'bg-black text-white' : 'bg-gray-200 text-black' }}">
                    Latest
                </button>

                <!-- Category Filter -->
                <select name="category" onchange="this.form.submit()"
                    class="px-4 py-1 border rounded-full bg-gray-200 text-black">
                    <option value="">All Categories</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>

                <!-- Tags (Scrollable) -->
                <div class="flex items-center gap-2 overflow-x-auto">
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
            </div>
        </form>


        <!-- Artist List -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-4">
            @forelse ($artists as $artist)
                <div class="relative w-full h-[250px] rounded-lg overflow-hidden shadow-lg">
                    <a href="{{ route('artist.profile', $artist) }}">
                        <img src="{{ $artist->user->coverImage ? asset('storage/' . $artist->user->coverImage->path) : asset('images/default.image.jpg') }}"
                            class="w-full h-full object-cover">

                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>

                        <div class="absolute top-4 left-4 px-2 py-1 rounded text-white text-xs font-semibold"
                            style="background-color: {{ $artist->available ? 'green' : 'red' }}">
                            {{ $artist->available ? 'Open' : 'Closed' }}
                        </div>

                        <div class="absolute bottom-4 left-4 text-white">
                            <div class="flex items-center gap-2">
                                <img src="{{ asset('images/profile.default.jpg') }}"
                                    class="w-8 h-8 rounded-full border border-white">
                                <div>
                                    <p class="text-sm font-medium">{{ $artist->user->name ?? 'John Doe' }}</p>
                                    <p class="text-sm text-gray-400">{{ '@' . $artist->username }}</p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <p class="text-gray-500">No artists found.</p>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $artists->withQueryString()->links() }}
        </div>
    </div>
</x-app-layout>
