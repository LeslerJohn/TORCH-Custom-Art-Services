<x-artist-layout>
    <div class="flex flex-col md:flex-row justify-between pt-16">
        <h1 class="text-xl md:text-2xl font-bold text-black-500">Artworks</h1>
        <a href="{{ route('artist.artwork.create') }}" class="mt-4 md:mt-0">
            <button class="bg-orange-600 text-white px-4 py-2 rounded-lg hover:bg-orange-700">
                Add Artwork
            </button>
        </a>
    </div>

    <div class="flex flex-wrap mt-8 gap-6">
        @foreach ($artworks as $artwork)
            <a href="{{ route('artist.artwork.show', $artwork) }}" class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 transform transition-transform duration-300 hover:scale-105">
                <div class="border rounded-lg overflow-hidden shadow-lg">
                    @php
                        $thumbnail = $artwork->images->first()?->attachment;
                    @endphp
                    <img src="{{ $thumbnail ? asset('storage/' . $thumbnail->path) : asset('images/default.image.jpg') }}"
                        alt="{{ $artwork->title }}" class="w-full h-48 sm:h-64 object-cover">
                    <div class="p-4 bg-white">
                        <h3 class="text-md sm:text-lg font-semibold">{{ $artwork->title }}</h3>
                        <p class="text-xs sm:text-sm text-gray-500">{{ Str::limit($artwork->description, 50) }}</p>
                        <div class="text-xs sm:text-sm text-gray-500 flex flex-wrap gap-2 mt-2">
                            @foreach ($artwork->tags as $tag)
                                <span class="bg-orange-100 text-orange-700 px-2 py-1 text-xs rounded-full">{{ $tag->name }}</span>
                            @endforeach
                        </div>
                        @if ($artwork->is_showcase)
                            <span class="bg-green-100 text-green-800 px-3 py-1 text-xs rounded-full mt-2 inline-block">Showcased</span>
                        @endif
                        @if ($artwork->discount)
                            <span class="bg-red-100 text-red-500 px-3 py-1 text-xs rounded-full mt-2 inline-block">Discounted</span>
                        @endif
                    </div>
                </div>
            </a>
        @endforeach
    </div>
</x-artist-layout>