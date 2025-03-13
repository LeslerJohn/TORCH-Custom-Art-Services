<x-app-layout>
    <div class="flex flex-col min-h-screen">
        <div class="flex-grow">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
                <div class="flex items-center justify-between w-full mb-4">
                    <h2 class="text-xl font-bold">Services</h2>
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
                        <a href="{{ route('client.service', array_merge(request()->except('tags'), ['tags' => array_diff(request()->input('tags', []), [$selectedTagId])])) }}"
                            class="ml-2 text-white hover:text-gray-300">
                            ✕
                        </a>
                    </span>
                    @endif
                    @endforeach
                </div>
                @endif

                <!-- Filters -->
                <form method="GET" action="{{ route('client.service') }}" class="mb-4">
                    <div class="flex items-center gap-3 whitespace-nowrap py-2 border rounded-lg shadow-sm px-4 overflow-hidden">

                        <!-- Availability -->
                        <button type="submit" name="available" value="1"
                            class="px-5 py-2 border rounded-full {{ request('available') == '1' ? 'bg-black text-white' : 'bg-gray-200 text-black' }}">
                            Open Services
                        </button>

                        <!-- Sort Options -->
                        <button type="submit" name="sort" value="random"
                            class="px-5 py-2 border rounded-full {{ request('sort') == 'random' ? 'bg-black text-white' : 'bg-gray-200 text-black' }}">
                            Random
                        </button>
                        <button type="submit" name="sort" value="latest"
                            class="px-5 py-2 border rounded-full {{ request('sort') == 'latest' ? 'bg-black text-white' : 'bg-gray-200 text-black' }}">
                            Latest
                        </button>

                        <!-- Category Filter -->
                        <select name="category" onchange="this.form.submit()"
                            class="px-5 py-2 border rounded-full bg-gray-200 text-black">
                            <option value="">All Categories</option>
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
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

                            <!-- Left Button (Only show if necessary) -->
                            <button type="button" @click="scrollLeft()" x-show="showLeft"
                                class="absolute left-0 inset-y-2 px-2 bg-gray-100 hover:bg-gray-400 transition-opacity duration-300 rounded-lg flex items-center justify-center h-10 w-10 shadow-md z-10">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m15 18-6-6 6-6" />
                                </svg>
                            </button>

                            <!-- Tags Container -->
                            <div x-ref="tagsContainer" @scroll="updateButtons()"
                                class="flex gap-3 overflow-x-auto scrollbar-hide px-12 w-full py-2"
                                style="scrollbar-width: none; -ms-overflow-style: none;">
                                @foreach ($tags as $tag)
                                <label class="px-5 py-2 border rounded-full cursor-pointer {{ in_array($tag->id, request()->input('tags', [])) ? 'bg-black text-white' : 'bg-gray-200 text-black' }}">
                                    <input type="checkbox" name="tags[]" value="{{ $tag->id }}" class="hidden"
                                        onchange="this.form.submit()"
                                        {{ in_array($tag->id, request()->input('tags', [])) ? 'checked' : '' }}>
                                    {{ $tag->name }}
                                </label>
                                @endforeach
                            </div>

                            <!-- Right Button (Only show if necessary) -->
                            <button type="button" @click="scrollRight()" x-show="showRight"
                                class="absolute right-0 inset-y-2 px-2 bg-gray-100 hover:bg-gray-400 transition-opacity duration-300 rounded-lg flex items-center justify-center h-10 w-10 shadow-md z-10">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m9 18 6-6-6-6" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Hide Scrollbar -->
                <style>
                    .scrollbar-hide::-webkit-scrollbar {
                        display: none;
                    }
                </style>

                <!-- Services Section with Skeleton Loader -->
                <div x-data="{ loading: true }">
                    <!-- Skeleton Loader -->
                    <div id="skeleton-loader" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-4">
                        @for ($i = 0; $i < 6; $i++)
                            <div class="relative w-full h-[250px] rounded-lg overflow-hidden shadow-lg bg-gray-200 animate-pulse">
                            <!-- Background -->
                            <div class="w-full h-full bg-gray-300"></div>

                            <!-- Overlay -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>

                            <!-- Placeholder Category -->
                            <div class="absolute top-4 left-4 px-2 py-1 rounded bg-gray-400 w-16 h-5"></div>

                            <!-- Placeholder Artist Info -->
                            <div class="absolute bottom-4 left-4 flex items-center gap-2">
                                <div>
                                    <div class="w-24 h-4 bg-gray-400 rounded-md"></div>
                                    <div class="w-16 h-3 bg-gray-300 rounded-md mt-1"></div>
                                </div>
                            </div>
                    </div>
                    @endfor
                </div>

                <div id="service-list" class="hidden">
                    <!-- Services Grid -->
                    <div x-init="setTimeout(() => loading = false, 1500)" x-show="!loading"
                        class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($services as $service)
                        <a href="{{ route('service.show', $service) }}">
                            <div class="relative w-full h-[250px] rounded-lg overflow-hidden shadow-lg">
                                <!-- Background Image -->
                                <img src="{{ $service->images->first()?->attachment ? asset('storage/' . $service->images->first()->attachment->path) : asset('images/default-image.jpg') }}"
                                    alt="Service Image" class="w-full h-full object-cover">

                                <!-- Overlay -->
                                <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>

                                <!-- Text Content -->
                                <div class="absolute bottom-4 left-4 text-white">
                                    <h2 class="text-lg font-bold">{{ $service->category->name }}</h2>
                                    <p class="text-sm">
                                        @foreach ($service->tags as $tag)
                                        {{ $tag->name }}@if (!$loop->last), @endif
                                        @endforeach
                                    </p>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $services->withQueryString()->links() }}
    </div>
    </div>

    <br><br><br>
    <footer>
        <div>
            @include('layouts.footer')
        </div>
    </footer>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            setTimeout(() => {
                document.getElementById("skeleton-loader").classList.add("hidden");
                document.getElementById("service-list").classList.remove("hidden");
            }, 1500);
        });
    </script>
</x-app-layout>