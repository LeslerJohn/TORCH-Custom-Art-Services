<x-app-layout>
    <div class="py-8">
        <div class="mx-auto sm:px-6 lg:px-8 space-y-6 min-h-screen">
            <!-- Page Title -->
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ __('Profile Settings') }}
            </h2>

            <!-- Vertical Tab Layout -->
            <div class="flex flex-col md:flex-row gap-6">
                <!-- Vertical Tab Navigation -->
                <div class="w-full md:w-1/4 bg-white shadow rounded-lg p-4">
                    <ul class="space-y-2">
                        <li>
                            <button onclick="switchTab('profile')" class="w-full text-left px-4 py-2 rounded-lg hover:bg-gray-100 transition">
                                Profile Information
                            </button>
                        </li>
                        <li>
                            <button onclick="switchTab('address')" class="w-full text-left px-4 py-2 rounded-lg hover:bg-gray-100 transition">
                                Address
                            </button>
                        </li>
                        <li>
                            <button onclick="switchTab('password')" class="w-full text-left px-4 py-2 rounded-lg hover:bg-gray-100 transition">
                                Update Password
                            </button>
                        </li>
                        <li>
                            <button onclick="switchTab('delete')" class="w-full text-left px-4 py-2 rounded-lg hover:bg-gray-100 transition text-red-600">
                                Delete Account
                            </button>
                        </li>
                    </ul>
                </div>

                <!-- Content Area -->
                <div class="w-full md:w-3/4">
                    <!-- Profile Information Tab -->
                    <div id="profile" class="tab-content p-6 shadow rounded-lg max-h-[calc(100vh-200px)] overflow-y-auto scrollbar-hide">
                        @include('profile.partials.update-profile-information-form')
                    </div>

                    <!-- Address Tab -->
                    <div id="address" class="tab-content p-6 shadow rounded-lg hidden max-h-[calc(100vh-200px)] overflow-y-auto scrollbar-hide">
                        @include('profile.partials.edit-address-form')
                    </div>

                    <!-- Update Password Tab -->
                    <div id="password" class="tab-content p-6 shadow rounded-lg hidden max-h-[calc(100vh-200px)] overflow-y-auto scrollbar-hide">
                        @include('profile.partials.update-password-form')
                    </div>

                    <!-- Delete Account Tab -->
                    <div id="delete" class="tab-content p-6 shadow rounded-lg hidden max-h-[calc(100vh-200px)] overflow-y-auto scrollbar-hide">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
        <footer>
            <div>
                @include('layouts.footer')
            </div>
        </footer>
    </div>

</x-app-layout>

<!-- JavaScript to Handle Tab Switching -->
<script>
    function switchTab(tabName) {
        // Hide all tab content
        document.querySelectorAll('.tab-content').forEach(tab => {
            tab.classList.add('hidden');
        });

        // Show the selected tab content
        document.getElementById(tabName).classList.remove('hidden');
    }

    // Default to showing the first tab
    document.addEventListener('DOMContentLoaded', () => {
        switchTab('profile');
    });
</script>

<style>
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
        /* Hide scrollbar for Chrome, Safari, and Opera */
    }

    .scrollbar-hide {
        scrollbar-width: none;
        /* Hide scrollbar for Firefox */
        -ms-overflow-style: none;
        /* Hide scrollbar for IE and Edge */
    }
</style>