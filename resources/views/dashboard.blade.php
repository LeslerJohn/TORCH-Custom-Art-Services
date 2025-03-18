<x-app-layout>
    <div class="bg-gradient-to-r from-white to-orange-100">
        <div class="w-full bg-gradient-to-r from-white to-orange-100 min-h-screen flex items-center">
            <div class="container mx-auto py-12 lg:py-5 px-4 sm:px-6 lg:px-8 ">
                <div class="flex flex-col md:flex-row justify-between items-center gap-8">
                    <!-- Text Section with AOS Animations -->
                    <div class="w-full md:w-1/2 text-center md:text-left ml-0 md:ml-8 lg:ml-12" data-aos="fade-right"
                        data-aos-duration="1000">
                        <h1 class="text-4xl sm:text-5xl lg:text-7xl font-bold leading-tight floating-element floating-h1" data-aos="fade-right" data-aos-delay="200">
                            Discover the Timeless World of
                            <span class="text-orange-500">Traditional Art.</span>
                        </h1>
                        <p class="text-lg sm:text-xl text-gray-700 font-bold mt-6 floating-element floating-p" data-aos="fade-left" data-aos-delay="400">
                            Explore traditional masterpieces by passionate artists, ready to transform your ideas into reality.
                        </p>
                        <style>
                            /* Text Floating Animation */
                            @keyframes float {
                                0% {
                                    transform: translate(var(--translateX-start), var(--translateY-start));
                                }

                                50% {
                                    transform: translate(var(--translateX-mid), var(--translateY-mid));
                                }

                                100% {
                                    transform: translate(var(--translateX-end), var(--translateY-end));
                                }
                            }

                            /* Common Floating Styles */
                            .floating-element {
                                animation: float var(--animation-duration) ease-in-out infinite;
                                will-change: transform;
                                /* Optimize for performance */
                            }

                            /* Different Timings for h1 and p */
                            .floating-h1 {
                                --animation-duration: 8s;
                                /* Longer duration for h1 */
                                --animation-delay: 0s;
                            }

                            .floating-p {
                                --animation-duration: 6s;
                                /* Shorter duration for p */
                                --animation-delay: 2s;
                                /* Delay to make it out of sync with h1 */
                                animation-delay: var(--animation-delay);
                            }
                        </style>
                        <div class="mt-8" data-aos="fade-up" data-aos-once="false" data-aos-delay="600">
                            <a href="{{ route('client.artwork') }}"
                                class="cta-button inline-block bg-orange-500 text-white pl-3 sm:pl-3 py-3 rounded-full text-lg font-semibold hover:bg-orange-600 transition">
                                Get Started
                                <span class="arrow"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right">
                                        <path d="M5 12h14" />
                                        <path d="m12 5 7 7-7 7" />
                                    </svg></span>
                            </a>
                        </div>
                        <style>
                            /* Button Floating Animation in Multiple Directions */
                            @keyframes float {
                                0% {
                                    transform: translateY(0) translateX(0);
                                }

                                25% {
                                    transform: translateY(-10px) translateX(-10px);
                                }

                                50% {
                                    transform: translateY(10px) translateX(10px);
                                }

                                75% {
                                    transform: translateY(-10px) translateX(10px);
                                }

                                100% {
                                    transform: translateY(0) translateX(0);
                                }
                            }

                            .cta-button {
                                position: relative;
                                display: inline-flex;
                                align-items: center;
                                animation: float 4s ease-in-out infinite;
                                transition: padding-right 0.3s ease;
                                /* Expand container smoothly */
                            }

                            /* Arrow Styles */
                            .cta-button .arrow {
                                opacity: 0;
                                margin-left: 0;
                                /* Start with no margin */
                                transition: opacity 0.3s ease, margin-left 0.3s ease;
                            }

                            /* Hover Effect */
                            .cta-button:hover .arrow {
                                opacity: 1;
                                margin-left: 10px;
                                /* Add space for the arrow */
                            }

                            /* Expand container on hover */
                            .cta-button:hover {
                                padding-right: 20px;
                                /* Adjust this value to control expansion */
                            }
                        </style>
                    </div>

                    <!-- Image Section with Floating Animation -->
                    <div class="w-full md:w-1/2 flex justify-center md:justify-end mt-2 md:mt-0" data-aos="fade-up"
                        data-aos-delay="800">
                        <img src="{{ asset('images/Hero.png') }}" alt="Hero Picture"
                            class="w-full max-w-[500px] lg:max-w-[800px] xl:max-w-[1500px] h-auto object-cover rounded-lg animate-float">
                    </div>
                    <style>
                        /* Image Floating Animation */
                        @keyframes float {

                            0%,
                            100% {
                                transform: translateY(0);
                            }

                            50% {
                                transform: translateY(-20px);
                                /* Adjust the floating height */
                            }
                        }

                        .animate-float {
                            animation: float 3s ease-in-out infinite;
                            /* Adjust the duration and timing function */
                        }
                    </style>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 pb-16 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="mb-4 flex justify-between items-center border-b border-gray-200 dark:border-gray-700"
                data-aos="fade-right" data-aos-delay="200">
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
                    <a href="{{ route('client.artwork') }}"
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
            <div id="default-tab-content" class="px-4 sm:px-6 lg:px-8" data-aos="fade-up" data-aos-delay="500">
                <!-- Artwork Grid -->
                <div class="hidden rounded-lg dark:bg-gray-800" id="profile" role="tabpanel" aria-labelledby="showcase-tab">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($artworks as $artwork)
                        @if ($artwork->is_showcase)
                        <button type="button" onclick="openArtworkModal(this)"
                            data-artwork="{{ json_encode([
                        'title' => $artwork->title,
                        'category' => $artwork->category->name,
                        'artist' => $artwork->artist->username,
                        'artist_image' => $artwork->artist->user->profileImage
                            ? asset('storage/' . $artwork->artist->user->profileImage->path)
                            : asset('images/profile.default.jpg'),
                        'description' => $artwork->description,
                        'created_at' => $artwork->created_at->format('F j, Y'),
                        'tags' => $artwork->tags->pluck('name'),
                        'images' => $artwork->images->map(fn($img) => asset('storage/' . $img->attachment->path)),
                    ]) }}">
                            @php
                            $thumbnail = $artwork->images->first()?->attachment;
                            @endphp

                            <div class="relative w-full h-[250px] rounded-lg overflow-hidden cursor-pointer" data-aos="fade-up" data-aos-delay="500">
                                <!-- Background Image -->
                                <img src="{{ $thumbnail ? asset('storage/' . $thumbnail->path) : asset('images/default-image.jpg') }}"
                                    alt="{{ $artwork->title }}" class="w-full h-full object-cover">

                                <!-- Overlay -->
                                <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>

                                <!-- Text Content -->
                                <div class="absolute bottom-4 left-4 text-white">
                                    <h2 class="text-lg text-start font-bold">{{ $artwork->title }}</h2>
                                    <p class="text-sm text-start">| {{ $artwork->category->name }}</p>

                                    <!-- Artist Info -->
                                    <div class="flex items-center gap-2 mt-2">
                                        <img src="{{ $artwork->artist->user->profileImage ? asset('storage/' . $artwork->artist->user->profileImage->path) : asset('images/profile.default.jpg') }}"
                                            alt="Artist"
                                            class="w-6 h-6 rounded-full object-cover border border-white">
                                        <p class="text-sm font-medium flex items-center">
                                            {{ $artwork->artist->username }}
                                            <svg class="w-4 h-4 text-blue-400 ml-1" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 15l-4-4 1.41-1.41L11 13.17l5.59-5.59L18 9l-7 7z" />
                                            </svg>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </button>
                        @endif
                        @endforeach
                    </div>
                </div>



                <div class="hidden rounded-lg dark:bg-gray-800" id="dashboard" role="tabpanel"
                    aria-labelledby="dashboard-tab">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($artists as $artist)
                        <div class="relative w-full h-[250px] rounded-lg overflow-hidden shadow-lg">
                            <a href="{{ route('artist.profile', $artist) }}">
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
                                        <img src="{{ $artist->user->profileImage ? asset('storage/' . $artist->user->profileImage->path) : asset('images/profile.default.jpg') }}"
                                            alt="Artist"
                                            class="w-8 h-8 rounded-full object-cover border border-white">
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
                            </a>
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
                                        <img src="{{ $service->artist->user->profileImage ? asset('storage/' . $service->artist->user->profileImage->path) : asset('images/profile.default.jpg') }}"
                                            alt="Artist" class="w-6 h-6 rounded-full object-cover border border-white">
                                        <p class="text-sm font-medium flex items-center">
                                            {{ $service->artist->username }}
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
                        $discountedPrice = $artwork->price;
                        if ($artwork->discount && $artwork->discount->status == 'active') {
                        if ($artwork->discount->value_type == 'percentage') {
                        $discountedPrice -= ($artwork->price * $artwork->discount->value) / 100;
                        } elseif ($artwork->discount->value_type == 'fixed') {
                        $discountedPrice -= $artwork->discount->value;
                        }
                        }
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
                                        <img src="{{ $artwork->artist->user->profileImage ? asset('storage/' . $artwork->artist->user->profileImage->path) : asset('images/profile.default.jpg') }}"
                                            alt="Artist" class="w-6 h-6 rounded-full border border-white">
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
                                    @if ($artwork->discount && $artwork->discount->status == 'active')
                                    <span
                                        class="line-through text-red-500">₱{{ number_format($artwork->price, 0, '.', ',') }}</span>
                                    <span
                                        class="text-xl">₱{{ number_format($discountedPrice, 0, '.', ',') }}</span>
                                    @else
                                    <span
                                        class="text-xl">₱{{ number_format($artwork->price, 0, '.', ',') }}</span>
                                    @endif
                                </div>
                            </a>
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 pb-16 mt-12 overflow-hidden px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-bold text-center sm:text-left" data-aos="fade-right" data-aos-delay="700">Your
                Trusted Platform for Custom Art Services</h1>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-16 mt-12">
                <div>
                    <h3 class="text-xl font-bold mb-2 text-gray-600" data-aos="fade-right" data-aos-delay="800">
                        Explore Unique Art Creations</h3>
                    <p data-aos="fade-up-right" data-aos-delay="900">Our mission is to provide a seamless experience
                        for art lovers,
                        ensuring that every piece reflects your vision and passion for creativity,
                        while supporting local artists in our vibrant community.</p>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-2 text-gray-600" data-aos="fade-left" data-aos-delay="800">
                        Commission Your Dream Artwork</h3>
                    <p data-aos="fade-up-left" data-aos-delay="900">At Torch, we connect you with talented artists in
                        Zamboanga for custom art
                        commissions and offer a selection of beautiful premade artworks to enhance your space.</p>
                </div>
            </div>
            <img src="{{ asset('images/default.image.jpg') }}" alt=""
                class="w-full h-64 sm:h-96 object-cover rounded-lg mt-12" data-aos="fade-up" data-aos-delay="900">
        </div>

        <div
            class="flex flex-col items-center justify-center max-w-7xl mt-4 mx-auto bg-arange-200 sm:px-6 lg:px-8 pb-16 overflow-hidden">
            <h1 class="text-4xl text-orange-500 font-bold" data-aos="fade-right" data-aos-delay="300">Hear from our
                users</h1>
            <p class="mt-2 font-medium text-gray-400" data-aos="fade-left" data-aos-delay="400">Artwork Reviews</p>
            <div class="flex flex-wrap gap-6 mt-8 items-center justify-center">
                @foreach ($reviews->take(3) as $review)
                <div class="flex flex-col items-center justify-center bg-white w-full sm:w-80 h-96 sm:h-46 rounded-lg p-8 shadow-lg max-w-xs"
                    data-aos="fade-up" data-aos-delay="800">
                    @php
                    $client = $review->order->client ?? $review->commission->request->client;
                    @endphp
                    <img src="{{ $client->user->profileImage ? asset('storage/' . $client->user->profileImage->path) : asset('images/profile.default.jpg') }}"
                        alt="User" class="w-16 h-16 rounded-full object-cover border-2 border-orange-500">
                    <p class="text-lg font-semibold mt-4">{{ $client->user->name }}</p>
                    <p class="text-sm text-gray-500">{{ ucfirst($client->user->role) }}</p>
                    <p class="text-md text-orange-500 text-center mt-4">"{{ $review->comment }}"</p>
                    <div class="flex gap-1 justify-center items-center mt-4">
                        @for ($i = 0; $i < $review->rating; $i++)
                            <svg class="w-4 h-4 text-yellow-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M13.849 4.22c-.684-1.626-3.014-1.626-3.698 0L8.397 8.387l-4.552.361c-1.775.14-2.495 2.331-1.142 3.477l3.468 2.937-1.06 4.392c-.413 1.713 1.472 3.067 2.992 2.149L12 19.35l3.897 2.354c1.52.918 3.405-.436 2.992-2.15l-1.06-4.39 3.468-2.938c1.353-1.146.633-3.336-1.142-3.477l-4.552-.36-1.754-4.17Z" />
                            </svg>
                            @endfor
                            @for ($i = $review->rating; $i < 5; $i++)
                                <svg class="w-4 h-4 text-gray-300" aria-hidden="true"
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
        <!-- Artwork Modal -->
        <div id="popup-modal" class="hidden fixed inset-0 z-50 flex justify-center items-center bg-black/50">
            <div class="bg-white rounded-lg shadow-lg p-4 md:p-8 w-full max-w-4xl max-h-[90vh] overflow-y-auto relative mx-4">
                <!-- Close Button -->
                <button class="absolute top-2 right-2 md:top-4 md:right-4 text-gray-600 hover:text-gray-900" onclick="closeArtworkModal()">
                    <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>

                <!-- Modal Content -->
                <div class="flex flex-col md:flex-row gap-6">
                    <!-- Carousel Section -->
                    <div class="w-full md:w-1/2">
                        <div id="carousel-container" class="relative">
                            <!-- Carousel Images -->
                            <div id="carousel-items" class="relative h-64 md:h-96 overflow-hidden rounded-lg">
                                <!-- Images will be dynamically added here -->
                            </div>

                            <!-- Carousel Controls -->
                            <button type="button" class="absolute top-1/2 left-2 transform -translate-y-1/2 bg-white/50 px-3 py-2 rounded-full hover:bg-white/80 transition" onclick="prevSlide()">
                                <svg class="w-4 h-4 text-black" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4" />
                                </svg>
                            </button>
                            <button type="button" class="absolute top-1/2 right-2 transform -translate-y-1/2 bg-white/50 px-3 py-2 rounded-full hover:bg-white/80 transition" onclick="nextSlide()">
                                <svg class="w-4 h-4 text-black" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                                </svg>
                            </button>

                            <!-- Carousel Indicators -->
                            <div id="carousel-indicators" class="absolute bottom-3 left-1/2 transform -translate-x-1/2 flex gap-2">
                                <!-- Indicators will be dynamically added here -->
                            </div>
                        </div>
                    </div>

                    <!-- Artwork Details -->
                    <div class="w-full md:w-1/2">
                        <!-- Artist Info -->
                        <div class="flex items-center gap-3">
                            <img id="modal-artist-image" src="" alt="Artist"
                                class="w-10 h-10 rounded-full object-cover border border-gray-200">
                            <div>
                                <p id="modal-artist" class="text-lg font-semibold"></p>
                                <p id="modal-date" class="text-sm text-gray-500"></p>
                            </div>
                        </div>

                        <!-- Title and Description -->
                        <h2 id="modal-title" class="text-2xl font-bold mt-4"></h2>
                        <p id="modal-description" class="text-gray-700 mt-2"></p>

                        <!-- Category -->
                        <p id="modal-category" class="text-lg text-gray-800 mt-4"></p>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-gray-50 py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div>
                @include('layouts.footer')
            </div>
            <script>
                let currentSlide = 0;

                function openArtworkModal(button) {
                    const artwork = JSON.parse(button.getAttribute('data-artwork'));
                    const modal = document.getElementById('popup-modal');
                    const carouselItems = document.getElementById('carousel-items');
                    const carouselIndicators = document.getElementById('carousel-indicators');

                    // Set artwork details
                    document.getElementById('modal-title').textContent = artwork.title;
                    document.getElementById('modal-category').textContent = `Category: ${artwork.category}`;
                    document.getElementById('modal-artist').textContent = artwork.artist;
                    document.getElementById('modal-artist-image').src = artwork.artist_image;
                    document.getElementById('modal-date').textContent = `Created: ${artwork.created_at}`;
                    document.getElementById('modal-description').textContent = artwork.description;

                    // Clear existing carousel items and indicators
                    carouselItems.innerHTML = '';
                    carouselIndicators.innerHTML = '';

                    // Add images to carousel
                    artwork.images.forEach((image, index) => {
                        const img = document.createElement('img');
                        img.src = image;
                        img.alt = artwork.title;
                        img.classList.add('w-full', 'h-full', 'object-cover', index === 0 ? 'block' : 'hidden');
                        carouselItems.appendChild(img);

                        // Add indicators
                        const indicator = document.createElement('button');
                        indicator.classList.add('w-2', 'h-2', 'rounded-full', 'bg-white/50', 'hover:bg-white/80', 'transition');
                        indicator.addEventListener('click', () => showSlide(index));
                        carouselIndicators.appendChild(indicator);
                    });

                    // Show modal
                    modal.classList.remove('hidden');
                    document.body.style.overflow = 'hidden'; // Prevent background scrolling
                }

                function closeArtworkModal() {
                    document.getElementById('popup-modal').classList.add('hidden');
                    document.body.style.overflow = 'auto'; // Re-enable background scrolling
                }

                function showSlide(index) {
                    const carouselItems = document.getElementById('carousel-items').children;
                    const indicators = document.getElementById('carousel-indicators').children;

                    // Hide all slides
                    for (let i = 0; i < carouselItems.length; i++) {
                        carouselItems[i].classList.add('hidden');
                        indicators[i].classList.remove('bg-white/80', 'bg-white/50');
                        indicators[i].classList.add('bg-white/50');
                    }

                    // Show selected slide
                    carouselItems[index].classList.remove('hidden');
                    indicators[index].classList.remove('bg-white/50');
                    indicators[index].classList.add('bg-white/80');

                    currentSlide = index;
                }

                function prevSlide() {
                    const totalSlides = document.getElementById('carousel-items').children.length;
                    showSlide((currentSlide - 1 + totalSlides) % totalSlides);
                }

                function nextSlide() {
                    const totalSlides = document.getElementById('carousel-items').children.length;
                    showSlide((currentSlide + 1) % totalSlides);
                }

                // Function to generate random values for floating animation
                function randomizeFloating(element) {
                    const maxOffset = 20; // Maximum translation in pixels
                    const translateXStart = (Math.random() * maxOffset * 2) - maxOffset; // Random value between -maxOffset and maxOffset
                    const translateYStart = (Math.random() * maxOffset * 2) - maxOffset;
                    const translateXMid = (Math.random() * maxOffset * 2) - maxOffset;
                    const translateYMid = (Math.random() * maxOffset * 2) - maxOffset;
                    const translateXEnd = (Math.random() * maxOffset * 2) - maxOffset;
                    const translateYEnd = (Math.random() * maxOffset * 2) - maxOffset;

                    // Apply random values to CSS variables
                    element.style.setProperty('--translateX-start', `${translateXStart}px`);
                    element.style.setProperty('--translateY-start', `${translateYStart}px`);
                    element.style.setProperty('--translateX-mid', `${translateXMid}px`);
                    element.style.setProperty('--translateY-mid', `${translateYMid}px`);
                    element.style.setProperty('--translateX-end', `${translateXEnd}px`);
                    element.style.setProperty('--translateY-end', `${translateYEnd}px`);
                }

                // Apply random floating to all elements with the class 'floating-element'
                document.querySelectorAll('.floating-element').forEach(element => {
                    randomizeFloating(element);
                });
            </script>
</x-app-layout>