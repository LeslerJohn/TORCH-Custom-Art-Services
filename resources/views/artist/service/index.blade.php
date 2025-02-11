<x-artist-layout>
    <div class="flex justify-between pt-16">
        <h1 class="text-2lg text-bold text-black-500">Services</h1>
        <a href="{{ route('artist.service.create') }}">
            <button class="bg-orange-600 text-white px-4 py-2 rounded-lg hover:bg-orange-700">
                Add Service
            </button>
        </a>
    </div>

    <div class="flex mt-8 flex-wrap gap-6">
        @foreach ($services as $artwork)
            <a href="{{ route('artist.service.show', $artwork) }}" class="w-1/4">
                <div>
                    <div class="relative">
                        @php
                            $thumbnail = $artwork->images->first()?->attachment;
                        @endphp
                        <img src="{{ $thumbnail ? asset('storage/' . $thumbnail->path) : asset('images/default.image.jpg') }}"
                            alt="{{ $artwork->category->name }}" class="w-full h-64 object-cover rounded-lg">
                        <div class="absolute top-0 left-0 right-0 p-4 rounded-t-lg">
                            <div class="text-sm text-gray-500 flex flex-wrap gap-2">
                                @foreach ($artwork->tags as $tag)
                                    <span
                                        class="bg-gray-200 text-gray-700 px-2 py-1 rounded-md">{{ $tag->name }}</span>
                                @endforeach
                            </div>
                        </div>
                        <div class="absolute bottom-0 left-0 right-0 p-4 bg-white bg-opacity-80 rounded-b-lg">
                            <h3 class="text-lg font-semibold">{{ $artwork->category->name }}</h3>
                        </div>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
</x-artist-layout>