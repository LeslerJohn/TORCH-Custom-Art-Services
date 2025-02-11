<nav class="fixed pt-4 pr-1 min-h-screen w-64 bg-white shadow-lg border-r-4 border-orange-400 mt-16 z-10">

    <!-- Navigation Links -->
    <div class=" pl-4 space-y-2">
        <x-responsive-nav-link
            {{-- :href="route('artist.portfolio.dashboard')"
            :active="request()->routeIs('artist.portfolio.dashboard')" --}}
            class="flex items-center px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-100 hover:text-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-600">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-user">
                <path d="M14 2v4a2 2 0 0 0 2 2h4" />
                <path d="M15 18a3 3 0 1 0-6 0" />
                <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7z" />
                <circle cx="12" cy="13" r="2" />
            </svg>
            <span class="text-md ml-2 font-medium">Overview</span>
        </x-responsive-nav-link>

        <p class="text-sm mt-2">Artwork</p>
        <x-responsive-nav-link
            :href="route('artist.service.index')"
            :active="request()->routeIs('artist.service.index')"
            class="flex items-center px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-100 hover:text-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-600">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-waypoints">
                <circle cx="12" cy="4.5" r="2.5" />
                <path d="m10.2 6.3-3.9 3.9" />
                <circle cx="4.5" cy="12" r="2.5" />
                <path d="M7 12h10" />
                <circle cx="19.5" cy="12" r="2.5" />
                <path d="m13.8 17.7 3.9-3.9" />
                <circle cx="12" cy="19.5" r="2.5" />
            </svg>
            <span class="text-md ml-2 font-medium">Services</span>
        </x-responsive-nav-link>

        <x-responsive-nav-link
            :href="route('artist.artwork.index')"
            :active="request()->routeIs('artist.artwork.index')"
            class="flex items-center px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-100 hover:text-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-600">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-waypoints">
                <circle cx="12" cy="4.5" r="2.5" />
                <path d="m10.2 6.3-3.9 3.9" />
                <circle cx="4.5" cy="12" r="2.5" />
                <path d="M7 12h10" />
                <circle cx="19.5" cy="12" r="2.5" />
                <path d="m13.8 17.7 3.9-3.9" />
                <circle cx="12" cy="19.5" r="2.5" />
            </svg>
            <span class="text-md ml-2 font-medium">Art Listing</span>
        </x-responsive-nav-link>

        <p class="text-sm mt-2">Request</p>
        <x-responsive-nav-link
            {{-- :href="route('artist.commissions.dashboard')"
            :active="request()->routeIs('artist.commissions.dashboard')" --}}
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
            {{-- :href="route('artist.commissions.dashboard')"
            :active="request()->routeIs('artist.commissions.dashboard')" --}}
            class="flex items-center px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-100 hover:text-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-600">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-hand-coins">
                <path d="M11 15h2a2 2 0 1 0 0-4h-3c-.6 0-1.1.2-1.4.6L3 17" />
                <path d="m7 21 1.6-1.4c.3-.4.8-.6 1.4-.6h4c1.1 0 2.1-.4 2.8-1.2l4.6-4.4a2 2 0 0 0-2.75-2.91l-4.2 3.9" />
                <path d="m2 16 6 6" />
                <circle cx="16" cy="9" r="2.9" />
                <circle cx="6" cy="5" r="3" />
            </svg>
            <span class="text-md ml-2 font-medium">Orders</span>
        </x-responsive-nav-link>

        <x-responsive-nav-link
            {{-- :href="route('artist.reviews.dashboard')"
            :active="request()->routeIs('artist.reviews.dashboard')" --}}
            class="flex items-center px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-100 hover:text-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-600">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-star">
                <path d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z" />
            </svg>
            <span class="text-md ml-2 font-medium">Reviews</span>
        </x-responsive-nav-link>
    </div>
</nav>