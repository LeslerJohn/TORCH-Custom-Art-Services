<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
        <div class="flex items-center justify-between w-full mb-4">
            <h2 class="text-xl font-bold">Artworks</h2>
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
                <a href="{{ route('client.artwork', array_merge(request()->except('tags'), ['tags' => array_diff(request()->input('tags', []), [$selectedTagId])])) }}"
                    class="ml-2 text-white hover:text-gray-300">
                    ✕
                </a>
            </span>
            @endif
            @endforeach
        </div>
        @endif

        <!-- Filters (Top Row) -->
        <form method="GET" action="{{ route('client.artwork') }}" class="mb-4">
            <div class="flex flex-wrap items-center gap-2 overflow-hidden py-2 border rounded-lg shadow-sm px-3">
                <!-- Search -->
                <input type="text" name="search" placeholder="Search by title..."
                    class="px-4 py-1 border border-gray-300 rounded-md text-black focus:border-gray-400 focus:ring-2 focus:ring-gray-300 transition"
                    value="{{ request('search') }}" onchange="this.form.submit()">

                <!-- Status Filter -->
                <select name="status" onchange="this.form.submit()"
                    class="px-4 py-1 border border-gray-300 rounded-md text-black focus:border-gray-400 focus:ring-2 focus:ring-gray-300 appearance-none transition">
                    <option value="">All Status</option>
                    <option value="sale" {{ request('status') == 'sale' ? 'selected' : '' }}>For Sale</option>
                    <option value="sold" {{ request('status') == 'sold' ? 'selected' : '' }}>Sold</option>
                </select>

                <!-- Showcase Toggle -->
                <button type="submit" name="showcase" value="{{ request('showcase') ? '' : '1' }}"
                    class="px-4 py-1 border border-gray-300 rounded-full transition 
    {{ request('showcase') ? 'bg-black text-white' : 'text-black hover:bg-gray-200' }}">
                    Showcases
                </button>

                <!-- Category Filter -->
                <select name="category" onchange="this.form.submit()"
                    class="px-4 py-1 border border-gray-300 rounded-md text-black focus:border-gray-400 focus:ring-2 focus:ring-gray-300 appearance-none transition">
                    <option value="">All Categories</option>
                    @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                    @endforeach
                </select>

                <!-- Price Range -->
                <div class="flex items-center gap-2">
                    <input type="number" name="min_price" placeholder="Min Price"
                        class="w-24 px-2 py-1 border border-gray-300 rounded-md text-black focus:border-gray-400 focus:ring-2 focus:ring-gray-300 transition"
                        value="{{ request('min_price') }}" onchange="this.form.submit()">
                    <input type="number" name="max_price" placeholder="Max Price"
                        class="w-24 px-2 py-1 border border-gray-300 rounded-md text-black focus:border-gray-400 focus:ring-2 focus:ring-gray-300 transition"
                        value="{{ request('max_price') }}" onchange="this.form.submit()">
                </div>

                <!-- Sort Options -->
                <button type="submit" name="sort"
                    value="{{ request('sort') == 'random' ? '' : 'random' }}"
                    class="px-4 py-1 border border-gray-300 rounded-full transition
    {{ request('sort') == 'random' ? 'bg-black text-white' : 'text-black hover:bg-gray-200' }}">
                    Random
                </button>

                <button type="submit" name="sort"
                    value="{{ request('sort') == 'latest' ? '' : 'latest' }}"
                    class="px-4 py-1 border border-gray-300 rounded-full transition
    {{ request('sort') == 'latest' ? 'bg-black text-white' : 'text-black hover:bg-gray-200' }}">
                    Latest
                </button>

                <!-- Clear Sort (Fixed at the End) -->
                <button type="submit" name="sort" value=""
                    class="px-2 py-2 border rounded-full bg-red-500 text-white hover:bg-red-600 transition ml-auto">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-eraser">
                        <path d="m7 21-4.3-4.3c-1-1-1-2.5 0-3.4l9.6-9.6c1-1 2.5-1 3.4 0l5.6 5.6c1 1 1 2.5 0 3.4L13 21" />
                        <path d="M22 21H7" />
                        <path d="m5 11 9 9" />
                    </svg>
                </button>
            </div>

            <!-- Tags Section with Auto-Hiding Scroll Buttons -->
            <div class="relative mt-2" x-data="{
    scrollAmount: 500, 
    showLeft: false, 
    showRight: false, 
    updateButtons() {
        this.$nextTick(() => {
            let container = this.$refs.tagsContainer;
            this.showLeft = container.scrollLeft > 0;
            this.showRight = container.scrollLeft < (container.scrollWidth - container.clientWidth - 2); 
        });
    },
    scroll(direction) {
        let container = this.$refs.tagsContainer;
        container.scrollBy({ left: direction * this.scrollAmount, behavior: 'smooth' });
        requestAnimationFrame(() => this.updateButtons());
    }
}" x-init="$nextTick(() => updateButtons())">

                <!-- Left Scroll Button -->
                <button type="button" @click="scroll(-1)" x-show="showLeft"
                    class="absolute left-0 top-1/2 transform -translate-y-1/2 px-3 py-2 bg-gray-100 hover:bg-gray-400 rounded-full shadow-md transition"
                    x-transition.opacity>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m15 18-6-6 6-6" />
                    </svg>
                </button>

                <!-- Tags Container -->
                <div x-ref="tagsContainer" @scroll="updateButtons()"
                    class="flex items-center gap-2 overflow-x-auto no-scrollbar scroll-smooth px-12 py-2 border border-gray-300 rounded-lg shadow-sm">
                    @foreach ($tags as $tag)
                    <label class="px-3 py-1.5 border rounded-full cursor-pointer text-sm h-8 flex items-center whitespace-nowrap transition
        {{ in_array($tag->id, request()->input('tags', [])) ? 'bg-black text-white border-black' : 'border-gray-300 text-black hover:border-gray-500' }}">
                        <input type="checkbox" name="tags[]" value="{{ $tag->id }}" class="hidden"
                            onchange="this.form.submit()"
                            {{ in_array($tag->id, request()->input('tags', [])) ? 'checked' : '' }}>
                        {{ $tag->name }}
                    </label>
                    @endforeach
                </div>

                <!-- Right Scroll Button -->
                <button type="button" @click="scroll(1)" x-show="showRight"
                    class="absolute right-0 top-1/2 transform -translate-y-1/2 px-3 py-2 bg-gray-100 hover:bg-gray-400 rounded-full shadow-md transition"
                    x-transition.opacity>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m9 18 6-6-6-6" />
                    </svg>
                </button>

            </div>

        </form>

        <div x-data="{ loading: true }" x-init="setTimeout(() => loading = false, 1500)">
            <!-- Skeleton Loader -->
            <div x-show="loading" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-4">
                @for ($i = 0; $i < 6; $i++)
                    <div class="relative w-full h-[250px] rounded-lg overflow-hidden shadow-lg bg-gray-200 animate-pulse">
                    <div class="w-full h-full bg-gray-300"></div>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                    <div class="absolute bottom-4 left-4">
                        <div class="w-32 h-5 bg-gray-400 rounded-md mb-2"></div>
                        <div class="w-20 h-4 bg-gray-500 rounded-md"></div>
                    </div>
                    <div class="absolute bottom-4 right-4">
                        <div class="w-16 h-6 bg-gray-400 rounded-md"></div>
                    </div>
            </div>
            @endfor
        </div>

        <!-- Artworks Grid -->
        <div x-show="!loading" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($artworks as $artwork)
            <div class="relative w-full h-[250px] rounded-lg overflow-hidden shadow-lg">
                <a href="{{ route('artwork.show', $artwork) }}">
                    <img src="{{ $artwork->images->first()?->attachment ? asset('storage/' . $artwork->images->first()->attachment->path) : asset('images/default-image.jpg') }}"
                        alt="{{ $artwork->title }}" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                    <div class="absolute bottom-4 left-4 text-white">
                        <h2 class="text-lg font-bold">{{ $artwork->title }}</h2>
                        <p class="text-sm">| {{ $artwork->category->name }}</p>
                    </div>
                    <div class="absolute bottom-4 right-4 text-white text-lg font-semibold">
                        <span class="text-xl">₱{{ number_format($artwork->price, 0, '.', ',') }}</span>
                    </div>
                </a>
            </div>
            @endforeach
        </div>

        <!-- Caught up Message -->
        <p class="text-center text-gray-500 mt-6">You're all caught up! No more artworks to show.</p>

    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $artworks->withQueryString()->links() }}
    </div>
    </div>

    <script>
        function scrollTags(amount) {
            document.getElementById("tagsContainer").scrollBy({
                left: amount,
                behavior: "smooth"
            });
        }
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

<style>
    .no-scrollbar::-webkit-scrollbar {
        display: none;
    }
</style>