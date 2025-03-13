<x-artist-layout>
    <div class="pt-16 px-4 sm:px-6 lg:px-8">
        <!-- Back Button -->
        <a href="{{ route('artist.artwork.index') }}">
            <x-secondary-button class="justify-center py-1 w-20 text-sm sm:text-md hover:border-blue-500">
                Back
            </x-secondary-button>
        </a>

        <!-- Main Content -->
        <div class="mt-8">
            <!-- Artwork Title -->
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-4">{{ $artwork->title }}</h1>

            <!-- Grid Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Left Column (Carousel) -->
                <div class="w-full">
                    <div id="default-carousel" class="relative w-full" data-carousel="slide">
                        <!-- Carousel Wrapper -->
                        <div class="relative h-56 sm:h-64 md:h-96 overflow-hidden rounded-lg">
                            @foreach ($artwork->images as $index => $image)
                            <div class="{{ $index === 0 ? '' : 'hidden' }} duration-700 ease-in-out" data-carousel-item>
                                <img src="{{ $image->attachment ? asset('storage/' . $image->attachment->path) : asset('images/default.image.jpg') }}" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="{{ $artwork->title }}">
                            </div>
                            @endforeach
                        </div>

                        <!-- Slider Indicators -->
                        <div class="absolute z-20 flex -translate-x-1/2 bottom-5 left-1/2 space-x-3 rtl:space-x-reverse">
                            @foreach ($artwork->images as $index => $image)
                            <button type="button" class="w-3 h-3 rounded-full bg-white/30 hover:bg-white/50 focus:outline-none" aria-current="{{ $index === 0 ? 'true' : 'false' }}" aria-label="Slide {{ $index + 1 }}" data-carousel-slide-to="{{ $index }}"></button>
                            @endforeach
                        </div>

                        <!-- Slider Controls -->
                        <button type="button" class="absolute top-0 start-0 z-20 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-prev>
                            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 hover:bg-white/50 focus:ring-4 focus:ring-white focus:outline-none">
                                <svg class="w-4 h-4 text-white rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4" />
                                </svg>
                                <span class="sr-only">Previous</span>
                            </span>
                        </button>
                        <button type="button" class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-next>
                            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 hover:bg-white/50 focus:ring-4 focus:ring-white focus:outline-none">
                                <svg class="w-4 h-4 text-white rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                                </svg>
                                <span class="sr-only">Next</span>
                            </span>
                        </button>
                    </div>
                </div>

                <!-- Right Column (Artwork Details) -->
                <div class="w-full">
                    <div class="bg-white p-6 rounded-lg">
                        <!-- Description -->
                        <p class="text-sm sm:text-base text-gray-700 mb-6">{{ $artwork->description }}</p>

                        <!-- Metadata -->
                        <div class="space-y-4">
                            <div>
                                <strong class="text-sm sm:text-base text-gray-800">Category:</strong>
                                <span class="text-sm sm:text-base text-gray-600">{{ $artwork->category->name }}</span>
                            </div>
                            <div>
                                <strong class="text-sm sm:text-base text-gray-800">Dimensions:</strong>
                                <span class="text-sm sm:text-base text-gray-600">{{ $artwork->width }} x {{ $artwork->height }} {{ $artwork->unit }}</span>
                            </div>
                            <div>
                                <strong class="text-sm sm:text-base text-gray-800">Price:</strong>
                                <span class="text-sm sm:text-base text-gray-600">₱{{ $artwork->price }}</span>
                            </div>
                            @if ($artwork->is_showcase)
                            <div>
                                <span class="bg-green-500 text-white px-2 py-1 rounded-md text-sm sm:text-base">Showcased</span>
                            </div>
                            @endif
                        </div>

                        <!-- Tags -->
                        <div class="mt-6">
                            <strong class="text-sm sm:text-base text-gray-800">Tags:</strong>
                            <div class="flex flex-wrap gap-2 mt-2">
                                @foreach ($artwork->tags as $tag)
                                <span class="bg-gray-200 text-gray-700 px-2 py-1 rounded-md text-sm sm:text-base">{{ $tag->name }}</span>
                                @endforeach
                            </div>
                        </div>

                        <!-- Edit and Delete Buttons -->
                        <div class="mt-6 flex gap-4">
                            <a href="{{ route('artist.artwork.edit', $artwork) }}">
                                <x-primary-button class="justify-center py-1 w-20 text-sm sm:text-md hover:border-blue-500">
                                    Edit
                                </x-primary-button>
                            </a>
                            <form action="{{ route('artist.artwork.destroy', $artwork) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <x-secondary-button type="submit" class="justify-center py-1 w-20 text-sm sm:text-md hover:border-blue-500">
                                    Delete
                                </x-secondary-button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-artist-layout>