<x-app-layout>
    <div class="container mx-auto max-w-7xl px-6 mt-6 flex" x-data="{ open: true, tab: 'collections' }">
        <!-- Sidebar -->
        <div class="transition-all duration-300 ease-in-out flex flex-col bg-white shadow-lg rounded-2xl p-3 relative"
            :class="open ? 'w-72' : 'w-20 items-center'">

            <!-- Profile + Toggle Button Container -->
            <div class="flex w-full transition-all duration-300"
                :class="open ? 'justify-between' : 'flex-col-reverse items-center space-y-2'">
                <!-- Small Profile Image (Only Visible When Closed) -->
                <img src="{{ $client->user->profileImage ? asset('storage/' . $client->user->profileImage->path) : asset('images/profile.default.jpg') }}"
                    class="rounded-full object-cover border-2 border-white shadow-md transition-all"
                    :class="open ? 'hidden' : 'w-12 h-12 mt-2'">

                <!-- Toggle Button -->
                <button @click="open = !open"
                    class="bg-white shadow-md w-10 h-10 flex items-center justify-center rounded-full transition-all duration-500 ease-in-out transform"
                    :class="open ? 'rotate-0 ml-auto scale-100' : 'rotate-180 scale-90'">
                    <span class="text-gray-600 text-2xl transition-transform duration-500 ease-in-out">←</span>
                </button>
            </div>

            <!-- Large Profile Image (Only Visible When Open) -->
            <div class="text-center transition-all duration-300" :class="open ? 'block' : 'hidden'">
                <img src="{{ $client->user->profileImage ? asset('storage/' . $client->user->profileImage->path) : asset('images/profile.default.jpg') }}"
                    class="w-24 h-24 rounded-full object-cover border-4 border-white shadow-md mx-auto">
                <h2 class="text-xl font-semibold mt-3">{{ $client->user->name }}</h2>
                <p class="text-gray-500 text-sm">{{ $client->username }}</p>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 transition-all duration-300 px-4" :class="open ? 'ml-5' : 'ml-16'">
            <!-- Hero Banner -->
            <div class="relative w-full h-64">
                <img src="{{ $client->user->coverImage ? asset('storage/' . $client->user->coverImage->path) : asset('images/default.image.jpg') }}"
                    class="w-full h-full object-cover rounded-lg shadow-md">
            </div>

            <!-- Tab Navigation -->
            <div class="flex justify-center space-x-4 border-b pb-2 mt-6">
                <button @click="tab = 'collections'"
                    class="py-2 px-4 border-b-2 text-gray-600 transition hover:text-blue-500 hover:border-blue-500 focus:outline-none"
                    :class="{ 'border-blue-500 text-blue-600': tab === 'collections' }">Collections</button>
                <button @click="tab = 'liked'"
                    class="py-2 px-4 border-b-2 text-gray-600 transition hover:text-blue-500 hover:border-blue-500 focus:outline-none"
                    :class="{ 'border-blue-500 text-blue-600': tab === 'liked' }">Liked</button>
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
                                        {{ $like->artwork->created_at->diffForHumans() }}</p>
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