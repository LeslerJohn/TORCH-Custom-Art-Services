<main class="h-fit">
    <!-- Sidebar Toggle Button (visible on small screens) -->
    <button data-drawer-target="default-sidebar" data-drawer-toggle="default-sidebar" aria-controls="default-sidebar"
        type="button"
        class="inline-flex items-center p-2 mt-2 ml-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
        <span class="sr-only">Open sidebar</span>
        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path clip-rule="evenodd" fill-rule="evenodd"
                d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
            </path>
        </svg>
    </button>

    <!-- Sidebar Navigation Menu using Flowbite Structure -->
    <aside id="default-sidebar"
        class="top-0 left-0 z-40 w-auto pt-16 h-screen sm:translate-x-0"
        aria-label="Sidenav">
        <div
            class="py-5 px-3 h-full bg-white border-r border-gray-200 dark:bg-gray-800 dark:border-gray-700">
            <ul class="space-y-2">
            <li>
                <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" class="flex items-center space-x-2">
                <i class="material-icons">dashboard</i>
                <span>{{ __('Overview') }}</span>
                </x-responsive-nav-link>
            </li>
            <li>
                <x-responsive-nav-link :href="route('admin.application.index')" :active="request()->routeIs('admin.application.index')" class="flex items-center space-x-2">
                <i class="material-icons">assignment</i>
                <span>{{ __('Artist Applications') }}</span>
                </x-responsive-nav-link>
            </li>
            <li>
                <x-responsive-nav-link :href="route('admin.commission.index')" :active="request()->routeIs('admin.commission.index')" class="flex items-center space-x-2">
                <i class="material-icons">monetization_on</i>
                <span>{{ __('Commissions') }}</span>
                </x-responsive-nav-link>
            </li>
            <li>
                <x-responsive-nav-link :href="route('admin.order.index')" :active="request()->routeIs('admin.order.index')" class="flex items-center space-x-2">
                <i class="material-icons">list_alt</i>
                <span>{{ __('Orders') }}</span>
                </x-responsive-nav-link>
            </li>
            <li>
                <x-responsive-nav-link :href="route('admin.user.index')" :active="request()->routeIs('admin.user.index')" class="flex items-center space-x-2">
                <i class="material-icons">people</i>
                <span>{{ __('User Management') }}</span>
                </x-responsive-nav-link>
            </li>
            <li>
                <x-responsive-nav-link :href="route('admin.category.index')" :active="request()->routeIs('admin.category.index')" class="flex items-center space-x-2">
                <i class="material-icons">category</i>
                <span>{{ __('Categories') }}</span>
                </x-responsive-nav-link>
            </li>
            <li>
                <x-responsive-nav-link :href="route('admin.report.index')" :active="request()->routeIs('admin.report.index')" class="flex items-center space-x-2">
                <i class="material-icons">report</i>
                <span>{{ __('Reports') }}</span>
                </x-responsive-nav-link>
            </li>
            </ul>
        </div>
    </aside>
</main>
