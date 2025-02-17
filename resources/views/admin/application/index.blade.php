<x-admin-layout>
    <div class="grid grid-cols-10 gap-4">
        {{-- TABLE --}}
        <div class="col-span-7">
            <div class="relative mr-6 p-2 overflow-x-auto shadow-md sm:rounded-lg bg-white dark:bg-gray-900">
                <div
                    class="flex items-center justify-between flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 pb-4 ">
                    <div>
                        <button id="dropdownActionButton" data-dropdown-toggle="dropdownAction"
                            class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
                            type="button">
                            <span class="sr-only">Action button</span>
                            Action
                            <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 4 4 4-4" />
                            </svg>
                        </button>
                        <!-- Dropdown menu -->
                        <div id="dropdownAction"
                            class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700 dark:divide-gray-600">
                            <ul class="py-1 text-sm text-gray-700 dark:text-gray-200"
                                aria-labelledby="dropdownActionButton">
                                <li><a href="#"
                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Reward</a>
                                </li>
                                <li><a href="#"
                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Promote</a>
                                </li>
                                <li><a href="#"
                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Activate
                                        account</a></li>
                            </ul>
                            <div class="py-1">
                                <a href="#"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Delete
                                    User</a>
                            </div>
                        </div>
                    </div>
                    <!-- Search Form -->
                    <form method="GET" action="{{ route('admin.user.index') }}" class="relative">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                        </div>
                        <input type="text" name="search" id="table-search-users"
                            class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Search for users" value="{{ request('search') }}">
                    </form>
                </div>
                <!-- Table -->
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">Name</th>
                            <th scope="col" class="px-6 py-3">Role</th>
                            <th scope="col" class="px-6 py-3">Status</th>
                            <th scope="col" class="px-6 py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <th scope="row"
                                    class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                                    <img class="w-10 h-10 rounded-full" src="/docs/images/people/profile-picture-1.jpg"
                                        alt="img">
                                    <div class="ps-3">
                                        <div class="text-base font-semibold">{{ $user->name }}</div>
                                        <div class="font-normal text-gray-500">{{ $user->email }}</div>
                                    </div>
                                </th>
                                <td class="px-6 py-4">{{ ucfirst($user->role) }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        @if ($user->artist)
                                            <div class="h-2.5 w-2.5 rounded-full bg-orange-500 me-2"></div>
                                            {{ $user->artist->status }}
                                        @else
                                            <div class="h-2.5 w-2.5 rounded-full bg-blue-500 me-2"></div> No Status
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 flex items-center gap-2">
                                    <a href="{{ route('admin.application.show', $user->id) }}"
                                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                        <svg class="w-6 h-6 text-blue-800 dark:text-white" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-width="2"
                                                d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z" />
                                            <path stroke="currentColor" stroke-width="2"
                                                d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="flex items-center justify-between pt-4" aria-label="Table navigation">
                    <span
                        class="text-sm font-normal text-gray-500 dark:text-gray-400 mb-4 md:mb-0 block w-full md:inline md:w-auto">
                        Showing <span
                            class="font-semibold text-gray-900 dark:text-white">{{ $users->firstItem() }}</span>
                        to <span class="font-semibold text-gray-900 dark:text-white">{{ $users->lastItem() }}</span>
                        of <span class="font-semibold text-gray-900 dark:text-white">{{ $users->total() }}</span>
                        results
                    </span>
                    {{ $users->links() }}
                </div>
            </div>
        </div>
        {{-- STATISTICS --}}
        <div class="col-span-3 space-y-4">
            <div class="bg-white rounded-lg shadow p-6 w-full max-w-sm">
                <!-- Card Header -->
                <h2 class="text-sm text-gray-500 mb-1">Statistics</h2>
                <h3 class="text-xl font-semibold mb-4">Monthly applications</h3>

                <!-- Chart Container (relative to position center text) -->
                <div class="relative mx-auto" style="width: 200px; height: 200px;">
                    <canvas id="applicationsChart"></canvas>
                    <!-- Center Text Overlay -->
                    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-center">
                        <p class="text-2xl font-bold">1.05</p>
                        <p class="text-sm text-gray-400">Average range</p>
                    </div>
                </div>

                <!-- Legend -->
                <div class="mt-6 space-y-2">
                    @foreach ($chartLabels as $index => $label)
                        <div class="flex items-center">
                            <span class="inline-block w-3 h-3 rounded-full mr-2"
                                style="background-color: {{ ['#6366F1', '#818CF8', '#A5B4FC', '#E0E7FF'][$index] }}">
                            </span>
                            <span class="text-sm text-gray-700">{{ $label }}</span>
                            <span class="ml-auto text-sm text-gray-500">{{ $chartData[$index] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
            {{-- New Artist --}}
            <div class="bg-white shadow rounded-lg p-6">
                <div class="flex items-center justify-between">
                    <!-- Mini Chart -->
                    <div class="w-24 h-12">
                        <canvas id="artistsChart"></canvas>
                    </div>
                    <!-- Text / Statistic -->
                    <div class="text-right">
                        <h3 class="text-2xl font-bold">
                            {{ $artistsCountThisMonth }}
                            <span
                                class="ml-1 {{ $artistTrendIndicator === '↑' ? 'text-green-500' : 'text-red-500' }}">
                                {{ $artistTrendIndicator }}
                            </span>
                        </h3>
                        <p class="text-sm text-gray-500">Artists this month</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        {{-- MONTHLY APPLICATION --}}
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const ctx = document.getElementById('applicationsChart').getContext('2d');

                // Convert Laravel data to JS
                const labels = @json($chartLabels);
                const data = @json($chartData);

                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: labels,
                        datasets: [{
                            data: data,
                            backgroundColor: [
                                '#6366F1', // Indigo-500
                                '#818CF8', // Indigo-400
                                '#A5B4FC', // Indigo-300
                                '#E0E7FF', // Indigo-200
                            ],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        cutout: '70%', // Creates a larger donut hole
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false // Hide default legend; we have a custom one
                            }
                        }
                    }
                });
            });
        </script>
        {{-- NEW ARTIST STATS --}}
        <script>
            // 1) ARTISTS MINI CHART
            const artistCtx = document.getElementById('artistsChart').getContext('2d');
            const artistLabels = @json($artistLabels);
            const artistData = @json($artistData);

            new Chart(artistCtx, {
                type: 'line',
                data: {
                    labels: artistLabels,
                    datasets: [{
                        data: artistData,
                        borderColor: '#22c55e', // Tailwind green-500
                        backgroundColor: 'rgba(34,197,94,0.2)',
                        borderWidth: 2,
                        pointRadius: 3,
                        fill: false,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            display: false
                        },
                        y: {
                            display: false
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        </script>
    @endpush
</x-admin-layout>
