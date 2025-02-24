<nav x-data="{ open: false }" class="border-b-4 border-orange-400 dark:border-orange-700 fixed top-0 left-0 w-full z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-full mx-auto px-4 sm:px-4 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto object-fit" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-4 sm:-my-px sm:ms-10 sm:flex text-black">
                    {{-- <x-nav-link :href="route('artist.dashboard')" :active="request()->routeIs('artist.dashboard')" class="text-white-500">
                        {{ __('Artist Dashboard') }}
                    </x-nav-link> --}}

                    <h2 class="flex items-center text-center text-[18px]">Artist Dashboard</h2>
                </div>
            </div>

            {{-- <div class="flex flex-1 justify-center items-center">
                <div class="bg-gray-400 rounded ">Search</div>
            </div> --}}
            <!-- Search Form -->
            {{-- <div class="flex flex-1 items-center justify-center mx-4">
                <form action="" method="GET" class="flex max-w-lg">
                    <input type="text" name="query" class="flex px-4 py-2 border border-gray-500 rounded-l-md focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Search...">
                    <button type="submit" class="px-4 py-2 border border-gray-500 rounded-r-md hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <img src="{{ asset('icons/search-svgrepo-com.svg') }}" alt="Icon 1" class="fill-current w-5 h-5">
            </button>
            </form>
        </div> --}}

        <div class="hidden sm:flex sm:items-center sm:ms-6">
            <div class="flex text-white">
                {{-- <a href="{{ route('artist.notifications')}} " class="inline-flex items-center px-2 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-black-600 hover:bg-black-500 focus:outline-none focus:border-black-700 focus:shadow-outline-black active:bg-black-700 transition ease-in-out duration-150"> --}}
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="black lucide lucide-bell">
                    <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9" />
                    <path d="M10.3 21a1.94 1.94 0 0 0 3.4 0" />
                </svg>
                {{-- </a> --}}
            </div>
            <a href="{{ route('dashboard') }}" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-black focus:outline-none transition ease-in-out duration-150">Home</a>
            <!-- Settings Dropdown -->
            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-black-500 dark:text-black-400 bg-white dark:bg-black-800 hover:text-black-700 dark:hover:text-black-300 focus:outline-none transition ease-in-out duration-150">
                        <div>{{ Auth::user()->username }}</div>

                        <div class="ms-1">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <div class="px-4 py-2 border-b border-gray-200 dark:border-gray-600">
                        <div class="font-medium text-base text-orange-500">{{ Auth::user()->username }}</div>
                    </div>
                    {{-- <x-dropdown-link :href="route('artist.portfolio.dashboard')">
                            {{ __('Portfolio') }}
                    </x-dropdown-link>

                    <x-dropdown-link :href="route('profile.edit')">
                        {{ __('Showcase') }}
                    </x-dropdown-link>

                    <x-dropdown-link :href="route('profile.edit')">
                        {{ __('Commissions') }}
                    </x-dropdown-link>

                    <x-dropdown-link :href="route('profile.edit')">
                        {{ __('Services') }}
                    </x-dropdown-link>

                    <x-dropdown-link :href="route('profile.edit')">
                        {{ __('Policies') }}
                    </x-dropdown-link>

                    <x-dropdown-link :href="route('profile.edit')">
                        {{ __('Reviews') }}
                    </x-dropdown-link> --}}

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-dropdown-link :href="route('logout')"
                            onclick="event.preventDefault();
                                                this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-dropdown-link>
                    </form>
                </x-slot>
            </x-dropdown>
        </div>

        <!-- Hamburger -->
        <div class="-me-2 flex items-center sm:hidden">
            <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Responsive Navigation Menu -->
        <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white">
            @if (Auth::check() && Auth::user()->artist)
            <div class="pt-2 pb-3 space-y-1 text-white">
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Home') }}
                </x-responsive-nav-link>
            </div>
            @endif

            <!-- Responsive Settings Options -->
            <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600 bg-white">
                <div class="px-4">
                    <div class="font-medium text-base text-orange-500">{{ Auth::user()->username }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
</nav>