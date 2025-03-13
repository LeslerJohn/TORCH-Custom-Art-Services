<nav x-data="{ open: false }" class="bg-white border-b-2 border-gray-300 fixed top-0 left-0 right-0 z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo and Navigation Links -->
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0">
                    <a href="{{ route('dashboard') }}">
                        <img src="{{ asset('images/torch-full-high-resolution-logo-transparent.png') }}" alt="Torch Logo" class="h-8 w-auto">
                    </a>
                </div>

                <!-- Navigation Links (Desktop) -->
                <div class="hidden sm:flex sm:items-center sm:ms-10 space-x-6">
                    <a href="{{ route('client.artwork') }}" class="text-md hover:text-orange-500">
                        Explore
                    </a>
                    <a href="{{ route('client.artist') }}" class="text-md hover:text-orange-500">
                        Hire an Artist
                    </a>
                    <a href="{{ route('client.service') }}" class="text-md hover:text-orange-500">
                        Commission
                    </a>
                </div>
            </div>

            <!-- Settings Dropdown (Desktop) -->
            <div class="hidden sm:flex sm:items-center sm:ms-6 p-4 gap-2">
                @auth
                <!-- Notification Icon -->
                <svg class="w-6 h-6 text-gray-800 hover:text-orange-500 cursor-pointer" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5.365V3m0 2.365a5.338 5.338 0 0 1 5.133 5.368v1.8c0 2.386 1.867 2.982 1.867 4.175 0 .593 0 1.292-.538 1.292H5.538C5 18 5 17.301 5 16.708c0-1.193 1.867-1.789 1.867-4.175v-1.8A5.338 5.338 0 0 1 12 5.365ZM8.733 18c.094.852.306 1.54.944 2.112a3.48 3.48 0 0 0 4.646 0c.638-.572 1.236-1.26 1.33-2.112h-6.92Z" />
                </svg>

                <!-- Cart Icon -->
                <a href="{{ route('client.cart.index') }}" class="text-gray-800 hover:text-orange-500">
                    <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 4h1.5L9 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-8.5-3h9.25L19 7H7.312" />
                    </svg>
                </a>

                <!-- Profile Dropdown -->
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <img src="{{ Auth::user()->profileImage ? Storage::url(Auth::user()->profileImage->path) : asset('images/profile.default.jpg') }}" alt="Profile Image" class="h-10 w-10 rounded-full object-cover">
                            <svg class="ms-1 h-6 w-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <!-- Dropdown Content -->
                        <div class="px-4 py-2 border-b border-gray-200">
                            <div class="font-medium text-base text-orange-500">{{ Auth::user()->name }}</div>
                        </div>

                        <!-- Profile Link -->
                        @if (Auth::user()->isArtist())
                        <x-dropdown-link :href="route('artist.profile', Auth::user())">
                            Profile
                        </x-dropdown-link>
                        @else
                        <x-dropdown-link :href="route('client.profile')">
                            Profile
                        </x-dropdown-link>
                        @endif

                        <!-- Requests Link -->
                        <x-dropdown-link :href="route('client.request.index')">
                            Requests
                        </x-dropdown-link>

                        <!-- Orders Link -->
                        <x-dropdown-link :href="route('client.order.index')">
                            Orders
                        </x-dropdown-link>

                        <!-- Collections Link -->
                        @if (Auth::user()->isArtist())
                        <x-dropdown-link :href="route('artist.profile', Auth::user())">
                            Collections
                        </x-dropdown-link>
                        @else
                        <x-dropdown-link :href="route('client.profile')">
                            Collections
                        </x-dropdown-link>
                        @endif

                        <!-- Divider -->
                        <div class="border-t border-gray-200"></div>

                        <!-- Artist Dashboard or Become an Artist -->
                        @if (Auth::user()->isArtist())
                        <x-dropdown-link :href="route('artist.dashboard')">
                            Artist Dashboard
                        </x-dropdown-link>
                        @else
                        <x-dropdown-link :href="route('register.artist')">
                            Become an Artist
                        </x-dropdown-link>
                        @endif

                        <!-- Divider -->
                        <div class="border-t border-gray-200"></div>

                        <!-- Settings and Help -->
                        <x-dropdown-link :href="route('profile.edit')">
                            Settings
                        </x-dropdown-link>
                        <x-dropdown-link :href="route('profile.edit')">
                            Help
                        </x-dropdown-link>

                        <!-- Log Out -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                Log Out
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
                @else
                <!-- Sign In Button -->
                <a href="{{ route('login') }}" class="text-md font-bold text-gray-800 border border-gray-800 rounded-full px-4 py-1 hover:bg-gray-100 transition duration-150 ease-in-out">
                    Sign In
                </a>
                @endauth
            </div>

            <!-- Hamburger Menu (Mobile) -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu (Mobile) -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <a href="{{ route('client.artwork') }}" class="block pl-3 pr-4 py-2 text-base font-medium text-gray-700 hover:text-orange-500">Explore</a>
            <a href="{{ route('client.artist') }}" class="block pl-3 pr-4 py-2 text-base font-medium text-gray-700 hover:text-orange-500">Hire an Artist</a>
            <a href="{{ route('client.service') }}" class="block pl-3 pr-4 py-2 text-base font-medium text-gray-700 hover:text-orange-500">Commission</a>
        </div>

        <!-- Responsive Settings Options -->
        @auth
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>
            <div class="mt-3 space-y-1">
                <!-- Profile Link -->
                @if (Auth::user()->isArtist())
                <x-responsive-nav-link :href="route('artist.profile', Auth::user())">
                    Profile
                </x-responsive-nav-link>
                @else
                <x-responsive-nav-link :href="route('client.profile')">
                    Profile
                </x-responsive-nav-link>
                @endif

                <!-- Requests Link -->
                <x-responsive-nav-link :href="route('client.request.index')">
                    Requests
                </x-responsive-nav-link>

                <!-- Orders Link -->
                <x-responsive-nav-link :href="route('client.order.index')">
                    Orders
                </x-responsive-nav-link>

                <!-- Collections Link -->
                @if (Auth::user()->isArtist())
                <x-responsive-nav-link :href="route('artist.profile', Auth::user())">
                    Collections
                </x-responsive-nav-link>
                @else
                <x-responsive-nav-link :href="route('client.profile')">
                    Collections
                </x-responsive-nav-link>
                @endif

                <!-- Divider -->
                <div class="border-t border-gray-200"></div>

                <!-- Artist Dashboard or Become an Artist -->
                @if (Auth::user()->isArtist())
                <x-responsive-nav-link :href="route('artist.dashboard')">
                    Artist Dashboard
                </x-responsive-nav-link>
                @else
                <x-responsive-nav-link :href="route('register.artist')">
                    Become an Artist
                </x-responsive-nav-link>
                @endif

                <!-- Divider -->
                <div class="border-t border-gray-200"></div>

                <!-- Settings and Help -->
                <x-responsive-nav-link :href="route('profile.edit')">
                    Settings
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('profile.edit')">
                    Help
                </x-responsive-nav-link>

                <!-- Log Out -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                        Log Out
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
        @endauth
    </div>
</nav>