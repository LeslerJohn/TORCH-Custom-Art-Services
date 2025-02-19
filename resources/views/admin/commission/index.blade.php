<x-admin-layout>
    <div class="col-span-7">
        <div class="relative mr-6 p-2 overflow-x-auto shadow-md sm:rounded-lg bg-white dark:bg-gray-900">
            <div class="flex items-center justify-between flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 pb-4">
                <div class="flex space-x-2">
                    <x-button-header :href="route('admin.commission.index', ['status' => 'all'])" :active="request('status', 'all') === 'all'">
                        All
                    </x-button-header>
                    <x-button-header :href="route('admin.commission.index', ['status' => 'pending'])" :active="request('status') === 'pending'">
                        Pending
                    </x-button-header>
                    <x-button-header :href="route('admin.commission.index', ['status' => 'in-progress'])" :active="request('status') === 'in-progress'">
                        In Progress
                    </x-button-header>
                    <x-button-header :href="route('admin.commission.index', ['status' => 'completed'])" :active="request('status') === 'completed'">
                        Completed
                    </x-button-header>
                    <x-button-header :href="route('admin.commission.index', ['status' => 'cancelled'])" :active="request('status') === 'cancelled'">
                        Cancelled
                    </x-button-header>
                </div>
                <!-- Search Form -->
                <form method="GET" action="{{ route('admin.user.index') }}" class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>
                    <input type="text" name="search" id="table-search-users"
                        class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Search for users" value="{{ request('search') }}">
                </form>
            </div>
            <!-- Table -->
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead
                    class="text-center text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-800 dark:text-gray-600">
                    <tr>
                        <th scope="col" class="px-6 py-3">Client Name</th>
                        <th scope="col" class="px-6 py-3">Artist Name</th>
                        <th scope="col" class="px-6 py-3">Medium</th>
                        <th scope="col" class="px-6 py-3">Start Date</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3">Progress</th>
                        <th scope="col" class="px-6 py-3">Rating</th>
                        <th scope="col" class="px-6 py-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Example row -->
                    <tr
                        class="bg-white border-b-2 dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-blue-50 dark:hover:bg-blue-200">
                        <td class="px-4 py-2 text-center">
                            <div class="flex items-center justify-center">
                                <img src="" alt="img" class="w-10 h-10 rounded-full bg-gray-200">
                                <span class="ml-2">John Doe</span>
                            </div>
                        </td>
                        <td class="px-4 py-2 text-center">Jane Smith</td>
                        <td class="px-4 py-2 text-center">Oil Painting</td>
                        <td class="px-4 py-2 text-center">2023-01-01</td>
                        <td class="px-4 py-2 text-center">In Progress</td>
                        <td class="px-4 py-2 text-center">50%</td>
                        <td class="px-4 py-2 text-center">4.5</td>
                        <td class="px-4 py-2 text-center">
                            <a href="#"
                                class="text-blue-600 hover:text-blue-900 flex justify-center items-center">
                                <i class="material-icons">visibility</i>
                            </a>
                        </td>
                    </tr>
                    <!-- Add more rows as needed -->
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
