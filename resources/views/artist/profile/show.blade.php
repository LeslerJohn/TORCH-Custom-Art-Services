<x-app-layout>
<<<<<<< HEAD
    <div class="container mx-auto max-w-7xl px-6 mt-6 flex" x-data="{ open: true, tab: 'artworks' }">
        <!-- Sidebar -->
        <div class="transition-all duration-300 ease-in-out flex flex-col bg-white shadow-lg rounded-2xl p-3 relative"
            :class="open ? 'w-72' : 'w-20 items-center'">
=======
    <div class="w-full h-64 mt-14 bg-gray-200">
        <img src="{{ $artist->user->coverImage ? asset('storage/' . $artist->user->coverImage->path) : asset('images/default.image.jpg') }}" class="w-full h-full object-cover rounded-lg" alt="Hero Banner">
    <div class="w-full h-64 mt-14 bg-gray-200">
        <img src="{{ $artist->user->coverImage ? asset('storage/' . $artist->user->coverImage->path) : asset('images/default.image.jpg') }}" class="w-full h-full object-cover rounded-lg" alt="Hero Banner">
    </div>
>>>>>>> origin/dev

            <!-- Profile + Toggle Button Container -->
            <div class="flex w-full transition-all duration-300"
                :class="open ? 'justify-between' : 'flex-col-reverse items-center space-y-2'">

                <!-- Small Profile Image (Only Visible When Closed) -->
                <img src="{{ $artist->user->profileImage ? asset('storage/' . $artist->user->profileImage->path) : asset('images/profile.default.jpg') }}"
                    class="rounded-full object-cover border-2 border-white shadow-md transition-all"
                    :class="open ? 'hidden' : 'w-12 h-12 mt-2'">

                <!-- Toggle Button (Smooth Animation) -->
                <button @click="open = !open"
                    class="bg-white shadow-md w-10 h-10 flex items-center justify-center rounded-full transition-all duration-500 ease-in-out transform"
                    :class="open ? 'rotate-0 ml-auto scale-100' : 'rotate-180 scale-90'">
                    <span class="text-gray-600 text-2xl transition-transform duration-500 ease-in-out">←</span>
                </button>
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

<<<<<<< HEAD
                <div class="mt-4">
                    @if (!$isOwner)
                    <button class="w-full bg-green-500 text-white px-4 py-2 rounded-full hover:bg-green-600 transition">
                        Request Service
                    </button>
                    @else
                    <a href="{{ route('profile.edit', $artist) }}"
                        class="block w-full bg-blue-500 text-white px-4 py-2 rounded-full hover:bg-blue-600 transition">
                        Edit Profile
                    </a>
                    @endif
                </div>
            </div>
        </div>


        <!-- Main Content -->
        <div class="flex-1 transition-all duration-300 px-4"
            :class="open ? 'ml-5' : 'ml-16'">
            <!-- Hero Banner -->
            <div class="relative w-full h-64">
                <img src="{{ $artist->user->coverImage ? asset('storage/' . $artist->user->coverImage->path) : asset('images/default.image.jpg') }}"
                    class="w-full h-full object-cover rounded-lg shadow-md">

            </div>

            <!-- Tab Navigation -->
            <div class="flex justify-center space-x-4 border-b pb-2 mt-6">
                <button @click="tab = 'artworks'"
                    class="py-2 px-4 border-b-2 text-gray-600 transition hover:text-blue-500 hover:border-blue-500 focus:outline-none"
                    :class="{ 'border-blue-500 text-blue-600': tab === 'artworks' }">Artworks</button>
                <button @click="tab = 'services'"
                    class="py-2 px-4 border-b-2 text-gray-600 transition hover:text-blue-500 hover:border-blue-500 focus:outline-none"
                    :class="{ 'border-blue-500 text-blue-600': tab === 'services' }">Services</button>
                <button @click="tab = 'reviews'"
                    class="py-2 px-4 border-b-2 text-gray-600 transition hover:text-blue-500 hover:border-blue-500 focus:outline-none"
                    :class="{ 'border-blue-500 text-blue-600': tab === 'reviews' }">Reviews</button>
                <button @click="tab = 'about'"
                    class="py-2 px-4 border-b-2 text-gray-600 transition hover:text-blue-500 hover:border-blue-500 focus:outline-none"
                    :class="{ 'border-blue-500 text-blue-600': tab === 'about' }">About</button>

                @if ($isOwner)
                <button @click="tab = 'collections'"
                    class="py-2 px-4 border-b-2 text-gray-600 transition hover:text-blue-500 hover:border-blue-500 focus:outline-none"
                    :class="{ 'border-blue-500 text-blue-600': tab === 'collections' }">Collections</button>
                <button @click="tab = 'liked'"
                    class="py-2 px-4 border-b-2 text-gray-600 transition hover:text-blue-500 hover:border-blue-500 focus:outline-none"
                    :class="{ 'border-blue-500 text-blue-600': tab === 'liked' }">Liked</button>
                @endif
            </div>

            <!-- Artworks Tab -->
            <div x-show="tab === 'artworks'" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mt-6">
                @forelse($artworks as $artwork)
                <div class="bg-white rounded-lg shadow-md overflow-hidden transform transition hover:scale-105">
                    @if ($artwork->images->isNotEmpty() && $artwork->images->first()->attachment)
                    <img src="{{ asset('storage/' . $artwork->images->first()->attachment->path) }}" class="w-full h-48 object-cover">
                    @else
                    <img src="{{ asset('images/default-artwork.jpg') }}" class="w-full h-48 object-cover">
                    @endif
                    <div class="p-4">
                        <h4 class="font-semibold text-lg">{{ $artwork->title }}</h4>
                        <a href="{{ route('artwork.show', $artwork) }}"
                            class="bg-blue-500 text-white px-4 py-2 rounded mt-2 inline-block hover:bg-blue-600 transition">Preview</a>
                    </div>
