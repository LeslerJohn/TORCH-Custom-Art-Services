<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">


        <!-- Main Content Card -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="grid grid-cols-1 md:grid-cols-2">
                <!-- Left Column: Image Gallery -->
                <div class="h-full">
                    <div id="service-carousel" class="relative h-full" data-carousel="slide">
                        <!-- Carousel wrapper -->
                        <div class="relative h-64 md:h-full overflow-hidden">
                            @foreach ($service->images as $index => $image)
                            <div class="{{ $index === 0 ? '' : 'hidden' }} duration-700 ease-in-out absolute inset-0" data-carousel-item="{{ $index === 0 ? 'active' : '' }}">
                                <img src="{{ $image->attachment ? asset('storage/' . $image->attachment->path) : asset('images/default.image.jpg') }}"
                                    class="object-cover w-full h-full" alt="Service Image">
                            </div>
                            @endforeach
                        </div>

                        <!-- Carousel indicators -->
                        <div class="absolute z-30 flex -translate-x-1/2 space-x-3 bottom-5 left-1/2">
                            @foreach ($service->images as $index => $image)
                            <button type="button" class="w-3 h-3 rounded-full bg-white"
                                aria-current="{{ $index === 0 ? 'true' : 'false' }}"
                                aria-label="Slide {{ $index + 1 }}"
                                data-carousel-slide-to="{{ $index }}"></button>
                            @endforeach
                        </div>

                        <!-- Carousel controls -->
                        <button type="button" class="absolute top-1/2 -translate-y-1/2 left-4 z-30 flex items-center justify-center w-10 h-10 rounded-full bg-white/80 shadow-md hover:bg-white focus:outline-none" data-carousel-prev>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-left">
                                <path d="m15 18-6-6 6-6" />
                            </svg>
                        </button>
                        <button type="button" class="absolute top-1/2 -translate-y-1/2 right-4 z-30 flex items-center justify-center w-10 h-10 rounded-full bg-white/80 shadow-md hover:bg-white focus:outline-none" data-carousel-next>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right">
                                <path d="m9 18 6-6-6-6" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Right Column: Service Details -->
                <div class="p-6 md:p-8 flex flex-col h-full">

                    <!-- Header Section -->
                    <div class="mb-6 border-b border-gray-100 pb-6">
                        <!-- Back Button -->
                        <div class="flex justify-end mb-2">
                            <button onclick="window.history.back()" class="flex items-center justify-center w-12 h-12 rounded-full bg-white shadow-lg hover:bg-gray-100 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-move-left">
                                    <path d="M6 8L2 12L6 16" />
                                    <path d="M2 12H22" />
                                </svg>
                            </button>
                        </div>
                        <!-- Service Category -->
                        <div class="flex items-center mb-3">
                            <span class="flex items-center justify-center w-10 h-10 rounded-full bg-blue-100 text-blue-600 mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-palette">
                                    <circle cx="13.5" cy="6.5" r=".5" fill="currentColor" />
                                    <circle cx="17.5" cy="10.5" r=".5" fill="currentColor" />
                                    <circle cx="8.5" cy="7.5" r=".5" fill="currentColor" />
                                    <circle cx="6.5" cy="12.5" r=".5" fill="currentColor" />
                                    <path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.926 0 1.648-.746 1.648-1.688 0-.437-.18-.835-.437-1.125-.29-.289-.438-.652-.438-1.125a1.64 1.64 0 0 1 1.668-1.668h1.996c3.051 0 5.555-2.503 5.555-5.554C21.965 6.012 17.461 2 12 2z" />
                                </svg>
                            </span>
                            <h1 class="text-2xl md:text-3xl font-bold">{{ $service->category->name }}</h1>
                        </div>

                        <!-- Pricing -->
                        <div class="flex items-center mb-3 ml-1">
                            <i class="fas fa-tag text-red-500 mr-3 w-5 text-center"></i>
                            <p class="text-xl md:text-2xl font-semibold text-red-600">
                                ₱{{ number_format($service->price_rate, 0, '.', ',') }} <span class="text-gray-600 text-lg font-normal">per square inch</span>
                            </p>
                        </div>

                        <!-- Timeframe -->
                        <div class="flex items-center mb-3 ml-1">
                            <i class="far fa-clock text-gray-600 mr-3 w-5 text-center"></i>
                            <p class="text-gray-600">
                                Completion time: <span class="font-medium">{{ $service->normal_timeframe }} - {{ $service->normal_timeframe + 5 }} days</span>
                            </p>
                        </div>

                        <!-- Tags -->
                        <div class="flex flex-wrap gap-2 mt-4">
                            @foreach ($service->tags as $tag)
                            <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm flex items-center">
                                <i class="fas fa-tag mr-1 text-xs"></i>
                                {{ $tag->name }}
                            </span>
                            @endforeach
                        </div>
                    </div>

                    <!-- Artist Info -->
                    <div class="flex flex-col md:flex-row items-center p-4 bg-gray-50 rounded-xl mb-5">
                        <img src="{{ $service->artist->user->profileImage ? asset('storage/' . $service->artist->user->profileImage->path) : asset('images/profile.default.jpg') }}"
                            alt="Artist" class="w-12 h-12 rounded-full object-cover border-2 border-white shadow-sm">
                        <div class="ml-3 text-center md:text-left">
                            <div class="flex items-center justify-center md:justify-start">
                                <p class="font-medium">{{ $service->artist->user->name ?? 'John Doe' }}</p>
                                <i class="fas fa-check-circle text-blue-500 ml-1 text-sm"></i>
                            </div>
                            <p class="text-sm text-gray-500">{{ '@' . $service->artist->username }}</p>
                        </div>
                        <div class="mt-3 md:mt-0 md:ml-auto text-center md:text-right">
                            <div class="flex flex-col items-center md:items-end">
                                <div class="flex items-center mb-1">
                                    <i class="fas fa-envelope text-gray-400 mr-1 text-sm"></i>
                                    <span class="text-sm text-gray-600">{{ $service->artist->user->email ?? 'test@email.com' }}</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-phone text-gray-400 mr-1 text-sm"></i>
                                    <span class="text-sm text-gray-600">{{ $service->artist->user->phone_number }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Rush Order Box -->
                    <div class="p-4 bg-red-50 border border-red-100 rounded-xl mb-5">
                        <div class="flex items-center mb-2">
                            <i class="fas fa-bolt text-red-600 mr-2"></i>
                            <h2 class="text-lg font-semibold">Rush Order Available</h2>
                        </div>
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-lg text-red-600 font-medium">
                                    ₱{{ number_format($service->rush_price_rate, 0, '.', ',') }} <span class="text-sm font-normal">per sq. inch</span>
                                </p>
                            </div>
                            <div>
                                <p class="text-gray-600 flex items-center">
                                    <i class="far fa-calendar-alt mr-1"></i>
                                    <span>{{ $service->rush_timeframe }} - {{ $service->normal_timeframe - 1 }} days</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Notice -->
                    <div class="p-4 bg-blue-50 border border-blue-100 rounded-xl mb-5">
                        <div class="flex">
                            <i class="fas fa-info-circle text-blue-600 mt-1 mr-3 text-lg"></i>
                            <p class="text-sm text-gray-700">
                                Thanks for considering me for your commission! Please only start a request if you find the
                                service details and TORCH's Terms of Service acceptable.
                            </p>
                        </div>
                    </div>

                    <!-- Service Details Tabs -->
                    <div class="flex-grow overflow-auto" style="max-height: 300px;">
                        <div id="accordion-details" x-data="{ active: 'includes' }">
                            <!-- Includes -->
                            <div class="border border-gray-200 rounded-xl mb-2 overflow-hidden">
                                <button @click="active = active === 'includes' ? null : 'includes'" type="button" class="flex items-center justify-between w-full p-4 font-medium text-left text-gray-900 bg-gray-100 hover:bg-gray-50">
                                    <div class="flex items-center">
                                        <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-green-100 text-green-600 mr-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-check">
                                                <circle cx="12" cy="12" r="10" />
                                                <path d="m9 12 2 2 4-4" />
                                            </svg>
                                        </span>
                                        <span class="font-medium">Includes</span>
                                    </div>
                                    <i class="fas" :class="active === 'includes' ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                                </button>
                                <div x-show="active === 'includes'" class="p-4 bg-white">
                                    <ul class="space-y-3">
                                        <li class="flex items-start">
                                            <i class="fas fa-check text-green-500 mt-1 mr-3"></i>
                                            <span>Handcrafted illustrations using traditional mediums.</span>
                                        </li>
                                        <li class="flex items-start">
                                            <i class="fas fa-check text-green-500 mt-1 mr-3"></i>
                                            <span>Ideal for detailed compositions, including intricate backgrounds and scenes.</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Pricing Framework -->
                            <div class="border border-gray-200 rounded-xl mb-2 overflow-hidden">
                                <button @click="active = active === 'pricing' ? null : 'pricing'" type="button" class="flex items-center justify-between w-full p-4 font-medium text-left text-gray-900 bg-gray-100 hover:bg-gray-50">
                                    <div class="flex items-center">
                                        <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-yellow-100 text-yellow-600 mr-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-coins">
                                                <circle cx="8" cy="8" r="6" />
                                                <path d="M18.09 10.37A6 6 0 1 1 10.34 18" />
                                                <path d="M7 6h1v4" />
                                                <path d="m16.71 13.88.7.71-2.82 2.82" />
                                            </svg>
                                        </span>
                                        <span class="font-medium">Pricing Framework</span>
                                    </div>
                                    <i class="fas" :class="active === 'pricing' ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                                </button>
                                <div x-show="active === 'pricing'" class="p-4 bg-white">
                                    <ul class="space-y-3">
                                        <li class="flex items-start">
                                            <i class="fas fa-calculator text-gray-600 mt-1 mr-3"></i>
                                            <span>Pricing is based on the artist's base price per square inch.</span>
                                        </li>
                                        <li class="flex items-start">
                                            <i class="fas fa-equals text-gray-600 mt-1 mr-3"></i>
                                            <span>The total cost is calculated as: <strong>Length × Width × Base Price</strong></span>
                                        </li>
                                        <li class="flex items-start">
                                            <i class="fas fa-bolt text-gray-600 mt-1 mr-3"></i>
                                            <span>Rush orders will have an additional fee.</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Details -->
                            <div class="border border-gray-200 rounded-xl mb-2 overflow-hidden">
                                <button @click="active = active === 'details' ? null : 'details'" type="button" class="flex items-center justify-between w-full p-4 font-medium text-left text-gray-900 bg-gray-100 hover:bg-gray-50">
                                    <div class="flex items-center">
                                        <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-blue-100 text-blue-600 mr-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-info">
                                                <circle cx="12" cy="12" r="10" />
                                                <path d="M12 16v-4" />
                                                <path d="M12 8h.01" />
                                            </svg>
                                        </span>
                                        <span class="font-medium">Details</span>
                                    </div>
                                    <i class="fas" :class="active === 'details' ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                                </button>
                                <div x-show="active === 'details'" class="p-4 bg-white">
                                    <ul class="space-y-3">
                                        <li class="flex items-start">
                                            <i class="fas fa-ruler-combined text-gray-600 mt-1 mr-3"></i>
                                            <span>Sizes vary based on composition; custom dimensions available upon request.</span>
                                        </li>
                                        <li class="flex items-start">
                                            <i class="fas fa-paint-brush text-gray-600 mt-1 mr-3"></i>
                                            <span>Full scenes included, incorporating depth and artistic storytelling.</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Important -->
                            <div class="border border-gray-200 rounded-xl overflow-hidden">
                                <button @click="active = active === 'important' ? null : 'important'" type="button" class="flex items-center justify-between w-full p-4 font-medium text-left text-gray-900 bg-gray-100 hover:bg-gray-50">
                                    <div class="flex items-center">
                                        <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-amber-100 text-amber-600 mr-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-triangle-alert">
                                                <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3" />
                                                <path d="M12 9v4" />
                                                <path d="M12 17h.01" />
                                            </svg>
                                        </span>
                                        <span class="font-medium">Important</span>
                                    </div>
                                    <i class="fas" :class="active === 'important' ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                                </button>
                                <div x-show="active === 'important'" class="p-4 bg-white">
                                    <ul class="space-y-3">
                                        <li class="flex items-start">
                                            <i class="fas fa-exclamation-circle text-amber-500 mt-1 mr-3"></i>
                                            <span>Base prices may vary depending on detail level, materials, and artist's experience.</span>
                                        </li>
                                        <li class="flex items-start">
                                            <i class="fas fa-ban text-red-500 mt-1 mr-3"></i>
                                            <span>No cancellation once the commission has started.</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Request Button Section -->
                    @auth
                    @if (auth()->user()->id !== $service->artist->user->id)
                    @if ($service->artist->available)
                    <div class="mt-6 pt-5 border-t border-gray-200">
                        <div class="flex items-center mb-4">
                            <input id="terms" type="checkbox" class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <label for="terms" class="ml-2 text-sm text-gray-700">
                                I agree to the <a href="{{ route('terms') }}" class="text-blue-600 hover:underline">Terms of Service</a>
                            </label>
                        </div>
                        <button id="start-request-btn"
                            data-modal-target="authentication-modal"
                            data-modal-toggle="authentication-modal"
                            class="w-full py-4 px-6 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-xl shadow-md transition-colors flex items-center justify-center gap-3 disabled:opacity-50 disabled:cursor-not-allowed"
                            type="button"
                            disabled>
                            <i class="fas fa-handshake text-lg"></i>
                            <span class="text-lg">Start your request</span>
                        </button>
                    </div>
                    @else
                    <div class="mt-6 pt-5 border-t border-gray-200">
                        <div class="p-4 bg-red-50 border border-red-100 rounded-xl text-center">
                            <i class="fas fa-exclamation-circle text-red-500 mr-2"></i>
                            <span class="text-red-500 font-medium">The artist is currently not available for commissions.</span>
                        </div>
                    </div>
                    @endif
                    @endif
                    @endauth
                </div>
                <!-- Main modal -->
                <div id="authentication-modal" tabindex="-1" aria-hidden="true"
                    class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 overflow-y-auto overflow-x-hidden bg-black bg-opacity-50">
                    <div class="relative w-full max-w-5xl max-h-full">
                        <!-- Modal content -->
                        <div class="relative bg-white rounded-xl shadow-lg dark:bg-gray-800 overflow-hidden">
                            <!-- Modal header -->
                            <div class="flex items-center justify-between p-6 border-b dark:border-gray-700">
                                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                                    Checkout
                                </h3>
                                <button type="button"
                                    class="text-gray-400 bg-transparent hover:bg-gray-100 hover:text-gray-900 rounded-lg p-2 inline-flex items-center justify-center dark:hover:bg-gray-700 dark:hover:text-white transition-colors"
                                    data-modal-hide="authentication-modal">
                                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                    </svg>
                                    <span class="sr-only">Close modal</span>
                                </button>
                            </div>

                            <!-- Modal body -->
                            <div class="flex flex-col md:flex-row p-6 gap-8">
                                <!-- Left column: Artist info and service details -->
                                <div class="w-full md:w-2/5 space-y-6">
                                    <!-- Artist card -->
                                    <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-6 shadow-sm">
                                        <div class="flex items-center gap-4">
                                            <img src="{{ $service->artist->user->profileImage ? asset('storage/' . $service->artist->user->profileImage->path) : asset('images/profile.default.jpg') }}"
                                                alt="Artist"
                                                class="w-16 h-16 rounded-full object-cover border-2 border-white shadow">
                                            <div>
                                                <p class="text-lg font-semibold flex items-center">
                                                    {{ $service->artist->user->name ?? 'John Doe' }}
                                                    <svg class="w-5 h-5 text-blue-500 ml-1" fill="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path
                                                            d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 15l-4-4 1.41-1.41L11 13.17l5.59-5.59L18 9l-7 7z" />
                                                    </svg>
                                                </p>
                                                <p class="text-gray-500 dark:text-gray-300">{{ '@' . $service->artist->username }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Tags and categories -->
                                    <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-6 shadow-sm">
                                        <h4 class="font-medium mb-3 text-gray-700 dark:text-gray-200">Service Details</h4>
                                        <div class="flex flex-wrap gap-2 mb-4">
                                            <span class="bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 font-medium px-3 py-1 rounded-lg">{{ ucfirst($service->category->name) }}</span>
                                            @foreach ($service->tags as $tag)
                                            <span class="bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 font-medium px-3 py-1 rounded-lg">{{ $tag->name }}</span>
                                            @endforeach
                                        </div>
                                    </div>

                                    <!-- Pricing options -->
                                    <div class="space-y-4">
                                        <!-- Standard pricing -->
                                        <div class="bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl p-5 shadow-sm transition-all hover:shadow-md">
                                            <div class="flex justify-between items-center mb-2">
                                                <h4 class="font-semibold text-gray-900 dark:text-white">Standard Price</h4>
                                                <span class="text-sm px-2.5 py-1 bg-gray-100 dark:bg-gray-600 rounded-lg text-gray-700 dark:text-gray-200">Regular</span>
                                            </div>
                                            <p class="text-xl font-bold text-gray-900 dark:text-white mb-2">₱{{ number_format($service->price_rate, 0, '.', ',') }}<span class="text-sm font-normal text-gray-500 dark:text-gray-400"> per square inch</span></p>
                                            <p class="text-gray-600 dark:text-gray-300">Completion: {{ $service->normal_timeframe }} - {{ $service->normal_timeframe + 5 }} days</p>
                                        </div>

                                        <!-- Rush pricing -->
                                        <div class="bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl p-5 shadow-sm transition-all hover:shadow-md">
                                            <div class="flex justify-between items-center mb-2">
                                                <h4 class="font-semibold text-gray-900 dark:text-white">Rush Price</h4>
                                                <span class="text-sm px-2.5 py-1 bg-orange-100 dark:bg-orange-900 text-orange-800 dark:text-orange-200 rounded-lg">Express</span>
                                            </div>
                                            <p class="text-xl font-bold text-gray-900 dark:text-white mb-2">₱{{ number_format($service->rush_price_rate, 0, '.', ',') }}<span class="text-sm font-normal text-gray-500 dark:text-gray-400"> per square inch</span></p>
                                            <p class="text-gray-600 dark:text-gray-300">Completion: {{ $service->rush_timeframe }} - {{ $service->rush_timeframe + 5 }} days</p>
                                        </div>
                                    </div>

                                    <!-- Payment methods -->
                                    <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-4 shadow-sm">
                                        <div class="flex items-center gap-3">
                                            <svg class="w-5 h-5 text-gray-700 dark:text-gray-200" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M21 5H3C1.89543 5 1 5.89543 1 7V17C1 18.1046 1.89543 19 3 19H21C22.1046 19 23 18.1046 23 17V7C23 5.89543 22.1046 5 21 5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M1 10H23" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <p class="text-sm font-medium text-gray-800 dark:text-gray-200">Accepts</p>
                                            <img src="{{ asset('images/paymongo.png') }}" alt="Paymongo" class="h-6">
                                        </div>
                                    </div>

                                    <!-- Service features -->
                                    <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-6 shadow-sm space-y-4">
                                        <div class="flex items-center gap-3">
                                            <svg class="w-5 h-5 text-green-600 dark:text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M13 7h6l2 4m-8-4v8m0-8V6a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v9h2m8 0H9m4 0h2m4 0h2v-4m0 0h-5m3.5 5.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Zm-10 0a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Z"></path>
                                            </svg>
                                            <p class="text-gray-700 dark:text-gray-200">Free shipping within Zamboanga</p>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <svg class="w-5 h-5 text-green-600 dark:text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M8.5 11.5 11 14l4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"></path>
                                            </svg>
                                            <p class="text-gray-700 dark:text-gray-200">7-day money back guarantee</p>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <svg class="w-5 h-5 text-green-600 dark:text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M10 3v4a1 1 0 0 1-1 1H5m4 10v-2m3 2v-6m3 6v-3m4-11v16a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V7.914a1 1 0 0 1 .293-.707l3.914-3.914A1 1 0 0 1 9.914 3H18a1 1 0 0 1 1 1Z"></path>
                                            </svg>
                                            <p class="text-gray-700 dark:text-gray-200">Quality assured</p>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <svg class="w-5 h-5 text-red-600 dark:text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M6 6l12 12M6 18L18 6"></path>
                                            </svg>
                                            <p class="text-gray-700 dark:text-gray-200">No cancellation once accepted</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Right column: Order form -->
                                <form class="w-full md:w-3/5 space-y-6" action="{{ route('client.request.store', $service) }}"
                                    method="POST" enctype="multipart/form-data" x-data="orderForm()">
                                    @csrf
                                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Request an Artwork</h2>

                                    <!-- Description -->
                                    <div class="space-y-2">
                                        <x-input-label for="description" :value="__('Artwork Description')" class="text-base" />
                                        <textarea id="description" name="description" x-model="description"
                                            class="w-full p-4 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white resize-none min-h-32"
                                            placeholder="Describe your artwork in detail..." required></textarea>
                                        <x-input-error :messages="$errors->get('description')" class="mt-1" />
                                    </div>

                                    <!-- Dimensions -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div class="space-y-2">
                                            <x-input-label for="width" :value="__('Width')" class="text-base" />
                                            <div class="flex">
                                                <x-text-input id="width"
                                                    class="block w-full rounded-l-xl border-r-0 dark:bg-gray-700 dark:text-white"
                                                    type="number" name="width" x-model="width" min="1" required />
                                                <select class="border-gray-300 dark:border-gray-600 rounded-r-xl dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500"
                                                    x-model="unit" name="unit">
                                                    <option value="cm">cm</option>
                                                    <option value="in">inches</option>
                                                </select>
                                            </div>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Width of your artwork</p>
                                        </div>

                                        <div class="space-y-2">
                                            <x-input-label for="height" :value="__('Height')" class="text-base" />
                                            <div class="flex">
                                                <x-text-input id="height"
                                                    class="block w-full rounded-l-xl border-r-0 dark:bg-gray-700 dark:text-white"
                                                    type="number" name="height" x-model="height" min="1" required />
                                                <select class="border-gray-300 dark:border-gray-600 rounded-r-xl dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500"
                                                    x-model="unit" name="unit">
                                                    <option value="cm">cm</option>
                                                    <option value="in">inches</option>
                                                </select>
                                            </div>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Height of your artwork</p>
                                        </div>
                                    </div>

                                    <!-- Order Type -->
                                    <div class="space-y-3">
                                        <x-input-label for="order_type" :value="__('Order Type')" class="text-base" />
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div @click="orderType = 'normal'"
                                                :class="{ 'ring-2 ring-blue-500 bg-blue-50 dark:bg-blue-900': orderType === 'normal' }"
                                                class="cursor-pointer p-5 border border-gray-200 dark:border-gray-600 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700 transition-all">
                                                <div class="flex items-center gap-3">
                                                    <div :class="orderType === 'normal' ? 'bg-blue-500' : 'bg-gray-200 dark:bg-gray-600'"
                                                        class="w-5 h-5 rounded-full flex items-center justify-center">
                                                        <div :class="orderType === 'normal' ? 'bg-white' : 'bg-transparent'"
                                                            class="w-2 h-2 rounded-full"></div>
                                                    </div>
                                                    <div>
                                                        <p class="font-medium text-gray-900 dark:text-white">Normal Order</p>
                                                        <p class="text-sm text-gray-500 dark:text-gray-400">Standard delivery time</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div @click="orderType = 'rush'"
                                                :class="{ 'ring-2 ring-blue-500 bg-blue-50 dark:bg-blue-900': orderType === 'rush' }"
                                                class="cursor-pointer p-5 border border-gray-200 dark:border-gray-600 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700 transition-all">
                                                <div class="flex items-center gap-3">
                                                    <div :class="orderType === 'rush' ? 'bg-blue-500' : 'bg-gray-200 dark:bg-gray-600'"
                                                        class="w-5 h-5 rounded-full flex items-center justify-center">
                                                        <div :class="orderType === 'rush' ? 'bg-white' : 'bg-transparent'"
                                                            class="w-2 h-2 rounded-full"></div>
                                                    </div>
                                                    <div>
                                                        <p class="font-medium text-gray-900 dark:text-white">Rush Order</p>
                                                        <p class="text-sm text-gray-500 dark:text-gray-400">Faster delivery, premium rate</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" id="order_type" name="order_type" x-model="orderType">
                                    </div>

                                    <!-- Quantity -->
                                    <div class="space-y-3">
                                        <x-input-label for="quantity" :value="__('Quantity')" class="text-base" />
                                        <div class="flex items-center">
                                            <button type="button" @click="quantity = Math.max(1, quantity - 1)" :disabled="quantity <= 1"
                                                class="p-3 rounded-l-xl border border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 disabled:opacity-50 disabled:cursor-not-allowed transition-colors">
                                                <svg class="w-4 h-4 text-gray-900 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 2">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h16" />
                                                </svg>
                                            </button>

                                            <input type="number" id="quantity" name="quantity" x-model="quantity"
                                                @input="quantity = Math.max(1, Math.min(5, $event.target.value))"
                                                class="w-16 text-center border-y border-gray-300 dark:border-gray-600 h-12 dark:bg-gray-700 dark:text-white"
                                                min="1" max="5" required />

                                            <button type="button" @click="quantity = Math.min(5, quantity + 1)" :disabled="quantity >= 5"
                                                class="p-3 rounded-r-xl border border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 disabled:opacity-50 disabled:cursor-not-allowed transition-colors">
                                                <svg class="w-4 h-4 text-gray-900 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16" />
                                                </svg>
                                            </button>

                                            <p class="ml-4 text-sm text-gray-600 dark:text-gray-300">
                                                Maximum 5 pieces
                                            </p>
                                        </div>
                                    </div>

                                    <!-- References (Multiple Image Upload) -->
                                    <div x-data="{ files: [], isValid: false }" @change="isValid = files.length > 0" class="space-y-3">
                                        <x-input-label for="references" :value="__('Reference Images')" class="text-base" />
                                        <div class="flex items-center justify-center w-full">
                                            <label for="references" class="flex flex-col items-center justify-center w-full h-48 border-2 border-gray-300 border-dashed rounded-xl cursor-pointer bg-gray-50 dark:hover:bg-gray-700 dark:bg-gray-800 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500">
                                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                                    <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                                    </svg>
                                                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400">Upload reference images (PNG, JPG or JPEG)</p>
                                                </div>
                                                <input id="references" type="file" name="references[]" accept="image/*" multiple required class="hidden" @change="files = Array.from($event.target.files)">
                                            </label>
                                        </div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Upload up to 5 reference images</p>
                                        <x-input-error :messages="$errors->get('references')" class="mt-1" />

                                        <!-- Display selected images -->
                                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-4 mt-4" x-show="files.length > 0">
                                            <template x-for="file in files" :key="file.name">
                                                <div class="relative rounded-xl overflow-hidden bg-gray-100 dark:bg-gray-700 aspect-square">
                                                    <img :src="URL.createObjectURL(file)" class="w-full h-full object-cover">
                                                    <button type="button"
                                                        class="absolute top-2 right-2 bg-red-500 hover:bg-red-600 transition-colors text-white rounded-full p-1"
                                                        @click="files = files.filter(f => f !== file)">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </template>
                                        </div>
                                    </div>

                                    <!-- Price Calculator -->
                                    <div class="bg-blue-50 dark:bg-blue-900/30 rounded-xl p-6 shadow-sm border border-blue-100 dark:border-blue-800">
                                        <div class="space-y-4">
                                            <div class="flex justify-between items-center">
                                                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Price Summary</h2>
                                                <div class="flex items-center gap-1 text-sm text-gray-500 dark:text-gray-400">
                                                    <svg class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                    </svg>
                                                    <span>(W × H) × Price Rate</span>
                                                </div>
                                            </div>

                                            <div class="flex justify-between items-center py-2 border-b border-blue-100 dark:border-blue-800">
                                                <span class="text-gray-600 dark:text-gray-300">Dimensions</span>
                                                <span class="font-medium text-gray-900 dark:text-white" x-text="`${width} × ${height} ${unit}`"></span>
                                            </div>

                                            <div class="flex justify-between items-center py-2 border-b border-blue-100 dark:border-blue-800">
                                                <span class="text-gray-600 dark:text-gray-300">Order Type</span>
                                                <span class="font-medium text-gray-900 dark:text-white" x-text="orderType === 'rush' ? 'Rush' : 'Normal'"></span>
                                            </div>

                                            <div class="flex justify-between items-center py-2 border-b border-blue-100 dark:border-blue-800">
                                                <span class="text-gray-600 dark:text-gray-300">Quantity</span>
                                                <span class="font-medium text-gray-900 dark:text-white" x-text="quantity"></span>
                                            </div>

                                            <div class="flex justify-between items-center pt-2">
                                                <span class="text-gray-900 dark:text-white font-semibold">Total Price</span>
                                                <span class="text-2xl font-bold text-blue-600 dark:text-blue-300"
                                                    x-text="'₱' + totalPrice.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })"></span>
                                            </div>

                                            <div class="mt-4 flex items-center gap-2 text-gray-700 dark:text-gray-300">
                                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                <span>Estimated delivery: <span class="font-semibold" x-text="estimatedReceiveDate"></span></span>
                                            </div>

                                            <input type="hidden" name="total_price" x-model="totalPrice">
                                        </div>
                                    </div>

                                    <!-- Continue Button -->
                                    <button data-modal-target="payment-modal" data-modal-toggle="payment-modal"
                                        class="w-full py-4 bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 text-white font-medium rounded-xl transition-colors"
                                        type="button">
                                        Continue to Checkout
                                    </button>

                                    <!-- Payment confirmation modal -->
                                    <div id="payment-modal" tabindex="-1" aria-hidden="true"
                                        class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 overflow-y-auto overflow-x-hidden bg-black bg-opacity-50">
                                        <div class="relative p-4 w-full max-w-2xl max-h-full">
                                            <!-- Modal content -->
                                            <div class="relative bg-white rounded-xl shadow-lg dark:bg-gray-800 overflow-hidden">
                                                <!-- Modal header -->
                                                <div class="flex items-center justify-between p-6 border-b dark:border-gray-700">
                                                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                                                        Request Summary
                                                    </h3>
                                                    <button type="button"
                                                        class="text-gray-400 bg-transparent hover:bg-gray-100 hover:text-gray-900 rounded-lg p-1.5 inline-flex items-center justify-center dark:hover:bg-gray-700 dark:hover:text-white transition-colors"
                                                        data-modal-hide="payment-modal">
                                                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                            fill="none" viewBox="0 0 14 14">
                                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                        </svg>
                                                        <span class="sr-only">Close modal</span>
                                                    </button>
                                                </div>

                                                <!-- Modal body -->
                                                <div class="p-6 space-y-6">
                                                    <div class="space-y-4">
                                                        <!-- Order Summary -->
                                                        <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-4 shadow-sm">
                                                            <h4 class="font-semibold mb-3 text-gray-800 dark:text-white">Order Summary</h4>
                                                            <div class="space-y-2 text-sm">
                                                                <div class="flex justify-between">
                                                                    <span class="text-gray-600 dark:text-gray-300">Dimensions:</span>
                                                                    <span class="font-medium text-gray-900 dark:text-white" x-text="`${width} × ${height} ${unit}`"></span>
                                                                </div>
                                                                <div class="flex justify-between">
                                                                    <span class="text-gray-600 dark:text-gray-300">Order Type:</span>
                                                                    <span class="font-medium text-gray-900 dark:text-white" x-text="orderType === 'rush' ? 'Rush' : 'Normal'"></span>
                                                                </div>
                                                                <div class="flex justify-between">
                                                                    <span class="text-gray-600 dark:text-gray-300">Quantity:</span>
                                                                    <span class="font-medium text-gray-900 dark:text-white" x-text="quantity"></span>
                                                                </div>
                                                                <div class="flex justify-between">
                                                                    <span class="text-gray-600 dark:text-gray-300">Est. Delivery:</span>
                                                                    <span class="font-medium text-gray-900 dark:text-white" x-text="estimatedReceiveDate"></span>
                                                                </div>
                                                                <div class="flex justify-between pt-2 border-t border-gray-200 dark:border-gray-600">
                                                                    <span class="font-semibold text-gray-900 dark:text-white">Total:</span>
                                                                    <span class="font-bold text-blue-600 dark:text-blue-300"
                                                                        x-text="'₱' + totalPrice.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })"></span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Payment Information -->
                                                        <div>
                                                            <h4 class="font-semibold mb-3 text-gray-800 dark:text-white">Payment Information</h4>
                                                            <p class="text-gray-600 dark:text-gray-300 mb-4">
                                                                By submitting this request, you agree to pay 50% of the total price as a deposit.
                                                                The remaining 50% will be due upon completion of the artwork.
                                                            </p>

                                                            <div class="flex items-center mb-4">
                                                                <input id="deposit-agreement" type="checkbox" required
                                                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                                <label for="deposit-agreement" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                                                                    I understand and agree to pay a 50% deposit to start the artwork
                                                                </label>
                                                            </div>

                                                            <div class="flex items-center mb-4">
                                                                <input id="terms-agreement" type="checkbox" required
                                                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                                <label for="terms-agreement" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                                                                    I agree to the <a href="#" class="text-blue-600 hover:underline dark:text-blue-400">terms and conditions</a>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Modal footer -->
                                                <div class="flex items-center justify-between p-6 border-t border-gray-200 dark:border-gray-700">
                                                    <button type="button"
                                                        class="px-5 py-2.5 text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700"
                                                        data-modal-hide="payment-modal">
                                                        Back
                                                    </button>
                                                    <button type="submit"
                                                        class="px-5 py-2.5 text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-800">
                                                        Submit Request
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Alpine.js for Live Calculation -->
                <script>
                    function orderForm() {
                        return {
                            description: '',
                            width: 0,
                            height: 0,
                            unit: 'cm',
                            orderType: 'normal',
                            quantity: 1,
                            base_price: {
                                {
                                    $service - > price_rate
                                }
                            },
                            rush_price: {
                                {
                                    $service - > rush_price_rate
                                }
                            },
                            normal_timeframe: {
                                {
                                    $service - > normal_timeframe
                                }
                            },
                            rush_timeframe: {
                                {
                                    $service - > rush_timeframe
                                }
                            },
                            get totalPrice() {
                                let widthInInches = this.unit === 'cm' ? this.width / 2.54 : this.width;
                                let heightInInches = this.unit === 'cm' ? this.height / 2.54 : this.height;
                                let area = widthInInches * heightInInches;
                                let baseTotal = area * this.base_price * this.quantity;
                                let rushTotal = area * this.rush_price * this.quantity;
                                return this.orderType === 'rush' ? rushTotal : baseTotal;
                            },
                            get estimatedReceiveDate() {
                                let daysToAdd = this.orderType === 'rush' ? this.rush_timeframe : this.normal_timeframe;
                                daysToAdd *= this.quantity;
                                let startDate = new Date();
                                let endDate = new Date();
                                endDate.setDate(startDate.getDate() + daysToAdd + 10);
                                startDate.setDate(startDate.getDate() + daysToAdd + 5);
                                return `${startDate.getDate()} - ${endDate.getDate()} ${startDate.toLocaleDateString('en-US', { month: 'long' })}, ${startDate.getFullYear()}`;
                            }
                        }
                    }
                </script>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('terms')?.addEventListener('change', function() {
            document.getElementById('start-request-btn').disabled = !this.checked;
        });
    </script>
</x-app-layout>