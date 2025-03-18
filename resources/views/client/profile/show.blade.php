<x-app-layout>
    <div class="container mx-auto max-w-7xl px-4 sm:px-6 mt-6 flex flex-col sm:flex-row"
        x-data="{ open: window.innerWidth >= 640, tab: 'collections' }"
        x-init="() => { 
            window.addEventListener('resize', () => { 
                open = window.innerWidth >= 640; // Update `open` on window resize
            }); 
        }">

        <!-- Mobile Dropdown Sidebar (Stacked Above on Mobile) -->
        <div class="sm:hidden mb-4">
            <!-- Dropdown Toggle Button (Shifts into Expanded Form) -->
            <div class="bg-white shadow-md rounded-lg p-3 transition-all duration-300"
                :class="open ? 'h-auto' : 'h-16 overflow-hidden'">
                <!-- Toggle Button Header -->
                <button @click="open = !open"
                    class="w-full flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <!-- Small Profile Image (Only Visible When Collapsed) -->
                        <img x-show="!open" src="{{ $client->user->profileImage ? asset('storage/' . $client->user->profileImage->path) : asset('images/profile.default.jpg') }}"
                            class="w-10 h-10 rounded-full object-cover border-2 border-white shadow-md">
                        <!-- Name (Hidden when dropdown is open) -->
                        <span class="text-lg font-semibold" :class="open ? 'hidden' : 'block'">{{ $client->user->name }}</span>
                    </div>
                    <!-- Dropdown Arrow -->
                    <span class="text-gray-600 text-2xl transition-transform duration-300"
                        :class="open ? 'rotate-180' : 'rotate-0'">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down">
                            <path d="m6 9 6 6 6-6" />
                        </svg>
                    </span>
                </button>

                <!-- Dropdown Content (Shifts into view) -->
                <div x-show="open" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform scale-95"
                    x-transition:enter-end="opacity-100 transform scale-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 transform scale-100"
                    x-transition:leave-end="opacity-0 transform scale-95"
                    class="mt-4">
                    <!-- Large Profile Image (Only Visible When Expanded) -->
                    <div class="text-center">
                        <img src="{{ $client->user->profileImage ? asset('storage/' . $client->user->profileImage->path) : asset('images/profile.default.jpg') }}"
                            class="w-32 h-32 rounded-full object-cover border-4 border-white shadow-md mx-auto">
                        <h2 class="text-xl font-semibold mt-3">{{ $client->user->name }}</h2>
                        <p class="text-gray-500 text-sm">{{ $client->username }}</p>
                    </div>

                    <!-- Action Button -->
                    <div class="mt-4">
                        <a href="{{ route('profile.edit', $client) }}"
                            class="block w-full bg-blue-500 text-white px-4 py-2 rounded-full hover:bg-blue-600 transition flex items-center justify-center">
                            <!-- Edit SVG Icon -->
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                </path>
                            </svg>
                            Edit Profile
                        </a>
                    </div>

                    <!-- Profile Details -->
                    <div class="mt-4 text-gray-700 text-sm space-y-2">
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                </path>
                            </svg>
                            <p>(+63) {{ $client->user->phone_number }}</p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z">
                                </path>
                            </svg>
                            <p>{{ $client->rating }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Desktop Sidebar (Hidden on Mobile) -->
        <div class="hidden sm:block transition-all duration-300 ease-in-out flex flex-col bg-white shadow-lg rounded-2xl p-3 relative"
            :class="open ? 'w-72' : 'w-20 items-center'">
            <!-- Profile + Toggle Button Container -->
            <div class="flex w-full transition-all duration-300"
                :class="open ? 'justify-between' : 'flex-col-reverse items-center space-y-2'">

                <!-- Small Profile Image (Only Visible When Closed) -->
                <img src="{{ $client->user->profileImage ? asset('storage/' . $client->user->profileImage->path) : asset('images/profile.default.jpg') }}"
                    class="rounded-full object-cover border-2 border-white shadow-md transition-all"
                    :class="open ? 'hidden' : 'w-12 h-12 mt-2'">

                <!-- Toggle Button (Smooth Animation) -->
                <button @click="open = !open"
                    class="bg-white shadow-md w-10 h-10 flex items-center justify-center rounded-full transition-all duration-500 ease-in-out transform"
                    :class="open ? 'rotate-0 ml-auto scale-100' : 'rotate-180 scale-90'">
                    <span class="text-gray-600 text-2xl transition-transform duration-500 ease-in-out">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-left">
                            <path d="m15 18-6-6 6-6" />
                        </svg>
                    </span>
                </button>
            </div>

            <!-- Large Profile Image (Only Visible When Open) -->
            <div class="text-center transition-all duration-300" :class="open ? 'block' : 'hidden'">
                <img src="{{ $client->user->profileImage ? asset('storage/' . $client->user->profileImage->path) : asset('images/profile.default.jpg') }}"
                    class="w-40 h-40 rounded-full object-cover border-4 border-white shadow-md mx-auto">
                <h2 class="text-xl font-semibold mt-3">{{ $client->user->name }}</h2>
                
                <!-- Action Button -->
                <div class="mt-4">
                    <a href="{{ route('profile.edit', $client) }}"
                        class="block w-full bg-blue-500 text-white px-4 py-2 rounded-full hover:bg-blue-600 transition flex items-center justify-center">
                        <!-- Edit SVG Icon -->
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                            </path>
                        </svg>
                        Edit Profile
                    </a>
                </div>

                <!-- Profile Details -->
                <div class="mt-4 text-gray-700 text-sm space-y-2">
                    <div class="flex items-center space-x-2">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                            </path>
                        </svg>
                        <p>(+63) {{ $client->user->phone_number }}</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z">
                            </path>
                        </svg>
                        <p>{{ $client->rating }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 transition-all duration-300 px-4 max-h-[calc(125vh-300px)] overflow-y-auto no-scrollbar"
            :class="open ? 'sm:ml-5' : 'sm:ml-5'">
            <!-- Hero Banner -->
            <div class="relative w-full h-48 sm:h-64 rounded-lg overflow-hidden">
                <img src="{{ $client->user->coverImage ? asset('storage/' . $client->user->coverImage->path) : asset('images/default.image.jpg') }}"
                    class="w-full h-full object-cover">
            </div>

            <!-- Tab Navigation -->
            <div class="flex flex-wrap justify-center space-x-2 sm:space-x-4 border-b pb-2 mt-7 sticky top-0 bg-white rounded-lg z-10">
                <button @click="tab = 'collections'"
                    class="py-2 px-2 sm:px-4 border-b-2 text-gray-600 transition hover:text-blue-500 hover:border-blue-500 focus:outline-none text-sm sm:text-base flex items-center space-x-2"
                    :class="{ 'border-blue-500 text-blue-600': tab === 'collections' }">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                    <span :class="tab === 'collections' ? 'block' : 'hidden sm:block'">Collections</span>
                </button>
                <button @click="tab = 'liked'"
                    class="py-2 px-2 sm:px-4 border-b-2 text-gray-600 transition hover:text-blue-500 hover:border-blue-500 focus:outline-none text-sm sm:text-base flex items-center space-x-2"
                    :class="{ 'border-blue-500 text-blue-600': tab === 'liked' }">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                    <span :class="tab === 'liked' ? 'block' : 'hidden sm:block'">Liked</span>
                </button>
            </div>

            <!-- Collections Tab -->
            <div x-show="tab === 'collections'" class="mt-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($collections as $collection)
                    @foreach ($collection->items as $item)
                    <a href="{{ route('artwork.show', $item->artwork) }}"
                        class="bg-white p-4 rounded-lg shadow-md flex flex-col">
                        <div class="mb-4">
                            <h4 class="font-semibold text-lg">{{ $item->artwork->title }}</h4>
                            <p class="text-gray-500 text-sm">{{ $item->artwork->description }}</p>
                            @if ($item->artwork->images->isNotEmpty() && $item->artwork->images->first()->attachment)
                            <img src="{{ asset('storage/' . $item->artwork->images->first()->attachment->path) }}"
                                class="w-full h-40 object-cover rounded-lg mt-2"
                                alt="{{ $item->artwork->title }}">
                            @else
                            <img src="{{ asset('images/default-artwork.jpg') }}"
                                class="w-full h-40 object-cover rounded-lg mt-2"
                                alt="Default Artwork">
                            @endif
                        </div>
                    </a>
                    @endforeach
                    @empty
                    <p class="text-gray-500 text-center col-span-full">No collections available.</p>
                    @endforelse
                </div>
            </div>

            <!-- Liked Tab -->
            <div x-show="tab === 'liked'" class="mt-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($liked as $like)
                    <a href="{{ route('artwork.show', $like->artwork) }}"
                        class="bg-white p-4 rounded-lg shadow-md flex flex-col transform transition-transform duration-300 hover:scale-105 hover:shadow-lg">
                        <div class="flex items-center space-x-3 mb-4">
                            <img src="{{ $like->artwork->images && $like->artwork->images->first() && $like->artwork->images->first()->attachment ? asset('storage/' . $like->artwork->images->first()->attachment->path) : asset('images/default-artwork.jpg') }}"
                                class="w-10 h-10 rounded-full object-cover">
                            <div>
                                <h4 class="font-semibold">{{ $like->artwork->title }}</h4>
                                <p class="text-sm text-gray-500">
                                    {{ $like->artwork->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                        <p class="text-gray-700">{{ $like->artwork->description }}</p>
                    </a>
                    @empty
                    <p class="text-gray-500 text-center col-span-full">No liked artworks available.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<style>
    .no-scrollbar::-webkit-scrollbar {
        display: none;
    }
</style>