=======
                {{-- @if (!$isOwner)
                <button class="bg-green-500 text-white px-4 py-2 rounded-full mt-4 text-sm">Request Service</button>
                @endif --}}
            </div>

            <!-- Tabs Section -->
            <div class="space-y-12 order-1 lg:order-2" x-data="{ tab: 'artworks' }">
                <div class="flex flex-wrap justify-center space-x-4 border-b pb-2">
                    <template x-for="tabName in ['artworks', 'services', 'reviews', 'about' @if($isOwner), 'collections', 'liked' @endif]">
                        <button @click="tab = tabName" class="tab-button py-2 px-4 border-b-2 border-transparent rounded-t-md transition-colors hover:text-blue-500 hover:border-blue-500 focus:outline-none" x-text="tabName.charAt(0).toUpperCase() + tabName.slice(1)"></button>
                    </template>
                </div>

                <div x-show="tab === 'artworks'" class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div x-show="tab === 'artworks'" class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-6">
                    @forelse($artworks as $artwork)
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        <img src="{{ asset('storage/' . $artwork->images->first()->attachment->path) }}" class="w-full h-48 object-cover">
                        <div class="p-4">
                            <h4 class="font-semibold">{{ $artwork->title }}</h4>
                            <a href="{{ route('artwork.show', $artwork) }}" class="bg-blue-500 text-white px-4 py-2 rounded mt-2 inline-block">Preview</a>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        <img src="{{ asset('storage/' . $artwork->images->first()->attachment->path) }}" class="w-full h-48 object-cover">
                        <div class="p-4">
                            <h4 class="font-semibold">{{ $artwork->title }}</h4>
                            <a href="{{ route('artwork.show', $artwork) }}" class="bg-blue-500 text-white px-4 py-2 rounded mt-2 inline-block">Preview</a>
                        </div>
                    </div>
                    @empty
                    <p>No artworks to show.</p>
                    <p>No artworks to show.</p>
                    @endforelse
>>>>>>> origin/dev
                </div>
                @empty
                <p class="text-gray-500 text-center col-span-full">No artworks available.</p>
                @endforelse
            </div>

<<<<<<< HEAD
            <!-- Services Tab -->
            <div x-show="tab === 'services'" class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-6">
                @forelse($services as $service)
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <img src="{{ asset('storage/' . $service->images->first()->attachment->path) }}" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h4 class="font-semibold">{{ $service->category->name }}</h4>
                        <a href="{{ route('service.show', $service) }}" class="bg-blue-500 text-white px-4 py-2 rounded mt-2 inline-block">Request</a>
                    </div>
=======
                <div x-show="tab === 'services'" class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div x-show="tab === 'services'" class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-6">
                    @forelse($services as $service)
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        <img src="{{ asset('storage/' . $service->images->first()->attachment->path) }}" class="w-full h-48 object-cover">
                        <div class="p-4">
                            <h4 class="font-semibold">{{ $service->category->name }}</h4>
                            <a href="{{ route('service.show', $service) }}" class="bg-blue-500 text-white px-4 py-2 rounded mt-2 inline-block">Request</a>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        <img src="{{ asset('storage/' . $service->images->first()->attachment->path) }}" class="w-full h-48 object-cover">
                        <div class="p-4">
                            <h4 class="font-semibold">{{ $service->category->name }}</h4>
                            <a href="{{ route('service.show', $service) }}" class="bg-blue-500 text-white px-4 py-2 rounded mt-2 inline-block">Request</a>
                        </div>
                    </div>
                    @empty
                    <p>No services to show.</p>
                    <p>No services to show.</p>
                    @endforelse
                </div>

                <div x-show="tab === 'about'" class="mt-6 p-6 bg-white rounded-lg shadow-lg text-center">
                <div x-show="tab === 'about'" class="mt-6 p-6 bg-white rounded-lg shadow-lg text-center">
                    <h2 class="text-2xl font-bold">About Me</h2>
                    <p class="mt-4 text-gray-700">{{ $artist->bio }}</p>
>>>>>>> origin/dev
                </div>
                @empty
                <p>No services to show.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>