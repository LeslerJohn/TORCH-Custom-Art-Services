<x-app-layout>
    <div class="w-full h-64 mt-14 bg-gray-200">
        <img src="{{ $artist->user->coverImage ? asset('storage/' . $artist->user->coverImage->path) : asset('images/default.image.jpg') }}" class="w-full h-full object-cover rounded-lg" alt="Hero Banner">
    </div>

            <!-- Large Profile Image (Only Visible When Open) -->
            <div class="text-center transition-all duration-300" :class="open ? 'block' : 'hidden'">
                <img src="{{ $artist->user->profileImage ? asset('storage/' . $artist->user->profileImage->path) : asset('images/profile.default.jpg') }}"
                    class="w-24 h-24 rounded-full object-cover border-4 border-white shadow-md mx-auto">
                <h2 class="text-xl font-semibold mt-3">{{ $artist->user->name }}</h2>
                <p class="text-gray-500 text-sm">{{ $artist->username }}</p>
            </div>

            <!-- Sidebar Content (Only Visible When Open) -->
            <div class="transition-all duration-300 space-y-2" :class="open ? 'opacity-100 w-full' : 'opacity-0 pointer-events-none'">
                <div class="text-gray-700 text-sm space-y-2">
                    <p><strong>Location:</strong> {{ $artist->location }}</p>
                    <p><strong>Phone:</strong> {{ $artist->phone_number }}</p>
                    <p><strong>Status:</strong> {{ ucfirst($artist->status) }}</p>
                    <p><strong>Rating:</strong> {{ $artist->rating }}</p>
                    <p><strong>Available:</strong> {{ $artist->available ? 'Yes' : 'No' }}</p>
                </div>

                @if (!$isOwner)
                <button class="bg-green-500 text-white px-4 py-2 rounded-full mt-4 text-sm">Request Service</button>
                @endif
            </div>

            <!-- Tabs Section -->
            <div class="space-y-12 order-1 lg:order-2" x-data="{ tab: 'artworks' }">
                <div class="flex flex-wrap justify-center space-x-4 border-b pb-2">
                    <template x-for="tabName in ['artworks', 'services', 'reviews', 'about' @if($isOwner), 'collections', 'liked' @endif]">
                        <button @click="tab = tabName" class="tab-button py-2 px-4 border-b-2 border-transparent rounded-t-md transition-colors hover:text-blue-500 hover:border-blue-500 focus:outline-none" x-text="tabName.charAt(0).toUpperCase() + tabName.slice(1)"></button>
                    </template>
                </div>

                <div x-show="tab === 'artworks'" class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-6">
                    @forelse($artworks as $artwork)
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        <img src="{{ asset('storage/' . $artwork->images->first()->attachment->path) }}" class="w-full h-48 object-cover">
                        <div class="p-4">
                            <h4 class="font-semibold">{{ $artwork->title }}</h4>
                            <a href="{{ route('artwork.show', $artwork) }}" class="bg-blue-500 text-white px-4 py-2 rounded mt-2 inline-block">Preview</a>
                        </div>
                    </div>
                    @empty
                    <p>No artworks to show.</p>
                    @endforelse
                </div>

                <div x-show="tab === 'services'" class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-6">
                    @forelse($services as $service)
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        <img src="{{ asset('storage/' . $service->images->first()->attachment->path) }}" class="w-full h-48 object-cover">
                        <div class="p-4">
                            <h4 class="font-semibold">{{ $service->category->name }}</h4>
                            <a href="{{ route('service.show', $service) }}" class="bg-blue-500 text-white px-4 py-2 rounded mt-2 inline-block">Request</a>
                        </div>
                    </div>
                    @empty
                    <p>No services to show.</p>
                    @endforelse
                </div>

                <div x-show="tab === 'about'" class="mt-6 p-6 bg-white rounded-lg shadow-lg text-center">
                    <h2 class="text-2xl font-bold">About Me</h2>
                    <p class="mt-4 text-gray-700">{{ $artist->bio }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>