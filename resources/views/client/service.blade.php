<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
        <div class="flex items-center justify-between w-full mb-4">
            <h2 class="text-xl font-bold">Services</h2>
        </div>

        <!-- Filters -->
        <form method="GET" action="{{ route('client.service') }}" class="mb-4">
            <div class="flex items-center gap-2 overflow-x-auto whitespace-nowrap py-2 border rounded-lg shadow-sm">

                <!-- Availability -->
                <button type="submit" name="available" value="1"
                    class="px-4 py-1 border rounded-full 
                    {{ request('available') == '1' ? 'bg-black text-white' : 'bg-gray-200 text-black' }}">
                    Open Services
                </button>

                <!-- Sort Options -->
                <button type="submit" name="sort" value="random"
                    class="px-4 py-1 border rounded-full 
                    {{ request('sort') == 'random' ? 'bg-black text-white' : 'bg-gray-200 text-black' }}">
                    Random
                </button>
                <button type="submit" name="sort" value="latest"
                    class="px-4 py-1 border rounded-full 
                    {{ request('sort') == 'latest' ? 'bg-black text-white' : 'bg-gray-200 text-black' }}">
                    Latest
                </button>

                <!-- Category Filter -->
                <select name="category" onchange="this.form.submit()"
                    class="px-4 py-1 border rounded-full bg-gray-200 text-black">
                    <option value="">All Categories</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>

                <!-- Tags (Scrollable) -->
                <div class="flex items-center gap-2 overflow-x-auto">
                    @foreach ($tags as $tag)
                        <label
                            class="px-4 py-1 border rounded-full cursor-pointer
                            {{ in_array($tag->id, request()->input('tags', [])) ? 'bg-black text-white' : 'bg-gray-200 text-black' }}">
                            <input type="checkbox" name="tags[]" value="{{ $tag->id }}" class="hidden"
                                onchange="this.form.submit()"
                                {{ in_array($tag->id, request()->input('tags', [])) ? 'checked' : '' }}>
                            {{ $tag->name }}
                        </label>
                    @endforeach
                </div>
            </div>
        </form>

        <!-- Services Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($services as $service)
                @php
                    $thumbnail = $service->images->first()?->attachment;
                @endphp
                <a href="{{ route('service.show', $service) }}">
                <div class="relative w-full h-[250px] rounded-lg overflow-hidden shadow-lg">
                    <!-- Background Image -->
                    <img src="{{ $thumbnail ? asset('storage/' . $thumbnail->path) : asset('images/default-image.jpg') }}"
                        alt="Service Image" class="w-full h-full object-cover">

                    <!-- Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>

                    <!-- Text Content -->
                    <div class="absolute bottom-4 left-4 text-white">
                        <h2 class="text-lg font-bold">{{ $service->category->name }}</h2>
                        <p class="text-sm">| 
                            @foreach ($service->tags as $tag)
                                {{ $tag->name }}@if (!$loop->last), @endif
                            @endforeach
                        </p>

                        <!-- Artist Info -->
                        <div class="flex items-center gap-2 mt-2">
                            <img src="{{ asset('images/profile.default.jpg') }}" alt="Artist"
                                class="w-6 h-6 rounded-full border border-white">
                            <p class="text-sm font-medium flex items-center">
                                {{ $service->artist->user->name }}
                                <svg class="w-4 h-4 text-blue-400 ml-1" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 15l-4-4 1.41-1.41L11 13.17l5.59-5.59L18 9l-7 7z" />
                                </svg>
                            </p>
                        </div>
                    </div>
                </div>
            </a>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $services->withQueryString()->links() }}
        </div>
    </div>
</x-app-layout>
