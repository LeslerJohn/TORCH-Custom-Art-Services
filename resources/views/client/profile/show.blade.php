<x-app-layout>
    <!-- Hero Banner -->
    <div class="w-full h-64">
        <img src="{{ $client->user->coverImage ? asset('storage/' . $client->user->coverImage->path) : asset('images/default.image.jpg') }}"
            class="w-full h-full object-cover" alt="Hero Banner">
    </div>

    <!-- Profile Section -->
    <div class="container mx-auto px-6 mt-8"> <!-- Removed negative margin -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <!-- Profile Picture -->
            <div class="flex justify-center -mt-16"> <!-- Adjusted negative margin -->
                <img class="h-32 w-32 rounded-full border-4 border-white shadow-lg"
                    src="{{ $client->user->profileImage ? asset('storage/' . $client->user->profileImage->path) : asset('images/profile.default.jpg') }}"
                    alt="Profile Picture">
            </div>

            <!-- Artist Name & Details -->
            <div class="text-center mt-4">
                <h1 class="text-3xl font-bold">{{ $client->user->name }}</h1>
                <p class="text-gray-600 mt-2">{{ $client->user->email }}</p>
                <p class="text-gray-700 mt-2 italic">{{ $client->quote }}</p>

                <!-- Edit Profile Button -->
                <div class="mt-4">
                    <a href="{{route('profile.edit')}}">
                        <button
                            class="bg-blue-500 text-white px-6 py-2 rounded-full hover:bg-blue-600 transition duration-300">
                            Edit Profile
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Tab Navigation -->
    <div x-data="{ tab: 'portfolio' }" class="container mx-auto px-6 mt-8">
        <div class="flex justify-center space-x-4 border-b">
            @foreach (['collections', 'liked'] as $tab)
                <button @click="tab = '{{ $tab }}'"
                    :class="{ 'text-blue-500 border-b-2 border-blue-500': tab === '{{ $tab }}', 'text-gray-600 hover:text-gray-800': tab !== '{{ $tab }}' }"
                    class="py-2 px-4 focus:outline-none">
                    {{ ucfirst($tab) }}
                </button>
            @endforeach
        </div>

        <!-- Collections -->
        <div x-show="tab === 'collections'"
            class="mt-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($collections as $collection)
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <img src="{{ asset($collection->image) }}" alt="Collection {{ $loop->iteration }}"
                        class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h4 class="text-lg font-semibold">{{ $collection->title }}</h4>
                        <p class="text-sm text-gray-600 mt-2">{{ $collection->description }}</p>
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-600">No collections found.</p>
            @endforelse
        </div>

        <!-- Liked -->
        <div x-show="tab === 'liked'" class="mt-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($liked as $likedItem)
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <img src="{{ asset($likedItem->image) }}" alt="Liked Item {{ $loop->iteration }}"
                        class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h4 class="text-lg font-semibold">{{ $likedItem->title }}</h4>
                        <p class="text-sm text-gray-600 mt-2">{{ $likedItem->description }}</p>
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-600">No liked items found.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>
