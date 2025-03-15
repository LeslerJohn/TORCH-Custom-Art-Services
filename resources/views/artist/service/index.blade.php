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
                <div class="shadow-lg rounded-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                    @php
                        $thumbnail = $artwork->images->first()?->attachment;
                    @endphp
                    <img src="{{ $thumbnail ? asset('storage/' . $thumbnail->path) : asset('images/default.image.jpg') }}"
                        alt="{{ $artwork->category->name }}" class="w-full h-64 object-cover">
                    <div class="p-4 bg-white border-t-2 border-orange-200">
                        <h3 class="text-lg font-semibold mb-2">{{ $artwork->category->name }}</h3>
                        <div class="text-sm text-gray-500 flex flex-wrap gap-2 mb-2">
                            @foreach ($artwork->tags as $tag)
                                <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-full shadow-sm">{{ $tag->name }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
</x-artist-layout>