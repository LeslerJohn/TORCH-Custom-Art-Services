<x-artist-layout>
    <div class="pt-16 px-4 sm:px-6 lg:px-8">
        <!-- Back Button -->
        <a href="{{ route('artist.artwork.index') }}">
            <x-secondary-button class="justify-center py-1 w-20 text-sm sm:text-md hover:border-blue-500">
                Back
            </x-secondary-button>
        </a>
        <div class="flex flex-col lg:flex-row gap-6 pt-4 w-full">
            <div class="flex w-full lg:w-1/2 flex-col gap-6 p-6 bg-white rounded-lg shadow-md">
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-800">{{ $artwork->title }}</h1>
                <p class="text-gray-600">{{ $artwork->description }}</p>
                <p class="text-gray-800"><strong>Category:</strong> {{ $artwork->category->name }}</p>
                <p class="text-gray-800"><strong>Dimension:</strong> {{ $artwork->width }} x {{ $artwork->height }}
                    {{ $artwork->unit }}</p>
                <p class="text-gray-800"><strong>Price:</strong> ₱{{ $artwork->price }}</p>
                <p class="text-gray-800"><strong>Status:</strong> {{ ucfirst($artwork->status) }}</p>
                @if ($artwork->discount)
                    <p class="text-red-500"><strong>Discount:</strong> {{ $artwork->discount->value }}
                        {{ $artwork->discount->value_type == 'percentage' ? '%' : 'Peso' }}</p>
                    <p class="text-green-500"><strong>Discounted Price:</strong>
                        ₱{{ $artwork->discount->value_type == 'percentage' ? $artwork->price - ($artwork->price * $artwork->discount->value) / 100 : $artwork->price - $artwork->discount->value }}
                    </p>
                @endif
                @if ($artwork->is_showcase)
                    <span class="bg-green-100 w-[110px] text-green-700 px-3 py-1 rounded-full">Showcased</span>
                @endif
                <div class="flex flex-wrap gap-2 mt-4">
                    @foreach ($artwork->tags as $tag)
                        <span
                            class="bg-orange-100 text-orange-700 px-3 py-1 rounded-full shadow-sm">{{ $tag->name }}</span>
                    @endforeach
                </div>

                <div class="flex gap-4 mt-4">
                    @if ($artwork->status === 'sale')
                        <a href="{{ route('artist.artwork.edit', $artwork) }}">
                            <x-primary-button class="justify-center py-2 w-24 text-md hover:border-blue-500">
                                Edit
                            </x-primary-button>
                        </a>

                        <button data-modal-target="popup-modal" data-modal-toggle="popup-modal" class="justify-center py-2 w-24 text-md hover:border-blue-500 bg-red-600 text-white rounded-lg">
                            Delete
                        </button>
                    @endif

                    <div id="popup-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                        <div class="relative p-4 w-full max-w-md max-h-full">
                            <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                                <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="popup-modal">
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                    </svg>
                                    <span class="sr-only">Close modal</span>
                                </button>
                                <div class="p-4 md:p-5 text-center">
                                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                    </svg>
                                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to delete this artwork?</h3>
                                    <div class="flex justify-center gap-4">
                                        <form action="{{ route('artist.artwork.destroy', $artwork) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button data-modal-hide="popup-modal" type="submit" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                                Yes, I'm sure
                                            </button>
                                        </form>
                                        <button data-modal-hide="popup-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">No, cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="default-carousel" class="relative w-full lg:w-1/2" data-carousel="slide">
                <!-- Carousel wrapper -->
                <div class="relative h-56 overflow-hidden rounded-lg md:h-96">
                    @foreach ($artwork->images as $index => $image)
                        <div class="{{ $index === 0 ? '' : 'hidden' }} duration-700 ease-in-out" data-carousel-item>
                            <img src="{{ $image->attachment ? asset('storage/' . $image->attachment->path) : asset('images/default.image.jpg') }}"
                                class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
                                alt="...">
                        </div>
                    @endforeach
                </div>
                <!-- Slider indicators -->
                <div class="absolute z-30 flex -translate-x-1/2 bottom-5 left-1/2 space-x-3 rtl:space-x-reverse">
                    @foreach ($artwork->images as $index => $image)
                        <button type="button" class="w-3 h-3 rounded-full"
                            aria-current="{{ $index === 0 ? 'true' : 'false' }}"
                            aria-label="Slide {{ $index + 1 }}"
                            data-carousel-slide-to="{{ $index }}"></button>
                    @endforeach
                </div>
                <!-- Slider controls -->
                <button type="button"
                    class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                    data-carousel-prev>
                    <span
                        class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                        <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 1 1 5l4 4" />
                        </svg>
                        <span class="sr-only">Previous</span>
                    </span>
                </button>
                <button type="button"
                    class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                    data-carousel-next>
                    <span
                        class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                        <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 9 4-4-4-4" />
                        </svg>
                        <span class="sr-only">Next</span>
                    </span>
                </button>
            </div>
        </div>
    </div>
</x-artist-layout>
