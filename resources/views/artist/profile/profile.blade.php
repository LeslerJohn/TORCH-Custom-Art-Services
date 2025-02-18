<x-app-layout>
    <!-- Hero Banner -->
    <div class="w-full h-64 bg-gray-200">
        <img src="{{ asset('images/1483b576-5735-498a-8d47-e5843fc3dc6f.jpeg') }}" class="w-full h-full object-cover" alt="Hero Banner">
    </div>

    <!-- Main Content Container -->
    <div class="container mx-auto px-6 -mt-20">
        <!-- Grid Layout for Profile and Tabs -->
        <div class="grid grid-cols-1 lg:grid-cols-2 lg:gap-8 gap-8">
            <!-- Tabs Section (Left Column) -->
            <div>
                <!-- Tab Navigation -->
                <div x-data="{ tab: 'portfolio' }" class="mt-8">
                    <div class="flex justify-center space-x-4 border-b">
                        @foreach(['portfolio', 'collections', 'liked', 'about'] as $tab)
                        <button @click="tab = '{{ $tab }}'"
                            :class="{ 'text-blue-500 border-b-2 border-blue-500': tab === '{{ $tab }}', 'text-gray-600 hover:text-gray-800': tab !== '{{ $tab }}' }"
                            class="py-2 px-4 focus:outline-none">
                            {{ ucfirst($tab) }}
                        </button>
                        @endforeach
                    </div>

                    <!-- Portfolio Grid -->
                    <div x-show="tab === 'portfolio'" class="mt-6 mb-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-2 gap-6">
                        @foreach(range(1, 8) as $i)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden">
                            <img src="{{ asset('images/1483b576-5735-498a-8d47-e5843fc3dc6f.jpeg') }}" alt="Artwork {{ $i }}" class="w-full h-48 object-cover">
                            <div class="p-4">
                                <h4 class="text-lg font-semibold">Artwork Title {{ $i }}</h4>
                                <p class="text-sm text-gray-600 mt-2">Description of the artwork.</p>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- About Section -->
                    <div x-show="tab === 'about'" class="mt-6">
                        <div class="bg-white p-6 rounded-lg shadow-md">
                            <h2 class="text-2xl font-bold">About Me</h2>
                            <p class="text-gray-700 mt-4">
                                I am a freelance artist based in Zamboanga Sibugay, specializing in digital and traditional art. My work is inspired by nature, culture, and the human experience. I believe that art is a powerful way to express emotions and tell stories.
                            </p>
                        </div>
                    </div>

                    <!-- Collections -->
                    <div x-show="tab === 'collections'" class="mt-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-2 gap-6">
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
                    <div x-show="tab === 'liked'" class="mt-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-2 gap-6">
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
            </div>

            <!-- Profile Section (Right Column) -->
            <div class="text-center lg:text-left lg:pl-8">
                <!-- Profile Picture -->
                <div class="flex justify-center lg:justify-start">
                    <img class="h-40 w-40 rounded-full border-4 border-white shadow-lg mt-8" src="{{ asset('images/6f51ebf3-4282-4f70-bef4-3eeb88a38ef2.jpeg') }}" alt="Profile Picture">
                </div>

                <!-- Artist Name & Details -->
                <h1 class="text-4xl font-bold mt-4">Mimorod Banaag</h1>
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
</x-app-layout>