<nav x-data="{ open: false }" class="bg-white shadow-md border-b-2 border-orange-500 fixed top-0 left-0 w-full z-30">
    <div class="max-w-8xl px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Left Side: Logo and Dashboard Title -->
            <div class="flex items-center">
                <!-- Logo -->
                <a href="{{ route('dashboard') }}" class="flex-shrink-0 flex items-center ml-0 sm:ml-4">
                    <x-application-logo class="block h-10 w-auto" />
                </a>

                <!-- Dashboard Title - Desktop Only -->
                <div class="hidden lg:flex lg:items-center lg:ml-6">
                    <span class="text-lg font-medium text-gray-800 border-l-2 border-gray-200 pl-6 ml-6">Artist Dashboard</span>
                </div>
            </div>

            <!-- Right Side: Navigation and User Menu -->
            <div class="flex items-center">
                <!-- Desktop Navigation -->
                <div class="hidden sm:flex sm:items-center sm:space-x-6">
                    <!-- Home Link -->
                    <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-orange-500 px-3 py-2 text-sm font-medium transition-colors duration-150">
                        Home
                    </a>

                    <!-- Availability Toggle (for artists) -->
                    @if(Auth::check() && Auth::user()->artist)
                    <form method="POST" action="{{ route('artist.availability') }}" class="flex items-center">
                        @csrf
                        <span class="mr-2 text-sm font-medium text-gray-700">Available</span>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="available" value="1" class="sr-only peer" {{ Auth::user()->artist->available ? 'checked' : '' }} onchange="this.form.submit()">
                            <input type="hidden" name="available" value="0">
                            <div class="w-9 h-5 bg-gray-200 rounded-full peer peer-focus:ring-2 peer-focus:ring-orange-300 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-orange-500"></div>
                        </label>
                    </form>
                    @endif

                    <!-- Notifications -->
                    <button class="text-gray-700 hover:text-orange-500 relative p-1 rounded-full hover:bg-gray-100 transition-colors duration-150">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-bell">
                            <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9" />
                            <path d="M10.3 21a1.94 1.94 0 0 0 3.4 0" />
                        </svg>
                        <!-- Notification badge (if needed) -->
                        <!-- <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-500 rounded-full">5</span> -->
                    </button>

                    <!-- User Menu -->
                    <x-dropdown align="right" width="56">
                        <x-slot name="trigger">
                            <button class="flex items-center text-sm font-medium text-gray-700 hover:text-orange-500 focus:outline-none transition duration-150 ease-in-out">
                                <svg class="ml-1 h-7 w-7 transition-transform duration-200 transform" :class="{'rotate-180': open}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="py-1">
                                <x-dropdown-link :href="route('profile.edit')" class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                                    </svg>
                                    Settings
                                </x-dropdown-link>

                                <x-dropdown-link href="#" class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                                    </svg>
                                    Help
                                </x-dropdown-link>
                            </div>

                            <div class="border-t border-gray-100 py-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="flex items-center text-red-500 hover:text-red-700 hover:bg-red-50">
                                        <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        Log Out
                                    </x-dropdown-link>
                                </form>
                            </div>
                        </x-slot>
                    </x-dropdown>
                </div>

                <!-- Mobile menu button -->
                <div class="flex items-center sm:hidden">
                    <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-500 hover:text-orange-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-orange-500 transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <!-- Mobile navigation items -->
            <a href="{{ route('dashboard') }}" class="block pl-3 pr-4 py-2 border-l-4 border-orange-500 text-base font-medium text-orange-700 bg-orange-50 focus:outline-none focus:text-orange-800 focus:bg-orange-100 focus:border-orange-700 transition duration-150 ease-in-out">
                Home
            </a>

            <a href="{{ route('artist.dashboard') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out">
                Artist Dashboard
            </a>

            <!-- Availability Toggle (Mobile) -->
            @if(Auth::check() && Auth::user()->artist)
            <div class="flex items-center justify-between px-4 py-2">
                <span class="text-base font-medium text-gray-600">Available</span>
                <form method="POST" action="{{ route('artist.availability') }}">
                    @csrf
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="available" value="1" class="sr-only peer" {{ Auth::user()->artist->available ? 'checked' : '' }} onchange="this.form.submit()">
                        <input type="hidden" name="available" value="0">
                        <div class="w-9 h-5 bg-gray-200 rounded-full peer peer-focus:ring-2 peer-focus:ring-orange-300 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-orange-500"></div>
                    </label>
                </form>
            </div>
            @endif
        </div>

        <!-- Mobile user menu -->
        <div class="pt-4 pb-3 border-t border-gray-200">

            <div class="space-y-1">
                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-100 focus:outline-none focus:text-gray-800 focus:bg-gray-100 transition duration-150 ease-in-out">
                    Profile
                </a>
                <a href="#" class="block px-4 py-2 text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-100 focus:outline-none focus:text-gray-800 focus:bg-gray-100 transition duration-150 ease-in-out">
                    Help
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="block px-4 py-2 text-base font-medium text-red-500 hover:text-red-800 hover:bg-red-50 focus:outline-none focus:text-red-800 focus:bg-red-50 transition duration-150 ease-in-out">
                        Log Out
                    </a>
                </form>
            </div>
        </div>
    </div>
</nav>