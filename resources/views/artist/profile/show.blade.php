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
            <div class="flex items-center space-x-2">
                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <p>{{ $artist->location }}</p>
            </div>
            <div class="flex items-center space-x-2">
                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                </svg>
                <p>{{ $artist->phone_number }}</p>
            </div>
            <div class="flex items-center space-x-2">
                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p>{{ ucfirst($artist->status) }}</p>
            </div>
            <div class="flex items-center space-x-2">
                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                </svg>
                <p>{{ $artist->rating }}</p>
            </div>
            <div class="flex items-center space-x-2">
                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <p>{{ $artist->available ? 'Available' : 'Not Available' }}</p>
            </div>
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
    <footer class="bg-gray-50 py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row justify-between items-center gap-6">
                <!-- Logo -->
                <img src="{{ asset('images/torch-full-high-resolution-logo-transparent.png') }}" alt="Torch Logo" class="w-16 sm:w-24">

                <!-- Links -->
                <div class="flex flex-wrap justify-center gap-4 sm:gap-6 text-sm text-gray-600">
                    <a href="#" class="hover:text-orange-500 transition">About</a>
                    <a href="#" class="hover:text-orange-500 transition">Contact</a>
                    <a href="#" class="hover:text-orange-500 transition">Terms of Service</a>
                    <a href="#" class="hover:text-orange-500 transition">Privacy Policy</a>
                    <a href="#" class="hover:text-orange-500 transition">Support</a>
                </div>

                <!-- Social Icons -->
                <div class="flex items-center gap-4">
                    <a href="#" class="text-gray-600 hover:text-orange-500 transition">
                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M13.135 6H15V3h-1.865a4.147 4.147 0 0 0-4.142 4.142V9H7v3h2v9.938h3V12h2.021l.592-3H12V6.591A.6.6 0 0 1 12.592 6h.543Z" clip-rule="evenodd" />
                        </svg>
                    </a>
                    <a href="#" class="text-gray-600 hover:text-orange-500 transition">
                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <path fill="currentColor" fill-rule="evenodd" d="M3 8a5 5 0 0 1 5-5h8a5 5 0 0 1 5 5v8a5 5 0 0 1-5 5H8a5 5 0 0 1-5-5V8Zm5-3a3 3 0 0 0-3 3v8a3 3 0 0 0 3 3h8a3 3 0 0 0 3-3V8a3 3 0 0 0-3-3H8Zm7.597 2.214a1 1 0 0 1 1-1h.01a1 1 0 1 1 0 2h-.01a1 1 0 0 1-1-1ZM12 9a3 3 0 1 0 0 6 3 3 0 0 0 0-6Zm-5 3a5 5 0 1 1 10 0 5 5 0 0 1-10 0Z" clip-rule="evenodd" />
                        </svg>
                    </a>
                    <a href="#" class="text-gray-600 hover:text-orange-500 transition">
                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M22 5.892a8.178 8.178 0 0 1-2.355.635 4.074 4.074 0 0 0 1.8-2.235 8.343 8.343 0 0 1-2.605.981A4.13 4.13 0 0 0 15.85 4a4.068 4.068 0 0 0-4.1 4.038c0 .31.035.618.105.919A11.705 11.705 0 0 1 3.4 4.734a4.006 4.006 0 0 0 1.268 5.392 4.165 4.165 0 0 1-1.859-.5v.05A4.057 4.057 0 0 0 6.1 13.635a4.192 4.192 0 0 1-1.856.07 4.108 4.108 0 0 0 3.831 2.807A8.36 8.36 0 0 1 2 18.184 11.732 11.732 0 0 0 8.291 20 11.502 11.502 0 0 0 19.964 8.5c0-.177 0-.349-.012-.523A8.143 8.143 0 0 0 22 5.892Z" clip-rule="evenodd" />
                        </svg>
                    </a>
                    <a href="#" class="text-gray-600 hover:text-orange-500 transition">
                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M12.51 8.796v1.697a3.738 3.738 0 0 1 3.288-1.684c3.455 0 4.202 2.16 4.202 4.97V19.5h-3.2v-5.072c0-1.21-.244-2.766-2.128-2.766-1.827 0-2.139 1.317-2.139 2.676V19.5h-3.19V8.796h3.168ZM7.2 6.106a1.61 1.61 0 0 1-.988 1.483 1.595 1.595 0 0 1-1.743-.348A1.607 1.607 0 0 1 5.6 4.5a1.601 1.601 0 0 1 1.6 1.606Z" clip-rule="evenodd" />
                            <path d="M7.2 8.809H4V19.5h3.2V8.809Z" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Copyright -->
            <div class="mt-8 text-center text-sm text-gray-500">
                &copy; {{ now()->year }} Torch. All rights reserved.
            </div>
        </div>
    </footer>
</x-app-layout>