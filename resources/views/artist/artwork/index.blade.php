<x-artist-layout>
    <div class="flex justify-between pt-16">
        <h1 class="text-2lg text-bold text-black-500">Artworks</h1>
        <a href="{{ route('artist.artwork.create') }}">
            <button class="bg-orange-600 text-white px-4 py-2 rounded-lg hover:bg-orange-700">
                Add Artwork
            </button>
        </a>
    </div>

    <div class="flex mt-8 flex-wrap gap-6">
        @foreach ($artworks as $artwork)
            <a href="{{ route('artist.artwork.show', $artwork) }}" class="w-1/4">
            <div>
                <div class="relative">
                @php
                    $thumbnail = $artwork->images->first()?->attachment;
                @endphp
                <img src="{{ $thumbnail ? asset('storage/' . $thumbnail->path) : asset('images/default.image.jpg') }}"
                    alt="{{ $artwork->title }}" class="w-full h-64 object-cover rounded-lg">
                <div class="absolute top-0 left-0 right-0 p-4 rounded-t-lg">
                    <div class="text-sm text-gray-500 flex flex-wrap gap-2">
                    @foreach ($artwork->tags as $tag)
                        <span
                        class="bg-gray-200 text-gray-700 px-2 py-1 rounded-md">{{ $tag->name }}</span>
                    @endforeach
                    </div>
                </div>
                <div class="absolute flex justify-between bottom-0 left-0 right-0 p-4 bg-white bg-opacity-80 rounded-b-lg">
                    <div>
                        <h3 class="text-lg font-semibold">{{ $artwork->title }}</h3>
                        <p class="text-sm text-gray-500">{{ Str::limit($artwork->description, 10) }}</p>
                    </div>
                    @if ($artwork->is_showcase)
                        <span class="bg-green-500 h-8 text-white px-2 py-1 rounded-md">Showcased</span>
                    @endif
                </div>
                </div>
            </div>
            </a>
        @endforeach
    </div>
</x-artist-layout>