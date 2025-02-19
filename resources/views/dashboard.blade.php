<x-app-layout>
    <div class="bg-gradient-to-r from-white to-orange-100">
        <div class="w-full mx-auto bg-gradient-to-r from-white to-orange-100 min-h-screen flex items-center">
            <div class="container h-screen pb-16 mx-auto flex justify-between items-center px-12">
                <!-- Text Section -->
                <div class="w-1/2 pl-12">
                    <h1 class="text-7xl font-bold leading-tight">
                        Discover the Timeless World of
                        <span class="text-orange-500">Traditional Art.</span>
                    </h1>
                    <p class="text-2xl text-gray-700 fon-bold mt-4">
                        Explore traditional masterpieces by passionate artists, ready to transform your ideas into
                        reality.
                    </p>
                </div>

                <!-- Image Section -->
                <div class="relative w-[850px] h-full pb-16">
                    <img src="{{ asset('images/Hero.png') }}" alt="Hero Picture" class="w-full h-full object-cover">
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 pb-16 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="mb-4 flex justify-between items-center border-b border-gray-200 dark:border-gray-700">
                <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab"
                    data-tabs-toggle="#default-tab-content" role="tablist">
                    <li class="me-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 rounded-t-lg" id="showcase-tab"
                            data-tabs-target="#profile" type="button" role="tab" aria-controls="profile"
                            aria-selected="false">Showcases</button>
                    </li>
                    <li class="me-2" role="presentation">
                        <button
                            class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                            id="dashboard-tab" data-tabs-target="#dashboard" type="button" role="tab"
                            aria-controls="dashboard" aria-selected="false">Artists</button>
                    </li>
                    <li class="me-2" role="presentation">
                        <button
                            class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                            id="settings-tab" data-tabs-target="#settings" type="button" role="tab"
                            aria-controls="settings" aria-selected="false">Services</button>
                    </li>
                    <li role="presentation">
                        <button
                            class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                            id="contacts-tab" data-tabs-target="#contacts" type="button" role="tab"
                            aria-controls="contacts" aria-selected="false">Sale</button>
                    </li>
                </ul>
                <div class="text-sm font-medium text-center">
                    <a href="#"
                        class="flex items-center justify-center gap-2 text-gray-500 dark:text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                        See All
                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 12H5m14 0-4 4m4-4-4-4" />
                        </svg>
                    </a>
                </div>
            </div>
            <div id="default-tab-content">
                <!-- Artwork Grid -->
                <div class="hidden rounded-lg dark:bg-gray-800" id="profile" role="tabpanel"
                    aria-labelledby="showcase-tab">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($artworks as $artwork)
                            @if ($artwork->is_showcase)
                                <button type="button" onclick="openArtworkModal(this)"
                                    data-artwork="{{ json_encode([
                                        'title' => $artwork->title,
                                        'category' => $artwork->category->name,
                                        'artist' => $artwork->artist->user->name,
                                        'artist_image' => asset('images/profile.default.jpg'),
                                        'description' => $artwork->description,
                                        'created_at' => $artwork->created_at->format('F j, Y'),
                                        'tags' => $artwork->tags->pluck('name'),
                                        'images' => $artwork->images->map(fn($img) => asset('storage/' . $img->attachment->path)),
                                    ]) }}">
                                    @php
                                        $thumbnail = $artwork->images->first()?->attachment;
                                    @endphp

                                    <div class="relative w-full h-[250px] rounded-lg overflow-hidden cursor-pointer">
                                        <!-- Background Image -->
                                        <img src="{{ $thumbnail ? asset('storage/' . $thumbnail->path) : asset('images/default-image.jpg') }}"
                                            alt="{{ $artwork->title }}" class="w-full h-full object-cover">

                                        <!-- Overlay -->
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent">
                                        </div>

                                        <!-- Text Content -->
                                        <div class="absolute bottom-4 left-4 text-white">
                                            <h2 class="text-lg text-start font-bold">{{ $artwork->title }}</h2>
                                            <p class="text-sm text-start">| {{ $artwork->category->name }}</p>

                                            <!-- Artist Info -->
                                            <div class="flex items-center gap-2 mt-2">
                                                <img src="{{ asset('images/profile.default.jpg') }}" alt="Artist"
                                                    class="w-6 h-6 rounded-full border border-white">
                                                <p class="text-sm font-medium flex items-center">
                                                    {{ $artwork->artist->user->name }}
                                                    <svg class="w-4 h-4 text-blue-400 ml-1" fill="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path
                                                            d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 15l-4-4 1.41-1.41L11 13.17l5.59-5.59L18 9l-7 7z" />
                                                    </svg>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </button>

                                <div id="popup-modal"
                                    class="hidden fixed inset-0 z-50 flex justify-center items-center bg-black/50">
                                    <div class="bg-white rounded-lg shadow-lg p-8 w-full max-w-4xl max-h-5xl relative">
                                        <!-- Close Button -->
                                        <button class="absolute top-5 right-5 text-gray-600 hover:text-gray-900"
                                            onclick="closeArtworkModal()">
                                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 14 14">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                            </svg>
                                        </button>

                                        <div class="flex gap-4">
                                            <!-- Carousel Section -->
                                            <div class="w-1/2 relative">
                                                <div id="carousel-items"
                                                    class="relative h-full overflow-hidden rounded-lg"></div>

                                                <!-- Carousel Controls -->
                                                <button type="button"
                                                    class="absolute top-1/2 left-2 transform -translate-y-1/2 bg-white/30 px-3 py-2 rounded-full"
                                                    onclick="prevSlide()">
                                                    <svg class="w-4 h-4 text-black dark:text-gray-800 rtl:rotate-180"
                                                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                        fill="none" viewBox="0 0 6 10">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2"
                                                            d="M5 1 1 5l4 4" />
                                                    </svg>
                                                </button>
                                                <button type="button"
                                                    class="absolute top-1/2 right-2 transform -translate-y-1/2 bg-white/30 px-3 py-2 rounded-full"
                                                    onclick="nextSlide()">
                                                    <svg class="w-4 h-4 text-black dark:text-gray-800 rtl:rotate-180"
                                                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                        fill="none" viewBox="0 0 6 10">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2"
                                                            d="m1 9 4-4-4-4" />
                                                    </svg>
                                                </button>

                                                <!-- Carousel Indicators -->
                                                <div id="carousel-indicators"
                                                    class="absolute bottom-3 left-1/2 transform -translate-x-1/2 flex gap-2">
                                                </div>
                                            </div>

                                            <!-- Artwork Details -->
                                            <div class="w-1/2">
                                                <div class="flex items-center gap-2 mt-2">
                                                    <img id="modal-artist-image" src="" alt="Artist"
                                                        class="w-10 h-10 rounded-full border border-white">
                                                    <div>
                                                        <div class="flex items-center gap-1">
                                                            <p id="modal-artist"
                                                                class="text-lg font-medium flex items-center">
                                                            </p>
                                                            <svg class="w-4 h-4 text-blue-400 ml-1"
                                                                fill="currentColor" viewBox="0 0 24 24">
                                                                <path
                                                                    d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 15l-4-4 1.41-1.41L11 13.17l5.59-5.59L18 9l-7 7z" />
                                                            </svg>
                                                        </div>
                                                        <p id="modal-date" class="text-sm text-gray-400"></p>
                                                    </div>
                                                </div>
                                                <h2 id="modal-title" class="text-2xl font-bold mt-4"></h2>
                                                <p id="modal-description" class="text-gray-700 mb-2"></p>
                                                <p id="modal-category" class="text-lg text-black-500"></p>
                                                <div class="mt-4">
                                                    <h3 class="text-md font-semibold">Tags:</h3>
                                                    <div id="modal-tags" class="flex flex-wrap text-sm gap-2 mt-4">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>

                <div class="hidden rounded-lg dark:bg-gray-800" id="dashboard" role="tabpanel"
                    aria-labelledby="dashboard-tab">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($artists as $artist)
                            <div class="relative w-full h-[250px] rounded-lg overflow-hidden shadow-lg">
                                <!-- Background Image -->
                                <img src="{{ $artist->user->coverImage ? asset('storage/' . $artist->user->coverImage->path) : asset('images/default.image.jpg') }}"
                                    alt="Di Naluluma" class="w-full h-full object-cover">

                                <!-- Overlay -->
                                <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>

                                @if ($artist->available)
                                    <div
                                        class="absolute top-4 left-4 bg-green-500 text-white text-xs font-semibold px-2 py-1 rounded">
                                        Open
                                    </div>
                                @else
                                    <div
                                        class="absolute top-4 left-4 bg-red-500 text-white text-xs font-semibold px-2 py-1 rounded">
                                        Closed
                                    </div>
                                @endif

                                <!-- Text Content -->
                                <div class="absolute bottom-4 left-4 text-white">
                                    <!-- Artist Info -->
                                    <div class="flex items-center gap-2 mt-2">
                                        <img src="{{ asset('images/profile.default.jpg') }}" alt="Artist"
                                            class="w-8 h-8 rounded-full border border-white">
                                        <div>
                                            <p class="text-sm font-medium flex items-center">
                                                {{ $artist->user->name ?? 'John Doe' }}
                                                <svg class="w-4 h-4 text-blue-400 ml-1" fill="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path
                                                        d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 15l-4-4 1.41-1.41L11 13.17l5.59-5.59L18 9l-7 7z" />
                                                </svg>
                                            </p>
                                            <p class="text-sm text-gray-400">{{ '@' . $artist->username }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="hidden rounded-lg dark:bg-gray-800" id="settings" role="tabpanel"
                    aria-labelledby="settings-tab">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($services as $service)
                            @php
                                $thumbnail = $service->images->first()?->attachment;
                            @endphp
                            <a href="{{ route('service.show', $service) }}">
                                <div class="relative w-full h-[250px] rounded-lg overflow-hidden shadow-lg">
                                    <!-- Background Image -->
                                    <img src="{{ $thumbnail ? asset('storage/' . $thumbnail->path) : asset('images/default-image.jpg') }}"
                                        alt="Di Naluluma" class="w-full h-full object-cover">

                                    <!-- Overlay -->
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>

                                    <!-- Text Content -->
                                    <div class="absolute bottom-4 left-4 text-white">
                                        <h2 class="text-lg font-bold">{{ $service->category->name }}</h2>
                                        <p class="text-sm">|
                                            @foreach ($service->tags as $tag)
                                                {{ $tag->name }}@if (!$loop->last)
                                                    ,
                                                @endif
                                            @endforeach
                                        </p>

                                        <!-- Artist Info -->
                                        <div class="flex items-center gap-2 mt-2">
                                            <img src="{{ asset('images/profile.default.jpg') }}" alt="Artist"
                                                class="w-6 h-6 rounded-full border border-white">
                                            <p class="text-sm font-medium flex items-center">
                                                {{ $service->artist->user->name }}
                                                <svg class="w-4 h-4 text-blue-400 ml-1" fill="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path
                                                        d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 15l-4-4 1.41-1.41L11 13.17l5.59-5.59L18 9l-7 7z" />
                                                </svg>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
                <div class="hidden rounded-lg dark:bg-gray-800" id="contacts" role="tabpanel"
                    aria-labelledby="contacts-tab">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($artworks as $artwork)
                            @if ($artwork->status == 'sale')
                                @php
                                    $thumbnail = $artwork->images->first()?->attachment;
                                @endphp
                                <div class="relative w-full h-[250px] rounded-lg overflow-hidden shadow-lg">
                                    <a href="{{ route('artwork.show', $artwork) }}">
                                        <!-- Background Image -->
                                        <img src="{{ $thumbnail ? asset('storage/' . $thumbnail->path) : asset('images/default-image.jpg') }}"
                                            alt="Di Naluluma" class="w-full h-full object-cover">

                                        <!-- Overlay -->
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent">
                                        </div>

                                        <!-- Text Content -->
                                        <div class="absolute bottom-4 left-4 text-white">
                                            <h2 class="text-lg font-bold">{{ $artwork->title }}</h2>
                                            <p class="text-sm">| {{ $artwork->category->name }}</p>

                                            <!-- Artist Info -->
                                            <div class="flex items-center gap-2 mt-2">
                                                <img src="{{ asset('images/profile.default.jpg') }}" alt="Artist"
                                                    class="w-6 h-6 rounded-full border border-white">
                                                <p class="text-sm font-medium flex items-center">
                                                    {{ $artwork->artist->user->name }}
                                                    <svg class="w-4 h-4 text-blue-400 ml-1" fill="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path
                                                            d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 15l-4-4 1.41-1.41L11 13.17l5.59-5.59L18 9l-7 7z" />
                                                    </svg>
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Price -->
                                        <div class="absolute bottom-4 right-4 text-white text-lg font-semibold">
                                            <span
                                                class="text-xl">₱{{ number_format($artwork->price, 0, '.', ',') }}</span>
                                        </div>
                                    </a>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div
            class="flex flex-col items-center justify-center max-w-7xl mt-4 mx-auto bg-arange-200 sm:px-6 lg:px-8 pb-16 overflow-hidden shadow-sm sm:rounded-lg">
            <h1 class="text-6xl text-orange-500 font-bold">Hear from our users</h1>
            <div class="flex gap-6 mt-8 items-center justify-center">
                @foreach ($reviews as $review)
                    <div class="flex flex-col items-center justify-center bg-white w-80 h-96 rounded-lg p-8 shadow-lg">
                        <img src="{{ $review->order->client->user->profileImage ? asset('storage/' . $review->order->client->user->profileImage->attachment->path) : asset('images/profile.default.jpg') }}"
                            alt="User" class="w-16 h-16 rounded-full border-2 border-orange-500">
                        <p class="text-lg font-semibold mt-4">{{ $review->order->client->user->name }}</p>
                        <p class="text-sm text-gray-500">{{ ucfirst($review->order->client->user->role) }}</p>
                        <p class="text-md text-orange-500 text-center mt-4">"{{ $review->comment }}"</p>
                        <div class="flex gap-1 justify-center items-center mt-4">
                            @for ($i = 0; $i < $review->rating; $i++)
                                <svg class="w-5 h-5 text-yellow-400" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M13.849 4.22c-.684-1.626-3.014-1.626-3.698 0L8.397 8.387l-4.552.361c-1.775.14-2.495 2.331-1.142 3.477l3.468 2.937-1.06 4.392c-.413 1.713 1.472 3.067 2.992 2.149L12 19.35l3.897 2.354c1.52.918 3.405-.436 2.992-2.15l-1.06-4.39 3.468-2.938c1.353-1.146.633-3.336-1.142-3.477l-4.552-.36-1.754-4.17Z" />
                                </svg>
                            @endfor
                            @for ($i = $review->rating; $i < 5; $i++)
                                <svg class="w-5 h-5 text-gray-300" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M13.849 4.22c-.684-1.626-3.014-1.626-3.698 0L8.397 8.387l-4.552.361c-1.775.14-2.495 2.331-1.142 3.477l3.468 2.937-1.06 4.392c-.413 1.713 1.472 3.067 2.992 2.149L12 19.35l3.897 2.354c1.52.918 3.405-.436 2.992-2.15l-1.06-4.39 3.468-2.938c1.353-1.146.633-3.336-1.142-3.477l-4.552-.36-1.754-4.17Z" />
                                </svg>
                            @endfor
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="flex justify-between items-center max-w-6xl mx-auto sm:px-6 lg:px-8 pb-16">
            <img src="{{ asset('images/torch-full-high-resolution-logo-transparent.png') }}" alt="Torch Logo"
                class="w-32">
            <div class="flex items-center gap-4">
                <a href="">About</a>
                <a href="">Contact</a>
                <a href="">Terms of Service</a>
                <a href="">Privacy Policy</a>
                <a href="">Support</a>
            </div>
            <div class="flex items-center justify-evenly gap-2">
                <a href="">
                    <svg class="w-8 h-8 text-orange-500 dark:text-white" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                        viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M13.135 6H15V3h-1.865a4.147 4.147 0 0 0-4.142 4.142V9H7v3h2v9.938h3V12h2.021l.592-3H12V6.591A.6.6 0 0 1 12.592 6h.543Z"
                            clip-rule="evenodd" />
                    </svg>
                </a>
                <a href="">
                    <svg class="w-8 h-8 text-orange-500 dark:text-white" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                        viewBox="0 0 24 24">
                        <path fill="currentColor" fill-rule="evenodd"
                            d="M3 8a5 5 0 0 1 5-5h8a5 5 0 0 1 5 5v8a5 5 0 0 1-5 5H8a5 5 0 0 1-5-5V8Zm5-3a3 3 0 0 0-3 3v8a3 3 0 0 0 3 3h8a3 3 0 0 0 3-3V8a3 3 0 0 0-3-3H8Zm7.597 2.214a1 1 0 0 1 1-1h.01a1 1 0 1 1 0 2h-.01a1 1 0 0 1-1-1ZM12 9a3 3 0 1 0 0 6 3 3 0 0 0 0-6Zm-5 3a5 5 0 1 1 10 0 5 5 0 0 1-10 0Z"
                            clip-rule="evenodd" />
                    </svg>
                </a>
                <a href="">
                    <svg class="w-8 h-8 text-orange-500 dark:text-white" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                        viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M22 5.892a8.178 8.178 0 0 1-2.355.635 4.074 4.074 0 0 0 1.8-2.235 8.343 8.343 0 0 1-2.605.981A4.13 4.13 0 0 0 15.85 4a4.068 4.068 0 0 0-4.1 4.038c0 .31.035.618.105.919A11.705 11.705 0 0 1 3.4 4.734a4.006 4.006 0 0 0 1.268 5.392 4.165 4.165 0 0 1-1.859-.5v.05A4.057 4.057 0 0 0 6.1 13.635a4.192 4.192 0 0 1-1.856.07 4.108 4.108 0 0 0 3.831 2.807A8.36 8.36 0 0 1 2 18.184 11.732 11.732 0 0 0 8.291 20 11.502 11.502 0 0 0 19.964 8.5c0-.177 0-.349-.012-.523A8.143 8.143 0 0 0 22 5.892Z"
                            clip-rule="evenodd" />
                    </svg>
                </a>
                <a href="">
                    <svg class="w-8 h-8 text-orange-500 dark:text-white" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                        viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M12.51 8.796v1.697a3.738 3.738 0 0 1 3.288-1.684c3.455 0 4.202 2.16 4.202 4.97V19.5h-3.2v-5.072c0-1.21-.244-2.766-2.128-2.766-1.827 0-2.139 1.317-2.139 2.676V19.5h-3.19V8.796h3.168ZM7.2 6.106a1.61 1.61 0 0 1-.988 1.483 1.595 1.595 0 0 1-1.743-.348A1.607 1.607 0 0 1 5.6 4.5a1.601 1.601 0 0 1 1.6 1.606Z"
                            clip-rule="evenodd" />
                        <path d="M7.2 8.809H4V19.5h3.2V8.809Z" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
    <script>
        function openArtworkModal(button) {
            let artwork = JSON.parse(button.getAttribute('data-artwork'));

            // Populate modal content
            document.getElementById('modal-title').textContent = artwork.title;
            document.getElementById('modal-category').textContent = artwork.category;
            document.getElementById('modal-artist').textContent = artwork.artist;
            document.getElementById('modal-description').textContent = artwork.description;
            document.getElementById('modal-date').textContent = artwork.created_at;
            document.getElementById('modal-artist-image').src = artwork.artist_image;

            // Populate tags
            let tagsContainer = document.getElementById('modal-tags');
            tagsContainer.innerHTML = "";
            artwork.tags.forEach(tag => {
                let span = document.createElement('span');
                span.className = "bg-orange-200 text-gray-700 px-2 py-1 rounded-full";
                span.textContent = tag;
                tagsContainer.appendChild(span);
            });

            // Populate Carousel
            let carouselWrapper = document.getElementById('carousel-items');
            let indicators = document.getElementById('carousel-indicators');
            carouselWrapper.innerHTML = "";
            indicators.innerHTML = "";

            artwork.images.forEach((image, index) => {
                // Create slide
                let slide = document.createElement('div');
                slide.className =
                    `absolute inset-0 transition-opacity duration-700 ease-in-out ${index === 0 ? 'opacity-100' : 'opacity-0'}`;
                slide.setAttribute('data-carousel-item', index);
                slide.innerHTML = `<img src="${image}" class="w-full h-full object-cover rounded-lg">`;
                carouselWrapper.appendChild(slide);

                // Create indicator
                let indicator = document.createElement('button');
                indicator.type = "button";
                indicator.className = `w-3 h-3 rounded-full ${index === 0 ? 'bg-white' : 'bg-gray-500'}`;
                indicator.setAttribute('data-carousel-slide-to', index);
                indicator.onclick = () => showSlide(index);
                indicators.appendChild(indicator);
            });

            // Show modal
            document.getElementById('popup-modal').classList.remove('hidden');
            currentSlideIndex = 0;
            showSlide(currentSlideIndex);
        }

        function closeArtworkModal() {
            document.getElementById('popup-modal').classList.add('hidden');
        }

        // Carousel Functionality
        let currentSlideIndex = 0;

        function showSlide(index) {
            let slides = document.querySelectorAll('[data-carousel-item]');
            let indicators = document.querySelectorAll('[data-carousel-slide-to]');

            slides.forEach((slide, i) => {
                slide.classList.toggle('opacity-100', i === index);
                slide.classList.toggle('opacity-0', i !== index);
            });

            indicators.forEach((dot, i) => {
                dot.classList.toggle('bg-white', i === index);
                dot.classList.toggle('bg-gray-500', i !== index);
            });

            currentSlideIndex = index;
        }

        function nextSlide() {
            let totalSlides = document.querySelectorAll('[data-carousel-item]').length;
            showSlide((currentSlideIndex + 1) % totalSlides);
        }

        function prevSlide() {
            let totalSlides = document.querySelectorAll('[data-carousel-item]').length;
            showSlide((currentSlideIndex - 1 + totalSlides) % totalSlides);
        }
    </script>
</x-app-layout>
