<x-artist-layout>
    <div class="pt-16">
        <a href="{{ route('artist.service.index') }}">
            <x-secondary-button class="justify-center py-1 w-20 text-md hover:border-blue-500">
                Back
            </x-secondary-button>
        </a>
        <div class="flex gap-6 pt-4 w-full">
            <div class="flex flex-col gap-2">
                <h1 class="text-3xl font-bold-300">{{$service->category->name}}</h1>
                <p><strong>Price per square cm:</strong> ₱{{$service->price_rate}}</p>
                <p><strong>Rush order price:</strong> ₱{{$service->rush_price_rate}}</p>
                <p><strong>Estimated normal completion time:</strong> {{$service->normal_timeframe}} days</p>
                <p><strong>Estimated rush completion time:</strong> {{$service->rush_timeframe}} days</p>
                
                <div class="flex flex-wrap gap-2 w-1/2">
                    @foreach ($service->tags as $tag)
                        <span class="bg-gray-200 text-gray-700 px-2 py-1 rounded-md">{{ $tag->name }}</span>
                    @endforeach
                </div>

                <div id="default-carousel" class="relative w-full" data-carousel="slide">
                    <!-- Carousel wrapper -->
                    <div class="relative h-56 overflow-hidden rounded-lg md:h-96">
                        @foreach ($service->images as $index => $image)
                            <div class="{{ $index === 0 ? '' : 'hidden' }} duration-700 ease-in-out" data-carousel-item>
                                <img src="{{ $image->attachment ? asset('storage/' . $image->attachment->path) : asset('images/default.image.jpg') }}" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
                            </div>
                        @endforeach
                    </div>
                    <!-- Slider indicators -->
                    <div class="absolute z-30 flex -translate-x-1/2 bottom-5 left-1/2 space-x-3 rtl:space-x-reverse">
                        @foreach ($service->images as $index => $image)
                            <button type="button" class="w-3 h-3 rounded-full" aria-current="{{ $index === 0 ? 'true' : 'false' }}" aria-label="Slide {{ $index + 1 }}" data-carousel-slide-to="{{ $index }}"></button>
                        @endforeach
                    </div>
                    <!-- Slider controls -->
                    <button type="button" class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-prev>
                        <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                            <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
                            </svg>
                            <span class="sr-only">Previous</span>
                        </span>
                    </button>
                    <button type="button" class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-next>
                        <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                            <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                            <span class="sr-only">Next</span>
                        </span>
                    </button>
                </div>

            
                <div class="flex gap-4">
                    <a href="{{route('artist.service.edit', $service)}}">
                        <x-primary-button class="justify-center py-1 w-20 text-md hover:border-blue-500">
                            Edit
                        </x-primary-button>
                    </a>
                    <form action="{{ route('artist.service.destroy', $service) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <x-secondary-button type="submit" class="justify-center py-1 w-20 text-md hover:border-blue-500">
                            Delete
                        </x-secondary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-artist-layout>