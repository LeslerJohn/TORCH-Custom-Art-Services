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
            @for ($i = 0; $i < 6; $i++)
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
                    <img src="{{ asset('images/profile.default.jpg') }}"
                        class="w-8 h-8 sm:w-10 sm:h-10 rounded-full border-2 border-white shadow">

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

    <br><br><br>
    <footer class="mt-auto">
        <div class="flex justify-between items-center max-w-6xl mx-auto sm:px-6 lg:px-8 pb-16">
            <img src="{{ asset('images/torch-full-high-resolution-logo-transparent.png') }}" alt="Torch Logo"
                class="w-32">
            <div class="flex items-center gap-4">
                <a href="">About</a>
                <a href="">Contact</a>
                <a href="">Terms of Service</a>
                <a href="">Privacy Policy</a>
                <a href="">Support</a>
            </div>
            <div class="flex items-center justify-evenly gap-2">
                <a href="">
                    <svg class="w-8 h-8 text-orange-500 " aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                        viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M13.135 6H15V3h-1.865a4.147 4.147 0 0 0-4.142 4.142V9H7v3h2v9.938h3V12h2.021l.592-3H12V6.591A.6.6 0 0 1 12.592 6h.543Z"
                            clip-rule="evenodd" />
                    </svg>
                </a>
                <a href="">
                    <svg class="w-8 h-8 text-orange-500 " aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                        viewBox="0 0 24 24">
                        <path fill="currentColor" fill-rule="evenodd"
                            d="M3 8a5 5 0 0 1 5-5h8a5 5 0 0 1 5 5v8a5 5 0 0 1-5 5H8a5 5 0 0 1-5-5V8Zm5-3a3 3 0 0 0-3 3v8a3 3 0 0 0 3 3h8a3 3 0 0 0 3-3V8a3 3 0 0 0-3-3H8Zm7.597 2.214a1 1 0 0 1 1-1h.01a1 1 0 1 1 0 2h-.01a1 1 0 0 1-1-1ZM12 9a3 3 0 1 0 0 6 3 3 0 0 0 0-6Zm-5 3a5 5 0 1 1 10 0 5 5 0 0 1-10 0Z"
                            clip-rule="evenodd" />
                    </svg>
                </a>
                <a href="">
                    <svg class="w-8 h-8 text-orange-500 " aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                        viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M22 5.892a8.178 8.178 0 0 1-2.355.635 4.074 4.074 0 0 0 1.8-2.235 8.343 8.343 0 0 1-2.605.981A4.13 4.13 0 0 0 15.85 4a4.068 4.068 0 0 0-4.1 4.038c0 .31.035.618.105.919A11.705 11.705 0 0 1 3.4 4.734a4.006 4.006 0 0 0 1.268 5.392 4.165 4.165 0 0 1-1.859-.5v.05A4.057 4.057 0 0 0 6.1 13.635a4.192 4.192 0 0 1-1.856.07 4.108 4.108 0 0 0 3.831 2.807A8.36 8.36 0 0 1 2 18.184 11.732 11.732 0 0 0 8.291 20 11.502 11.502 0 0 0 19.964 8.5c0-.177 0-.349-.012-.523A8.143 8.143 0 0 0 22 5.892Z"
                            clip-rule="evenodd" />
                    </svg>
                </a>
                <a href="">
                    <svg class="w-8 h-8 text-orange-500 " aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                        viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M12.51 8.796v1.697a3.738 3.738 0 0 1 3.288-1.684c3.455 0 4.202 2.16 4.202 4.97V19.5h-3.2v-5.072c0-1.21-.244-2.766-2.128-2.766-1.827 0-2.139 1.317-2.139 2.676V19.5h-3.19V8.796h3.168ZM7.2 6.106a1.61 1.61 0 0 1-.988 1.483 1.595 1.595 0 0 1-1.743-.348A1.607 1.607 0 0 1 5.6 4.5a1.601 1.601 0 0 1 1.6 1.606Z"
                            clip-rule="evenodd" />
                        <path d="M7.2 8.809H4V19.5h3.2V8.809Z" />
                    </svg>
                </a>
            </div>
        </div>
    </footer>

</x-app-layout>



<!-- Hide Scrollbar -->
<style>
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
</style>