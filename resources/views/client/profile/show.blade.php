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
            <div x-show="tab === 'collections'" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mt-6">
                @forelse($collections as $collection)
                <div class="bg-white rounded-lg shadow-md overflow-hidden transform transition hover:scale-105">
                    <img src="{{ asset($collection->image) }}" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h4 class="font-semibold text-lg">{{ $collection->title }}</h4>
                    </div>
                </div>
                @empty
                <p class="text-gray-500 text-center col-span-full">No collections available.</p>
                @endforelse
            </div>

            <!-- Liked Tab -->
            <div x-show="tab === 'liked'" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mt-6">
                @forelse($liked as $likedItem)
                <div class="bg-white rounded-lg shadow-md overflow-hidden transform transition hover:scale-105">
                    <img src="{{ asset($likedItem->image) }}" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h4 class="font-semibold text-lg">{{ $likedItem->title }}</h4>
                    </div>
                </div>
                @empty
                <p class="text-gray-500 text-center col-span-full">No liked items available.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>