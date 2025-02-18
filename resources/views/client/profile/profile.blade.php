<x-app-layout>
    <!-- Hero Banner -->
    <div class="w-full h-64">
        <img src="{{ asset('images/fortnite-kintsugi-daigo-chapter-6-s1-hunters-4k-wallpaper-uhdpaper.com-84@5@b.jpg') }}" class="w-full h-full object-cover" alt="Hero Banner">
    </div>

    <!-- Profile Section -->
    <div class="container mx-auto px-6 mt-8"> <!-- Removed negative margin -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <!-- Profile Picture -->
            <div class="flex justify-center -mt-16"> <!-- Adjusted negative margin -->
                <img class="h-32 w-32 rounded-full border-4 border-white shadow-lg" src="{{ asset('images/default-avatar.png') }}" alt="Profile Picture">
            </div>

            <!-- Artist Name & Details -->
            <div class="text-center mt-4">
                <h1 class="text-3xl font-bold">Mimorod Banaag</h1>
                <p class="text-gray-600 mt-2">Freelance Artist · Zamboanga Sibugay</p>
                <p class="text-gray-700 mt-2 italic">"Creating art is my way of breathing life into my work."</p>

                <!-- Edit Profile Button -->
                <div class="mt-4">
                    <button class="bg-blue-500 text-white px-6 py-2 rounded-full hover:bg-blue-600 transition duration-300">
                        Edit Profile
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Tab Navigation -->
    <div x-data="{ tab: 'portfolio' }" class="container mx-auto px-6 mt-8">
        <div class="flex justify-center space-x-4 border-b">
            @foreach(['portfolio', 'services', 'collections', 'liked'] as $tab)
            <button @click="tab = '{{ $tab }}'"
                :class="{ 'text-blue-500 border-b-2 border-blue-500': tab === '{{ $tab }}', 'text-gray-600 hover:text-gray-800': tab !== '{{ $tab }}' }"
                class="py-2 px-4 focus:outline-none">
                {{ ucfirst($tab) }}
            </button>
            @endforeach
        </div>

        <!-- Portfolio Grid -->
        <div x-show="tab === 'portfolio'" class="mt-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach(range(1, 6) as $i)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <img src="{{ asset('images/portfolio' . $i . '.jpg') }}" alt="Artwork {{ $i }}" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h4 class="text-lg font-semibold">Artwork Title {{ $i }}</h4>
                    <p class="text-sm text-gray-600 mt-2">Description of the artwork.</p>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Services -->
        <div x-show="tab === 'services'" class="mt-6">
            <ul class="space-y-4">
                @foreach(['Custom Paintings', 'Digital Art', 'Art Classes'] as $service)
                <li class="bg-white p-6 rounded-lg shadow-md">
                    <h4 class="text-lg font-semibold">{{ $service }}</h4>
                    <p class="text-gray-600 mt-2">Detailed description about {{ strtolower($service) }}.</p>
                </li>
                @endforeach
            </ul>
        </div>

        <!-- Collections -->
        <div x-show="tab === 'collections'" class="mt-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach(range(1, 4) as $i)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <img src="{{ asset('images/collection' . $i . '.jpg') }}" alt="Collection {{ $i }}" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h4 class="text-lg font-semibold">Collection Title {{ $i }}</h4>
                    <p class="text-sm text-gray-600 mt-2">Description of the collection.</p>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Liked -->
        <div x-show="tab === 'liked'" class="mt-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach(range(1, 4) as $i)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <img src="{{ asset('images/liked' . $i . '.jpg') }}" alt="Liked Item {{ $i }}" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h4 class="text-lg font-semibold">Liked Title {{ $i }}</h4>
                    <p class="text-sm text-gray-600 mt-2">Description of the liked item.</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</x-app-layout>