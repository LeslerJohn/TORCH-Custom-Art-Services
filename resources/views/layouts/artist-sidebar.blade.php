<!-- Mobile Menu Button -->
<button id="mobile-menu-button" class="lg:hidden fixed top-4 left-4 p-2 bg-orange-400 text-white rounded-lg z-30 transition-transform duration-300">
    <svg id="toggle-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right transform transition-transform duration-300">
        <path d="m9 18 6-6-6-6" />
    </svg>
</button>

<!-- Backdrop (Visible when sidebar is open) -->
<div id="backdrop" class="fixed inset-0 bg-black bg-opacity-50 z-20 hidden lg:hidden"></div>

<!-- Sidebar -->
<nav id="sidebar" class="fixed pt-4 pr-1 min-h-screen w-64 bg-white shadow-lg border-r-4 border-orange-400 mt-16 z-30 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">
    <!-- Navigation Links -->
    <div class="pl-4 space-y-2">
        <x-responsive-nav-link
            :href="route('artist.dashboard')"
            :active="request()->routeIs('artist.dashboard')"
            class="flex items-center px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-100 hover:text-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-600">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-user">
                <path d="M14 2v4a2 2 0 0 0 2 2h4" />
                <path d="M15 18a3 3 0 1 0-6 0" />
                <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7z" />
                <circle cx="12" cy="13" r="2" />
            </svg>
            <span class="text-md ml-2 font-medium">Overview</span>
        </x-responsive-nav-link>

        <p class="text-sm font-semibold text-gray-500 mt-4 uppercase">Artwork</p>
        <x-responsive-nav-link
            :href="route('artist.service.index')"
            :active="request()->routeIs('artist.service.index')"
            class="flex items-center px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-100 hover:text-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-600">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-heart-handshake">
                <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z" />
                <path d="M12 5 9.04 7.96a2.17 2.17 0 0 0 0 3.08c.82.82 2.13.85 3 .07l2.07-1.9a2.82 2.82 0 0 1 3.79 0l2.96 2.66" />
                <path d="m18 15-2-2" />
                <path d="m15 18-2-2" />
            </svg>
            <span class="text-md ml-2 font-medium">Services</span>
        </x-responsive-nav-link>

        <x-responsive-nav-link
            :href="route('artist.artwork.index')"
            :active="request()->routeIs('artist.artwork.index')"
            class="flex items-center px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-100 hover:text-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-600">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clipboard-list">
                <rect width="8" height="4" x="8" y="2" rx="1" ry="1" />
                <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2" />
                <path d="M12 11h4" />
                <path d="M12 16h4" />
                <path d="M8 11h.01" />
                <path d="M8 16h.01" />
            </svg>
            <span class="text-md ml-2 font-medium">Art Listing</span>
        </x-responsive-nav-link>

        <x-responsive-nav-link
            :href="route('artist.discount.index')"
            :active="request()->routeIs('artist.discount.index')"
            class="flex items-center px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-100 hover:text-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-600">
            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.6 16.733c.234.269.548.456.895.534a1.4 1.4 0 0 0 1.75-.762c.172-.615-.446-1.287-1.242-1.481-.796-.194-1.41-.861-1.241-1.481a1.4 1.4 0 0 1 1.75-.762c.343.077.654.26.888.524m-1.358 4.017v.617m0-5.939v.725M4 15v4m3-6v6M6 8.5 10.5 5 14 7.5 18 4m0 0h-3.5M18 4v3m2 8a5 5 0 1 1-10 0 5 5 0 0 1 10 0Z"/>
            </svg>              
            <span class="text-md ml-2 font-medium">Discounts</span>
        </x-responsive-nav-link>

        <p class="text-sm font-semibold text-gray-500 mt-4 uppercase">Request</p>
        <x-responsive-nav-link
            :href="route('artist.commission.index')"
            :active="request()->routeIs('artist.commission.index')"
            class="flex items-center px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-100 hover:text-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-600">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-hand-coins">
                <path d="M11 15h2a2 2 0 1 0 0-4h-3c-.6 0-1.1.2-1.4.6L3 17" />
                <path d="m7 21 1.6-1.4c.3-.4.8-.6 1.4-.6h4c1.1 0 2.1-.4 2.8-1.2l4.6-4.4a2 2 0 0 0-2.75-2.91l-4.2 3.9" />
                <path d="m2 16 6 6" />
                <circle cx="16" cy="9" r="2.9" />
                <circle cx="6" cy="5" r="3" />
            </svg>
            <span class="text-md ml-2 font-medium">Commissions</span>
        </x-responsive-nav-link>

        <x-responsive-nav-link
            :href="route('artist.order.index')"
            :active="request()->routeIs('artist.order.index')"
            class="flex items-center px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-100 hover:text-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-600">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-hand-platter">
                <path d="M12 3V2" />
                <path d="m15.4 17.4 3.2-2.8a2 2 0 1 1 2.8 2.9l-3.6 3.3c-.7.8-1.7 1.2-2.8 1.2h-4c-1.1 0-2.1-.4-2.8-1.2l-1.302-1.464A1 1 0 0 0 6.151 19H5" />
                <path d="M2 14h12a2 2 0 0 1 0 4h-2" />
                <path d="M4 10h16" />
                <path d="M5 10a7 7 0 0 1 14 0" />
                <path d="M5 14v6a1 1 0 0 1-1 1H2" />
            </svg>
            <span class="text-md ml-2 font-medium">Orders</span>
        </x-responsive-nav-link>

        <x-responsive-nav-link
            :href="route('artist.review.index')"
            :active="request()->routeIs('artist.review.index')"
            class="flex items-center px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-100 hover:text-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-600">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-star">
                <path d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z" />
            </svg>
            <span class="text-md ml-2 font-medium">Reviews</span>
        </x-responsive-nav-link>
    </div>
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
</script>

<style>
    /* Define the rotation class */
    .rotate-90 {
        transform: rotate(90deg);
    }
</style>