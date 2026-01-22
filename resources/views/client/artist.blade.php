<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between w-full mb-4">
            <!-- Back Button and Title -->
            <div class="mb-4 sm:mb-0 pt-4 flex items-center">
                <button onclick="window.history.back()"
                    class="flex items-center justify-center w-10 h-10 rounded-full bg-gray-200 hover:bg-gray-300 transition-colors mr-4">
                    <svg class="w-6 h-6 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 12h14M5 12l4-4m-4 4 4 4" />
                    </svg>
                </button>
                <h2 class="text-xl font-bold">Artists</h2>
            </div>

            <!-- Search Form -->
            <form method="GET" action="{{ route('client.artist') }}" class="w-full sm:w-auto flex items-center max-w-sm">
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
            <div class="flex flex-wrap items-center gap-2 sm:gap-3 p-3 border rounded-lg shadow-sm">

                <!-- Verified -->
                <button type="submit" name="verified" value="1"
                    class="px-5 py-2 border rounded-full w-full sm:w-auto text-center
            {{ request('verified') == '1' ? 'bg-black text-white' : 'bg-gray-200 text-black' }}">
                    Verified
                </button>

                <!-- Availability -->
                <button type="submit" name="available" value="1"
                    class="px-5 py-2 border rounded-full w-full sm:w-auto text-center
            {{ request('available') == '1' ? 'bg-black text-white' : 'bg-gray-200 text-black' }}">
                    Availability
                </button>

                <!-- Sort Options -->
                <button type="submit" name="sort" value="random"
                    class="px-5 py-2 border rounded-full w-full sm:w-auto text-center
            {{ request('sort') == 'random' ? 'bg-black text-white' : 'bg-gray-200 text-black' }}">
                    Random
                </button>
                <button type="submit" name="sort" value="latest"
                    class="px-5 py-2 border rounded-full w-full sm:w-auto text-center
            {{ request('sort') == 'latest' ? 'bg-black text-white' : 'bg-gray-200 text-black' }}">
                    Latest
                </button>

                <!-- Category Filter -->
                <select name="category" onchange="this.form.submit()"
                    class="px-5 py-2 border rounded-full bg-gray-200 text-black w-full sm:w-auto">
                    <option value="">All Categories</option>
                    @foreach ($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ request('category') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Tags Section with Horizontal Scroll -->
            <div x-data="{
            scrollAmount: 200, 
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
                class="relative flex items-center w-full mt-3">

                <!-- Left Scroll Button -->
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
                    <label class="px-5 py-2 border rounded-full cursor-pointer whitespace-nowrap
                {{ in_array($tag->id, request()->input('tags', [])) ? 'bg-black text-white' : 'bg-gray-200 text-black' }}">
                        <input type="checkbox" name="tags[]" value="{{ $tag->id }}" class="hidden"
                            onchange="this.form.submit()"
                            {{ in_array($tag->id, request()->input('tags', [])) ? 'checked' : '' }}>
                        {{ $tag->name }}
                    </label>
                    @endforeach
                </div>

                <!-- Right Scroll Button -->
                <button type="button" @click="scrollRight()" x-show="showRight"
                    class="absolute right-0 inset-y-2 px-2 bg-gray-300 hover:bg-gray-400 transition-opacity duration-300 rounded-lg flex items-center justify-center h-10 w-10 shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right">
                        <path d="m9 18 6-6-6-6" />
                    </svg>
                </button>
            </div>

        </form>
        <!-- Skeleton Loader (Initially Visible) -->
        <div id="skeleton-loader" class="grid grid-cols-2 xs:grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mt-4">
            @for ($i = 0; $i < 8; $i++)
                <div class="relative w-full h-[220px] sm:h-[250px] rounded-lg overflow-hidden shadow-lg bg-gray-200 animate-pulse">
                <!-- Simulated Image -->
                <div class="w-full h-full bg-gray-300"></div>

                <!-- Gradient Overlay -->
                <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>

                <!-- Placeholder for Availability Badge -->
                <div class="absolute top-3 left-3 px-2 py-1 rounded bg-gray-400 w-16 h-5"></div>

                <!-- Simulated Artist Info -->
                <div class="absolute bottom-3 left-3 flex items-center gap-2">
                    <!-- Profile Picture Placeholder -->
                    <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-gray-400"></div>

                    <!-- Name & Username Placeholder -->
                    <div>
                        <div class="w-24 h-4 bg-gray-400 rounded-md"></div>
                        <div class="w-16 h-3 bg-gray-300 rounded-md mt-1"></div>
                    </div>
                </div>
        </div>
        @endfor
    </div>



    <!-- Artist List -->
    <div id="artist-list" class="grid grid-cols-2 xs:grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mt-4 hidden">
        @forelse ($artists as $artist)
        <div class="relative w-full h-[220px] sm:h-[250px] rounded-lg overflow-hidden shadow-lg bg-white">
            <a href="{{ route('artist.profile', $artist) }}" class="block w-full h-full">
                <!-- Artist Cover Image -->
                <img src="{{ $artist->user->coverImage ? asset('storage/' . $artist->user->coverImage->path) : asset('images/default.image.jpg') }}"
                    class="w-full h-full object-cover">

                <!-- Overlay Gradient -->
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>

                <!-- Availability Badge -->
                <div class="absolute top-3 left-3 px-2 py-1 text-xs font-semibold rounded text-white"
                    style="background-color: {{ $artist->available ? 'green' : 'red' }}">
                    {{ $artist->available ? 'Open' : 'Closed' }}
                </div>

                <!-- Artist Info -->
                <div class="absolute bottom-3 left-3 flex items-center gap-2 text-white">
                    <!-- Profile Image -->
                    <img src="{{$artist->user->profileImage ? asset('storage/' . $artist->user->profileImage->path) : asset('images/default.image.jpg') }}"
                        class="w-8 h-8 sm:w-10 sm:h-10 rounded-full object-cover border-2 border-white shadow">

                    <!-- Name & Username -->
                    <div class="leading-tight">
                        <p class="text-xs sm:text-sm font-semibold">{{ $artist->user->name ?? 'John Doe' }}</p>
                        <p class="text-xs sm:text-sm text-gray-300">{{ '@' . $artist->username }}</p>
                    </div>
                </div>
            </a>
        </div>
        @empty
        <p class="text-gray-500 text-center col-span-full">No artists found.</p>
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

    <footer>
        <div>
            @include('layouts.footer')
        </div>
    </footer>

</x-app-layout>



<!-- Hide Scrollbar -->
<style>
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
</style>