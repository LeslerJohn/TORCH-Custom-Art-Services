<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Page Title -->
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ __('Profile Settings') }}
            </h2>

            <!-- Profile Sections -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Update Profile Information -->
                <div class="p-6 shadow rounded-lg">
                    @include('profile.partials.update-profile-information-form')
                </div>

                <div class="p-6 shadow rounded-lg">
                    @include('profile.partials.edit-address-form')
                </div>
                
                <!-- Update Password -->
                <div class="p-6 shadow rounded-lg">
                    @include('profile.partials.update-password-form')
                </div>

                <!-- Delete Account (Full Width) -->
                <div class="p-6 shadow rounded-lg md:col-span-2">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>