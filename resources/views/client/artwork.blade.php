<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6 min-h-screen">
        <div class="flex items-center justify-between w-full mb-4">
            <h2 class="text-xl font-bold">Artworks</h2>
        </div>

        <!-- Selected Tags Section -->
        @if (request()->has('tags'))
        <div class="flex flex-wrap gap-2 mb-4">
            @foreach (request()->input('tags', []) as $selectedTagId)
            @php
            $selectedTag = $tags->firstWhere('id', $selectedTagId);
            @endphp
            @if ($selectedTag)
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
                    <option value="{{ $category->id }}"
                        {{ request('category') == $category->id ? 'selected' : '' }}>
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

            <!-- Discounted Artworks Filter -->
            <button type="submit" name="discounted" value="{{ request('discounted') ? '' : '1' }}"
                class="px-4 py-1 border border-gray-300 rounded-full transition 
                    {{ request('discounted') ? 'bg-black text-white' : 'text-black hover:bg-gray-200' }}">
                Discounted
            </button>

            <!-- Sort Options -->
            <button type="submit" name="sort" value="{{ request('sort') == 'random' ? '' : 'random' }}"
                class="px-4 py-1 border border-gray-300 rounded-full transition
                    {{ request('sort') == 'random' ? 'bg-black text-white' : 'text-black hover:bg-gray-200' }}">
                Random
            </button>

            <button type="submit" name="sort" value="{{ request('sort') == 'latest' ? '' : 'latest' }}"
                class="px-4 py-1 border border-gray-300 rounded-full transition
                    {{ request('sort') == 'latest' ? 'bg-black text-white' : 'text-black hover:bg-gray-200' }}">
                Latest
            </button>

            <!-- Clear Sort (Fixed at the End) -->
            <button type="submit" name="sort" value=""
                class="px-2 py-2 border rounded-full bg-red-500 text-white hover:bg-red-600 transition ml-auto">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" class="lucide lucide-eraser">
                <path
                    d="m7 21-4.3-4.3c-1-1-1-2.5 0-3.4l9.6-9.6c1-1 2.5-1 3.4 0l5.6 5.6c1 1 1 2.5 0 3.4L13 21" />
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
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round">
                <path d="m15 18-6-6 6-6" />
                </svg>
            </button>

                <!-- Tags Container -->
                <div x-ref="tagsContainer" @scroll="updateButtons()"
                    class="flex items-center gap-2 overflow-x-auto no-scrollbar scroll-smooth px-12 py-2 border border-gray-300 rounded-lg shadow-sm">
                    @foreach ($tags as $tag)
                    <label
                        class="px-3 py-1.5 border rounded-full cursor-pointer text-sm h-8 flex items-center whitespace-nowrap transition
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
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round">
                <path d="m9 18 6-6-6-6" />
                </svg>
            </button>

            </div>

        </form>

        <div x-data="{ loading: true }" x-init="setTimeout(() => loading = false, 1500)">
            <!-- Skeleton Loader -->
            <div x-show="loading" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-4">
                @for ($i = 0; $i < 6; $i++)
                    <div
                    class="relative w-full h-[250px] rounded-lg overflow-hidden shadow-lg bg-gray-200 animate-pulse">
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
                    <div class="absolute top-4 left-4 text-white">
                        <span class="text-sm {{ $artwork->status == 'sale' ? 'bg-green-500' : 'bg-red-500' }} px-2 py-1 rounded-full">
                            {{ ucfirst($artwork->status) }}
                        </span>
                    </div>
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
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $artworks->withQueryString()->links() }}
    </div>

    <!-- Caught up Message -->
    <p class="text-center text-gray-500 mt-6">You're all caught up! No more artworks to show.</p>

    </div>

    <script>
        function scrollTags(amount) {
            document.getElementById("tagsContainer").scrollBy({
                left: amount,
                behavior: "smooth"
            });
        }
    </script>
    <footer>
        <div>
            @include('layouts.footer')
        </div>
    </footer>

</x-app-layout>

<style>
    .no-scrollbar::-webkit-scrollbar {
        display: none;
    }
</style>