<x-app-layout>
    <div class="w-full h-64 mt-16 bg-gray-200">
        <img src="{{ $artist->user->coverImage ? asset('storage/' . $artist->user->coverImage->path) : asset('images/default.image.jpg') }}"
        class="w-full h-full object-cover" alt="Hero Banner">
    </div>

    <div class="container mx-auto w-full max-w-7xl px-6 mt-8">
        <div class="flex flex-col lg:flex-row lg:gap-8 gap-32 mt-8">
            <div x-data="{ tab: 'artworks' }" class="mt-8 flex flex-col w-full space-y-16">
                <div class="flex justify-start space-x-4 border-b">
                    <button @click="tab = 'artworks'" class="py-2 px-4">Artworks</button>
                    <button @click="tab = 'services'" class="py-2 px-4">Services</button>
                    @if ($isOwner)
                        <button @click="tab = 'collections'" class="py-2 px-4">Collections</button>
                        <button @click="tab = 'liked'" class="py-2 px-4">Liked</button>
                    @endif
                    <button @click="tab = 'reviews'" class="py-2 px-4">Reviews</button>
                    <button @click="tab = 'about'" class="py-2 px-4">About</button>
                </div>

                <div x-show="tab === 'artworks'" class="mt-6 grid grid-cols-2 gap-6">
                    @forelse($artworks as $artwork)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden">
                            <img src="{{ asset('storage/' . $artwork->images->first()->attachment->path) }}" class="w-full h-48 object-cover">
                            <div class="p-4">
                                <h4>{{ $artwork->title }}</h4>
                                <a href="{{ route('artwork.show', $artwork) }}" class="bg-blue-500 text-white px-4 py-2 rounded mt-2 inline-block">Preview</a>
                            </div>
                        </div>
                    @empty
                        <p>No artworks to show.</p>
                    @endforelse
                </div>

                <div x-show="tab === 'services'" class="mt-6 grid grid-cols-2 gap-6">
                    @forelse($services as $service)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden">
                            <img src="{{ asset('storage/' . $service->images->first()->attachment->path) }}" class="w-full h-48 object-cover">
                            <div class="p-4">
                                <h4>{{ $service->category->name }}</h4>
                                <a href="{{ route('service.show', $service) }}" class="bg-blue-500 text-white px-4 py-2 rounded mt-2 inline-block">Request</a>
                            </div>
                        </div>
                    @empty
                        <p>No services to show.</p>
                    @endforelse
                </div>

                <div x-show="tab === 'reviews'" class="mt-6 grid grid-cols-2 gap-6">
                    @forelse($reviews as $review)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden">
                            <div class="p-4">
                                <h4>{{ $review->review }}</h4>
                                <p class="mt-2 text-gray-600">Rating: {{ $review->rating }}</p>
                                <p class="mt-2 text-gray-600">By: {{ $review->order->client->user->name ?? $review->commission->request->client->user->name }}</p>
                            </div>
                        </div>
                    @empty
                        <p>No reviews to show.</p>
                    @endforelse
                </div>

                @if ($isOwner)
                    <div x-show="tab === 'collections'" class="mt-6 grid grid-cols-2 gap-6">
                        @forelse($collections as $collection)
                            <div class="bg-white rounded-lg shadow-md">
                                <img src="{{ asset('storage/' . $collection->image_path) }}" class="w-full h-48 object-cover">
                                <div class="p-4">
                                    <h4>{{ $collection->title }}</h4>
                                </div>
                            </div>
                        @empty
                            <p>No collections to show.</p>
                        @endforelse
                    </div>

                    <div x-show="tab === 'liked'" class="mt-6 grid grid-cols-2 gap-6">
                        @forelse($liked as $like)
                            <div class="bg-white rounded-lg shadow-md">
                                <img src="{{ asset('storage/' . $like->artwork->images->first()->path) }}" class="w-full h-48 object-cover">
                                <div class="p-4">
                                    <h4>{{ $like->artwork->title }}</h4>
                                </div>
                            </div>
                        @empty
                            <p>No liked artworks to show.</p>
                        @endforelse
                    </div>
                @endif

                <div x-show="tab === 'about'" class="mt-6 p-6 bg-white rounded-lg shadow-md">
                    <h2 class="text-2xl font-bold">About Me</h2>
                    <p class="mt-4 text-gray-700">{{ $artist->bio }}</p>
                </div>
            </div>

            <div class="text-center lg:text-left w-full lg:w-1/3">
                <div class="flex justify-center lg:justify-start">
                    <img src="{{ $artist->user->profileImage ? asset('storage/' . $artist->user->profileImage->path) : asset('images/profile.default.jpg') }}"
                    class="w-32 h-32 rounded-full object-cover" alt="Profile Picture">
                </div>
                <h1 class="text-4xl font-bold mt-4">{{ $artist->user->name }}</h1>
                <div class="mt-4">
                    <p><strong>Username:</strong> {{ $artist->username }}</p>
                    <p><strong>Phone Number:</strong> {{ $artist->phone_number }}</p>
                    <p><strong>Location:</strong> {{ $artist->location }}</p>
                    <p><strong>Gender:</strong> {{ $artist->gender }}</p>
                    <p><strong>Birthdate:</strong> {{ \Carbon\Carbon::parse($artist->birthdate)->format('F j, Y') }}</p>
                    <p><strong>Status:</strong> {{ ucfirst($artist->status) }}</p>
                    <p><strong>Rating:</strong> {{ $artist->rating }}</p>
                    <p><strong>Available:</strong> {{ $artist->available ? 'Yes' : 'No' }}</p>
                </div>

                @if (!$isOwner)
                    <button class="bg-green-500 text-white px-6 py-2 rounded-full mt-4">
                        Request Service
                    </button>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
