<!-- Mobile Menu Button -->
<button id="mobile-menu-button" class="lg:hidden fixed top-4 left-10 p-2 bg-gradient-to-r from-orange-400 to-orange-500 text-white rounded-lg z-30 shadow-md hover:shadow-lg transition-all duration-300">
    <svg id="toggle-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="transition-transform duration-300">
        <path d="m9 18 6-6-6-6" />
    </svg>
</button>

<!-- Backdrop (Visible when sidebar is open) -->
<div id="backdrop" class="fixed inset-0 bg-black bg-opacity-50 z-20 hidden lg:hidden backdrop-blur-sm transition-opacity duration-300"></div>

<!-- Sidebar -->
<nav id="sidebar" class="fixed top-0 left-0 pt-16 min-h-screen w-72 bg-white dark:bg-gray-800 shadow-xl border-r border-orange-400 z-20 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out overflow-y-auto">
    <!-- User profile section for sidebar -->
    <div class="px-2 py-4 border-b border-gray-100 dark:border-gray-700">
        <div class="flex items-center justify-between cursor-pointer relative overflow-hidden rounded-md" id="profile-header">
            <!-- Cover Image as Background -->
            <div class="absolute inset-0 bg-cover object-cover" style="background-image: url('{{ Auth::user()->coverImage ? Storage::url(Auth::user()->coverImage->path) : asset('images/default.image.jpg') }}');"></div>
            <!-- Profile Content -->
            <div class="relative flex items-center w-full p-4 bg-black bg-opacity-30 backdrop-blur-sm">
                <!-- Profile Image and Details -->
                <div class="flex items-center">
                    <img src="{{ Auth::user()->profileImage ? Storage::url(Auth::user()->profileImage->path) : asset('images/profile.default.jpg') }}"
                        alt="Profile"
                        class="h-10 w-10 rounded-full object-cover border-2 border-white shadow-sm">
                    <div class="ml-3 overflow-hidden">
                        <h3 class="font-semibold text-white text-sm truncate drop-shadow-md">{{ auth()->user()->name }}</h3>
                        <p class="text-xs text-gray-200 truncate drop-shadow-md">{{ auth()->user()->email }}</p>
                    </div>
                </div>

                <!-- Toggle Icon -->
                <svg id="profile-toggle-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white transition-transform duration-300 ml-auto">
                    <path d="m6 9 6 6 6-6" />
                </svg>
            </div>
        </div>
        <div id="profile-content" class="mt-3 hidden">
            <!-- Profile actions -->
            <div class="space-y-2 pt-2">
                <a href="{{ route('profile.edit') }}" class="flex items-center px-3 text-sm rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2 text-gray-500 dark:text-gray-400">
                        <path d="M12 20h9"></path>
                        <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                    </svg>
                    Edit Profile
                </a>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const profileHeader = document.getElementById('profile-header');
            const profileContent = document.getElementById('profile-content');
            const toggleIcon = document.getElementById('profile-toggle-icon');

            // Toggle profile content visibility
            profileHeader.addEventListener('click', function() {
                profileContent.classList.toggle('hidden');
                toggleIcon.classList.toggle('rotate-180');
            });
        });
        // Add transition for rotation animation
        profileToggleIcon.style.transition = 'transform 0.3s ease-in-out';
    </script>

    <!-- Navigation Links -->
    <div class="p-4 space-y-1 overflow-y-auto h-full scrollbar-hide">
        <a href="{{ route('artist.dashboard') }}" class="flex items-center px-4 py-3 rounded-lg text-sm lg:text-md {{ request()->routeIs('artist.dashboard') ? 'bg-orange-50 text-orange-600 dark:bg-gray-700 dark:text-orange-400' : 'text-gray-700 dark:text-gray-200' }} hover:bg-orange-50 hover:text-orange-600 dark:hover:bg-gray-700 dark:hover:text-orange-400 transition-colors duration-200 group">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-activity">
                <path d="M22 12h-2.48a2 2 0 0 0-1.93 1.46l-2.35 8.36a.25.25 0 0 1-.48 0L9.24 2.18a.25.25 0 0 0-.48 0l-2.35 8.36A2 2 0 0 1 4.49 12H2" />
            </svg>
            <span class="ml-3 font-medium">Overview</span>
        </a>

        <div class="pt-4 pb-1">
            <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider px-4">Artwork Management</p>
        </div>

        <a href="{{ route('artist.service.index') }}" class="flex items-center px-4 py-3 rounded-lg text-sm lg:text-md {{ request()->routeIs('artist.service.index') ? 'bg-orange-50 text-orange-600 dark:bg-gray-700 dark:text-orange-400' : 'text-gray-700 dark:text-gray-200' }} hover:bg-orange-50 hover:text-orange-600 dark:hover:bg-gray-700 dark:hover:text-orange-400 transition-colors duration-200 group">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="group-hover:text-orange-500 {{ request()->routeIs('artist.service.index') ? 'text-orange-500' : 'text-gray-500 dark:text-gray-400' }}">
                <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z" />
                <path d="M12 5 9.04 7.96a2.17 2.17 0 0 0 0 3.08c.82.82 2.13.85 3 .07l2.07-1.9a2.82 2.82 0 0 1 3.79 0l2.96 2.66" />
                <path d="m18 15-2-2" />
                <path d="m15 18-2-2" />
            </svg>
            <span class="ml-3 font-medium">Services</span>
        </a>

        <a href="{{ route('artist.artwork.index') }}" class="flex items-center px-4 py-3 rounded-lg text-sm lg:text-md {{ request()->routeIs('artist.artwork.index') ? 'bg-orange-50 text-orange-600 dark:bg-gray-700 dark:text-orange-400' : 'text-gray-700 dark:text-gray-200' }} hover:bg-orange-50 hover:text-orange-600 dark:hover:bg-gray-700 dark:hover:text-orange-400 transition-colors duration-200 group">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="group-hover:text-orange-500 {{ request()->routeIs('artist.artwork.index') ? 'text-orange-500' : 'text-gray-500 dark:text-gray-400' }}">
                <path d="M12 19l7-7 3 3-7 7-3-3z" />
                <path d="M18 13l-1.5-7.5L2 2l3.5 14.5L13 18l5-5z" />
                <path d="m2 2 7.586 7.586" />
                <circle cx="11" cy="11" r="2" />
            </svg>
            <span class="ml-3 font-medium">Art Listing</span>
        </a>

        <a href="{{ route('artist.discount.index') }}" class="flex items-center px-4 py-3 rounded-lg text-sm lg:text-md {{ request()->routeIs('artist.discount.index') ? 'bg-orange-50 text-orange-600 dark:bg-gray-700 dark:text-orange-400' : 'text-gray-700 dark:text-gray-200' }} hover:bg-orange-50 hover:text-orange-600 dark:hover:bg-gray-700 dark:hover:text-orange-400 transition-colors duration-200 group">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="group-hover:text-orange-500 {{ request()->routeIs('artist.discount.index') ? 'text-orange-500' : 'text-gray-500 dark:text-gray-400' }}">
                <path d="M9 15 3 9l6-6" />
                <path d="m15 9-6-6" />
                <path d="M3 9h18" />
                <path d="M21 9v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9" />
                <path d="M9 21v-6a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v6" />
            </svg>
            <span class="ml-3 font-medium">Discounts</span>
        </a>

        <div class="pt-4 pb-1">
            <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider px-4">Client Requests</p>
        </div>

        @php
        $commissionCount = \App\Models\Commission::where('artist_id', auth()->id())->count();
        $orderCount = \App\Models\Order::where('artist_id', auth()->id())->count();
        @endphp

        <a href="{{ route('artist.commission.index') }}" class="flex items-center px-4 py-3 rounded-lg text-sm lg:text-md {{ request()->routeIs('artist.commission.index') ? 'bg-orange-50 text-orange-600 dark:bg-gray-700 dark:text-orange-400' : 'text-gray-700 dark:text-gray-200' }} hover:bg-orange-50 hover:text-orange-600 dark:hover:bg-gray-700 dark:hover:text-orange-400 transition-colors duration-200 group">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="group-hover:text-orange-500 {{ request()->routeIs('artist.commission.index') ? 'text-orange-500' : 'text-gray-500 dark:text-gray-400' }}">
                <path d="M11 15h2a2 2 0 1 0 0-4h-3c-.6 0-1.1.2-1.4.6L3 17" />
                <path d="m7 21 1.6-1.4c.3-.4.8-.6 1.4-.6h4c1.1 0 2.1-.4 2.8-1.2l4.6-4.4a2 2 0 0 0-2.75-2.91l-4.2 3.9" />
                <path d="m2 16 6 6" />
                <circle cx="16" cy="9" r="2.9" />
                <circle cx="6" cy="5" r="3" />
            </svg>
            <span class="ml-3 font-medium">Commissions</span>
        </a>

        <a href="{{ route('artist.order.index') }}" class="flex items-center px-4 py-3 rounded-lg text-sm lg:text-md {{ request()->routeIs('artist.order.index') ? 'bg-orange-50 text-orange-600 dark:bg-gray-700 dark:text-orange-400' : 'text-gray-700 dark:text-gray-200' }} hover:bg-orange-50 hover:text-orange-600 dark:hover:bg-gray-700 dark:hover:text-orange-400 transition-colors duration-200 group">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="group-hover:text-orange-500 {{ request()->routeIs('artist.order.index') ? 'text-orange-500' : 'text-gray-500 dark:text-gray-400' }}">
                <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4H6Z" />
                <path d="M3 6h18" />
                <path d="M16 10a4 4 0 0 1-8 0" />
            </svg>
            <span class="ml-3 font-medium">Orders</span>
        </a>

        <a href="{{ route('artist.review.index') }}" class="flex items-center px-4 py-3 rounded-lg text-sm lg:text-md {{ request()->routeIs('artist.review.index') ? 'bg-orange-50 text-orange-600 dark:bg-gray-700 dark:text-orange-400' : 'text-gray-700 dark:text-gray-200' }} hover:bg-orange-50 hover:text-orange-600 dark:hover:bg-gray-700 dark:hover:text-orange-400 transition-colors duration-200 group">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="group-hover:text-orange-500 {{ request()->routeIs('artist.review.index') ? 'text-orange-500' : 'text-gray-500 dark:text-gray-400' }}">
                <path d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z" />
            </svg>
            <span class="ml-3 font-medium">Reviews</span>
        </a>
    </div>

    <style>
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</nav>

<script>
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const sidebar = document.getElementById('sidebar');
    const backdrop = document.getElementById('backdrop');
    const toggleIcon = document.getElementById('toggle-icon');

    mobileMenuButton.addEventListener('click', function() {
        // Toggle sidebar visibility
        sidebar.classList.toggle('translate-x-0');
        // Toggle backdrop visibility
        backdrop.classList.toggle('hidden');
        // Rotate the toggle icon
        toggleIcon.classList.toggle('rotate-180');
    });

    backdrop.addEventListener('click', function() {
        // Close sidebar and hide backdrop when clicking outside
        sidebar.classList.remove('translate-x-0');
        backdrop.classList.add('hidden');
        toggleIcon.classList.remove('rotate-180');
    });

    // Close sidebar when clicking on a link in mobile view
    const sidebarLinks = document.querySelectorAll('#sidebar a');
    sidebarLinks.forEach(link => {
        link.addEventListener('click', function() {
            if (window.innerWidth < 1024) {
                sidebar.classList.remove('translate-x-0');
                backdrop.classList.add('hidden');
                toggleIcon.classList.remove('rotate-180');
            }
        });
    });
</script>