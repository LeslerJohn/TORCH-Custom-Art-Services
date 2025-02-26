<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
        <div class="flex items-center justify-between w-full mb-4">
            <h2 class="text-xl font-bold">Artists</h2>

            <!-- Search Form -->
            <form method="GET" action="{{ route('client.artist') }}" class="flex items-center max-w-sm mr-8">
                <input type="text" name="search" id="search"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full ps-10 p-2.5"
                    placeholder="Search artist name..." value="{{ request('search') }}" />
                <button type="submit" class="p-2.5 ms-2 text-white bg-orange-600 hover:bg-orange-700 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search">
                        <circle cx="11" cy="11" r="8" />
                        <path d="m21 21-4.3-4.3" />
                    </svg>
                </button>
            </form>

        </div>

        <!-- Selected Tags Section -->
        @if(request()->has('tags'))
        <div class="flex flex-wrap gap-2 mb-4">
            @foreach(request()->input('tags', []) as $selectedTagId)
            @php
            $selectedTag = $tags->firstWhere('id', $selectedTagId);
            @endphp
            @if($selectedTag)
            <span class="flex items-center px-3 py-1 bg-black text-white text-sm rounded-full">
                {{ $selectedTag->name }}
                <a href="{{ route('client.artist', array_merge(request()->except('tags'), ['tags' => array_diff(request()->input('tags', []), [$selectedTagId])])) }}"
                    class="ml-2 text-white hover:text-gray-300">
                    ✕
                </a>
            </span>
            @endif
            @endforeach
        </div>
        @endif

        <!-- Filters -->
        <form method="GET" action="{{ route('client.artist') }}" class="mb-4">
            <div class="flex items-center gap-3 whitespace-nowrap py-2 border rounded-lg shadow-sm px-4 overflow-hidden">

                <!-- Verified -->
                <button type="submit" name="verified" value="1"
                    class="px-5 py-2 border rounded-full 
                    {{ request('verified') == '1' ? 'bg-black text-white' : 'bg-gray-200 text-black' }}">
                    Verified
                </button>

                <!-- Availability -->
                <button type="submit" name="available" value="1"
                    class="px-5 py-2 border rounded-full 
                    {{ request('available') == '1' ? 'bg-black text-white' : 'bg-gray-200 text-black' }}">
                    Availability
                </button>

                <!-- Sort Options -->
                <button type="submit" name="sort" value="random"
                    class="px-5 py-2 border rounded-full 
                    {{ request('sort') == 'random' ? 'bg-black text-white' : 'bg-gray-200 text-black' }}">
                    Random
                </button>
                <button type="submit" name="sort" value="latest"
                    class="px-5 py-2 border rounded-full 
                    {{ request('sort') == 'latest' ? 'bg-black text-white' : 'bg-gray-200 text-black' }}">
                    Latest
                </button>

                <!-- Category Filter -->
                <select name="category" onchange="this.form.submit()"
                    class="px-5 py-2 border rounded-full bg-gray-200 text-black">
                    <option value="">All Categories</option>
                    @foreach ($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ request('category') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                    @endforeach
                </select>

                <!-- Tags Section with Smooth Navigation -->
                <div x-data="{
        scrollAmount: 300, 
        showLeft: false, 
        showRight: false,
        updateButtons() {
            this.showLeft = this.$refs.tagsContainer.scrollLeft > 0;
            this.showRight = this.$refs.tagsContainer.scrollLeft < (this.$refs.tagsContainer.scrollWidth - this.$refs.tagsContainer.clientWidth);
        },
        scrollLeft() {
            this.$refs.tagsContainer.scrollBy({ left: -this.scrollAmount, behavior: 'smooth' });
            setTimeout(() => this.updateButtons(), 300);
        },
        scrollRight() {
            this.$refs.tagsContainer.scrollBy({ left: this.scrollAmount, behavior: 'smooth' });
            setTimeout(() => this.updateButtons(), 300);
        }
    }"
                    x-init="$nextTick(() => updateButtons())"
                    class="relative flex items-center w-full max-w-xl">

                    <!-- Left Button (Hidden if no left scroll available) -->
                    <button type="button" @click="scrollLeft()" x-show="showLeft"
                        class="absolute left-0 inset-y-2 px-2 bg-gray-300 hover:bg-gray-400 transition-opacity duration-300 rounded-lg flex items-center justify-center h-10 w-10 shadow-md">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-left">
                            <path d="m15 18-6-6 6-6" />
                        </svg>
                    </button>

                    <!-- Tags Container -->
                    <div x-ref="tagsContainer" @scroll="updateButtons()"
                        class="flex gap-3 overflow-x-auto scrollbar-hide px-12 w-full py-2"
                        style="scrollbar-width: none; -ms-overflow-style: none;">
                        @foreach ($tags as $tag)
                        <label class="px-5 py-2 border rounded-full cursor-pointer 
            {{ in_array($tag->id, request()->input('tags', [])) ? 'bg-black text-white' : 'bg-gray-200 text-black' }}">
                            <input type="checkbox" name="tags[]" value="{{ $tag->id }}" class="hidden"
                                onchange="this.form.submit()"
                                {{ in_array($tag->id, request()->input('tags', [])) ? 'checked' : '' }}>
                            {{ $tag->name }}
                        </label>
                        @endforeach
                    </div>

                    <!-- Right Button (Hidden if no right scroll available) -->
                    <button type="button" @click="scrollRight()" x-show="showRight"
                        class="absolute right-0 inset-y-2 px-2 bg-gray-300 hover:bg-gray-400 transition-opacity duration-300 rounded-lg flex items-center justify-center h-10 w-10 shadow-md">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right">
                            <path d="m9 18 6-6-6-6" />
                        </svg>
                    </button>
                </div>

            </div>
        </form>

        <!-- Skeleton Loader (Initially Visible) -->
        <div id="skeleton-loader" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-4">
            @for ($i = 0; $i < 6; $i++)
                <div class="relative w-full h-[250px] rounded-lg overflow-hidden shadow-lg bg-gray-200 animate-pulse">
                <div class="w-full h-full bg-gray-300"></div>
                <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                <div class="absolute top-4 left-4 px-2 py-1 rounded text-transparent bg-gray-400 w-16 h-5"></div>
                <div class="absolute bottom-4 left-4 flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-gray-400"></div>
                    <div>
                        <div class="w-24 h-4 bg-gray-400 rounded-md"></div>
                        <div class="w-16 h-3 bg-gray-300 rounded-md mt-1"></div>
                    </div>
                </div>
        </div>
        @endfor
    </div>

    <!-- Artist List -->
    <div id="artist-list" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-4 hidden">
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

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            setTimeout(() => {
                document.getElementById("skeleton-loader").classList.add("hidden");
                document.getElementById("artist-list").classList.remove("hidden");
            }, 1500);
        });
    </script>

    <!-- Hide Scrollbar -->
    <style>
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
    </style>
</x-app-layout>