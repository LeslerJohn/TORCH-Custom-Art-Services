<x-admin-layout>
    <div class="col-span-7">
        <div class="relative p-2 overflow-x-auto shadow-md sm:rounded-lg bg-white dark:bg-gray-900">
            <div
                class="flex items-center justify-between flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 pb-2 border-b-2">
                <div class="flex space-x-2">
                    <x-button-header :href="route('admin.report.index', ['status' => 'all'])" :active="request('status', 'all') === 'all'">
                        All
                    </x-button-header>
                    <x-button-header :href="route('admin.report.index', ['status' => 'pending'])" :active="request('status') === 'pending'">
                        Pending
                    </x-button-header>
                    <x-button-header :href="route('admin.commission.index', ['status' => 'resolved'])" :active="request('status') === 'resolved'">
                        Resolved
                    </x-button-header>
                    <x-button-header :href="route('admin.commission.index', ['status' => 'rejected'])" :active="request('status') === 'rejected'">
                        Rejected
                    </x-button-header>
                    <x-button-header :href="route('admin.commission.index', ['status' => 'under-review'])" :active="request('status') === 'under-review'">
                        Under Review
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
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 mt-2">
                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Name
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Email
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Reason for Report
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Report Date
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Reported By
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                    <!-- Example row -->
                    <tr class="hover:bg-gray-100 dark:hover:bg-gray-800">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900 dark:text-gray-200">
                                John Doe
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900 dark:text-gray-200">john.doe@example.com</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900 dark:text-gray-200">Inappropriate Content</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900 dark:text-gray-200">2023-01-01</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900 dark:text-gray-200">Jane Smith</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                Pending
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('admin.report.show', 1) }}" class="text-indigo-600 hover:text-indigo-900">
                                <i class="material-icons">more_horiz</i>
                            </a>
                        </td>
                    </tr>
                    <!-- Add more rows as needed -->
                </tbody>
            </table>
            {{-- PAGINATION --}}
            {{-- <div class="flex items-center justify-between pt-4" aria-label="Table navigation">
                    <span
                        class="text-sm font-normal text-gray-500 dark:text-gray-400 mb-4 md:mb-0 block w-full md:inline md:w-auto">
                        Showing <span
                            class="font-semibold text-gray-900 dark:text-white">{{ $users->firstItem() }}</span>
                        to <span class="font-semibold text-gray-900 dark:text-white">{{ $users->lastItem() }}</span>
                        of <span class="font-semibold text-gray-900 dark:text-white">{{ $users->total() }}</span>
                        results
                    </span>
                    {{ $users->links() }}
                </div> --}}
        </div>

    </div>
</x-admin-layout>
