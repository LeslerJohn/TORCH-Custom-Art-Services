<x-artist-layout>
    <div class="pt-16 px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h1 class="text-xl sm:text-2xl font-bold text-gray-800">Artworks</h1>
            <a href="{{ route('artist.artwork.create') }}">
                <button class="bg-orange-600 text-white px-4 py-2 rounded-lg hover:bg-orange-700 text-sm sm:text-base">
                    Add Artwork
                </button>
            </a>
        </div>

        <!-- Artwork Grid -->
        <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-2 gap-4 z-0">
            @foreach ($artworks as $artwork)
            <a href="{{ route('artist.artwork.show', $artwork) }}" class="block w-full group">
                <div class="relative h-48 sm:h-64 rounded-lg overflow-hidden">
                    <!-- Image -->
                    @php
                    $thumbnail = $artwork->images->first()?->attachment;
                    @endphp
                    <img src="{{ $thumbnail ? asset('storage/' . $thumbnail->path) : asset('images/default.image.jpg') }}"
                        alt="{{ $artwork->title }}" class="w-full h-full object-cover transition-transform duration-300 sm:group-hover:scale-105">

                    <!-- Overlay (Visible on Hover for Larger Screens) -->
                    <div class="absolute inset-0 hidden sm:flex flex-col justify-between p-2 sm:p-4 bg-black bg-opacity-0 transition-all duration-300 group-hover:bg-opacity-50">
                        <!-- Tags -->
                        <div class="text-xs sm:text-sm text-gray-100 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <div class="flex flex-wrap gap-1 sm:gap-2">
                                @foreach ($artwork->tags as $tag)
                                <span class="bg-gray-800 bg-opacity-70 text-gray-100 px-2 py-1 rounded-md">{{ $tag->name }}</span>
                                @endforeach
                            </div>
                        </div>

                        <!-- Title, Description, and Showcase Badge -->
                        <div class="flex justify-between items-end opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <div>
                                <h3 class="text-sm sm:text-lg font-semibold text-white">{{ $artwork->title }}</h3>
                                <p class="text-xs sm:text-sm text-gray-200">{{ Str::limit($artwork->description, 10) }}</p>
                            </div>
                            @if ($artwork->is_showcase)
                            <span class="bg-green-500 text-white px-2 py-1 rounded-md text-xs sm:text-sm">Showcased</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Details (Visible on Mobile) -->
                <div class="sm:hidden p-2 bg-white">
                    <!-- Tags -->
                    <div class="text-xs text-gray-700 flex flex-wrap gap-1">
                        @foreach ($artwork->tags as $tag)
                        <span class="bg-gray-200 text-gray-700 px-2 py-1 rounded-md">{{ $tag->name }}</span>
                        @endforeach
                    </div>

                    <!-- Title, Description, and Showcase Badge -->
                    <div class="mt-2 flex justify-between items-start">
                        <div>
                            <h3 class="text-sm font-semibold text-gray-800">{{ $artwork->title }}</h3>
                            <p class="text-xs text-gray-500">{{ Str::limit($artwork->description, 10) }}</p>
                        </div>
                        @if ($artwork->is_showcase)
                        <span class="bg-green-500 text-white px-2 py-1 rounded-md text-xs">Showcased</span>
                        @endif
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</x-artist-layout>
