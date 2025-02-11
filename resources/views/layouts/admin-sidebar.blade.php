<!-- Sidebar Navigation Menu -->
<nav x-show="open" x-cloak class="fixed pt-16 pr-2 min-h-screen w-[260px] bg-white bg-white-800 border-r-4 border-gray-200">
    <div class="pt-5 pl-1 pb-3 space-y-2">
        {{-- <x-responsive-nav-link :href="route('artist.dashboard')" :active="request()->routeIs('artist.dashboard')">
            {{ __('Showcase') }}
        </x-responsive-nav-link> --}}
        {{-- <x-responsive-nav-link :href="route('admin.artist-aplications')" :active="request()->routeIs('admin.artist-aplications')">
        <i class="fas fa-paint-brush mr-3"></i>
            {{ __('Artist Aplications') }}
        </x-responsive-nav-link>
        <x-responsive-nav-link :href="route('admin.commissions.insights')" :active="request()->routeIs('admin.commissions.insights')">
        <i class="fas fa-file-invoice-dollar mr-3"></i>
            {{ __('Commissions') }}
        </x-responsive-nav-link> --}}
        <x-responsive-nav-link :href="route('admin.user.index')" :active="request()->routeIs('admin.user.index')">
            {{ __('User Mangement') }}
        </x-responsive-nav-link>
        <x-responsive-nav-link :href="route('admin.application.index')" :active="request()->routeIs('admin.application.index')">
                {{ __('Artist Aplications') }}
            </x-responsive-nav-link>
        <x-responsive-nav-link :href="route('admin.category.index')" :active="request()->routeIs('admin.category.index')">
            {{ __('Categories') }}
        </x-responsive-nav-link>
        {{-- }}
        <x-responsive-nav-link :href="route('admin.content-moderation')" :active="request()->routeIs('admin.content-moderation')">
        <i class="fas fa-shield-alt mr-3"></i>
            {{ __('Content Moderation') }}
        </x-responsive-nav-link>
        <x-responsive-nav-link :href="route('admin.financial-overview')" :active="request()->routeIs('admin.financial-overview')">
        <i class="fas fa-chart-line mr-3"></i>
            {{ __('Financial Overview') }}
        </x-responsive-nav-link>
        <x-responsive-nav-link :href="route('admin.services.services-dashboard')" :active="request()->routeIs('admin.services.services-dashboard')">
        <i class="fas fa-concierge-bell mr-3"></i>
            {{ __('Services') }}
        </x-responsive-nav-link>
        <x-responsive-nav-link :href="route('admin.reports.reports')" :active="request()->routeIs('admin.reports.reports')">
        <i class="fas fa-file-alt mr-3"></i>
            {{ __('Reports') }}
        </x-responsive-nav-link>
        <x-responsive-nav-link :href="route('admin.general-settings')" :active="request()->routeIs('admin.general-settings')">
        <i class="fas fa-cogs mr-3"></i>
            {{ __('General Settings') }}
        </x-responsive-nav-link> --}}
    </div>

    <!-- Responsive Settings Options -->
    {{-- <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
        <div class="px-4">
            <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
            <div class="font-medium text-sm text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</div>
        </div>

        <div class="mt-3 space-y-1">
            <x-responsive-nav-link :href="route('profile.edit')">
                {{ __('Profile') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('profile.edit')">
                {{ __('My Requests') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('profile.edit')">
                {{ __('Saved') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('profile.edit')">
                {{ __('Settings') }}
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
    </div> --}}
</nav>
