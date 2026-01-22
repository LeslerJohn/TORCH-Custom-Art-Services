<x-admin-layout>
    <div class="flex justify-between mb-6">
        <h1 class="text-4xl">Overview</h1>
        <a href="{{ route('admin.dashboard.export-all') }}" class="bg-blue-500 text-white px-4 py-2 rounded shadow hover:bg-blue-600">
            Download All Statistics (CSV)
        </a>
    </div>
    <main class="grid grid-cols-1 md:grid-cols-10 gap-4 w-full">
        <section class="col-span-1 md:col-span-3 flex flex-col gap-4">
            <div class="shadow-lg bg-white rounded-lg p-6">
                <!-- Artists Section -->
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
                    <a href="{{ route('admin.dashboard.export', ['type' => 'artists']) }}" class="text-blue-500 text-sm mt-2 inline-block">Download CSV</a>
                </div>
                <hr class="my-4">
                <!-- Clients Section -->
                <div class="bg-white shadow rounded-lg p-6">
                    <div class="flex items-center justify-between">
                        <!-- Mini Chart -->
                        <div class="w-24 h-12">
                            <canvas id="clientsChart"></canvas>
                        </div>
                        <!-- Text / Statistic -->
                        <div class="text-right">
                            <h3 class="text-2xl font-bold">
                                {{ $clientsCountThisMonth }}
                                <span
                                    class="ml-1 {{ $clientTrendIndicator === '↑' ? 'text-green-500' : 'text-red-500' }}">
                                    {{ $clientTrendIndicator }}
                                </span>
                            </h3>
                            <p class="text-sm text-gray-500">Clients this month</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.dashboard.export', ['type' => 'clients']) }}" class="text-blue-500 text-sm mt-2 inline-block">Download CSV</a>
                </div>
            </div>

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
                <a href="{{ route('admin.dashboard.export', ['type' => 'applications']) }}" class="text-blue-500 text-sm mt-2 inline-block">Download CSV</a>
            </div>
        </section>

        <section class="col-span-1 md:col-span-7 w-full flex flex-col gap-4">
            <div class="bg-white rounded-lg shadow p-6 w-full">
                <!-- Header -->
                <h2 class="text-sm text-gray-500">Statistics</h2>
                <h3 class="text-xl font-semibold mb-2">New Artists This Month</h3>
                <!-- Big Number + Growth Indicator -->
                <div class="flex items-center space-x-2 mb-4">
                    <span class="text-3xl font-bold">{{ number_format($latestArtistCount) }}</span>
                    <span class="flex items-center text-green-500 text-sm">
                        <!-- Up/Down arrow icon (conditionally show red if negative) -->
                        @if ($artistTrendIndicator === '↑')
                            <svg class="w-4 h-4 mr-0.5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3.293 9.293a1 1 0 011.414 0L10 14.586l5.293-5.293a1 1
                                      0 011.414 1.414l-6 6a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414z" clip-rule="evenodd">
                                </path>
                            </svg>
                        @else
                            <!-- If negative, show a down arrow or red color -->
                            <svg class="w-4 h-4 mr-0.5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 9.293a1 1 0 00-1.414 0L10
                                      14.586l-5.293-5.293a1 1 0 00-1.414
                                      1.414l6 6a1 1 0 001.414
                                      0l6-6a1 1 0 000-1.414z" clip-rule="evenodd">
                                </path>
                            </svg>
                        @endif
                        {{ $artistPercentageChange }}%
                    </span>
                </div>

                <!-- Chart Container -->
                <div class="relative w-full h-fit">
                    <canvas id="newArtistsChart"></canvas>
                </div>
                <a href="{{ route('admin.dashboard.export', ['type' => 'transactions']) }}" class="text-blue-500 text-sm mt-2 inline-block">Download CSV</a>
            </div>
            {{-- TRANSACTION GRAPH --}}
            <div class="bg-white rounded-lg shadow p-6 w-full">
                <h2 class="text-sm text-gray-500">Statistics</h2>
                <h3 class="text-xl font-semibold mb-2">Total Transactions</h3>
                <!-- Top Section -->
                <div class="flex justify-between items-start mb-4">
                    <div class="flex items-center space-x-2">
                        <!-- Big number -->
                        <span class="text-3xl font-bold">{{ number_format($latestTransactionsCount) }}</span>
                        <!-- Percentage & arrow -->

                        @if ($transactionsTrendIndicator === '↑')
                            <svg class="w-4 h-4 mr-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3.293 10.293a1 1 0 011.414 0L10
                                          15.586l5.293-5.293a1 1 0 011.414
                                          1.414l-6 6a1 1 0 01-1.414
                                          0l-6-6a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="flex items-center text-green-500 text-sm">
                                {{ $transactionsPercentageChange }}%
                            </span>
                        @else
                            <svg class="w-4 h-4 mr-0.5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 9.293a1 1 0 00-1.414 0L10
                                          14.586l-5.293-5.293a1 1 0 00-1.414
                                          1.414l6 6a1 1 0 001.414
                                          0l6-6a1 1 0 000-1.414z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="flex items-center text-red-500 text-sm">
                                {{ $transactionsPercentageChange }}%
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Chart Container -->
                <div class="relative w-full h-fit">
                    <canvas id="transactionsChart"></canvas>
                </div>
            </div>
        </section>
    </main>

    @push('scripts')
        {{-- USER STATISTICS GRAPH --}}
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

            // 2) CLIENTS MINI CHART
            const clientCtx = document.getElementById('clientsChart').getContext('2d');
            const clientLabels = @json($clientLabels);
            const clientData = @json($clientData);

            new Chart(clientCtx, {
                type: 'line',
                data: {
                    labels: clientLabels,
                    datasets: [{
                        data: clientData,
                        borderColor: '#ef4444', // Tailwind red-500
                        backgroundColor: 'rgba(239,68,68,0.2)',
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
        {{-- ARTIST PER MONTH GRAPH --}}
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const ctx = document.getElementById('newArtistsChart').getContext('2d');

                // 1) Convert Laravel data to JS
                const labels = @json($monthlyArtistLabels); // e.g. ["Aug","Sept","Oct","Nov","Dec"]
                const data = @json($monthlyArtistData); // e.g. [8000, 9000, 11756, 10000, 10500]

                // 2) Create a gradient fill
                const gradient = ctx.createLinearGradient(0, 0, 0, 300);
                gradient.addColorStop(0, 'rgba(59,130,246,0.3)'); // #3B82F6 (Indigo/Blue)
                gradient.addColorStop(1, 'rgba(59,130,246,0)'); // Transparent

                // 3) Build the chart
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'New Artists',
                            data: data,
                            borderColor: '#3B82F6', // Blue
                            backgroundColor: gradient,
                            fill: true,
                            tension: 0.4,
                            pointRadius: 5,
                            pointHoverRadius: 7
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            x: {
                                grid: {
                                    display: true,
                                    color: '#F3F4F6', // Light gray
                                }
                            },
                            y: {
                                beginAtZero: false,
                                grid: {
                                    color: '#F3F4F6'
                                },
                                ticks: {
                                    color: '#6B7280' // Gray text
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            annotation: {
                                annotations: {
                                    @foreach ($chartLabels as $index => $label)
                                        verticalLine{{ $index }}: {
                                            type: 'line',
                                            xMin: {{ $index }},
                                            xMax: {{ $index }},
                                            borderColor: '#3B82F6',
                                            borderWidth: 2,
                                            borderDash: [4, 4],
                                            label: {
                                                enabled: true,
                                                content: '{{ $label }}',
                                                position: 'end',
                                                backgroundColor: '#3B82F6',
                                                color: '#fff',
                                            }
                                        },
                                    @endforeach
                                }
                            }
                        },
                        interaction: {
                            mode: 'index',
                            intersect: false
                        }
                    }
                });
            });
        </script>
        {{-- TRANSACTION GRAPH --}}
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const ctx = document.getElementById('transactionsChart').getContext('2d');

                // 1) Convert Laravel data to JS
                const labels = @json($monthlyTransactionsLabels); // e.g. ["Jan","Feb","Mar","Apr","May","Jun"]
                const data = @json($monthlyTransactionsData); // e.g. [400,700,900,1000,900,700]

                // 2) Create gradient fill
                const gradient = ctx.createLinearGradient(0, 0, 0, 300);
                gradient.addColorStop(0, 'rgba(59, 130, 246, 0.3)'); // #3B82F6 with alpha
                gradient.addColorStop(1, 'rgba(59, 130, 246, 0)'); // fade to transparent

                // 3) Build the chart
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Transactions',
                            data: data,
                            borderColor: '#3B82F6',
                            backgroundColor: gradient,
                            fill: true,
                            tension: 0.4,
                            pointRadius: 5,
                            pointHoverRadius: 7
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            x: {
                                grid: {
                                    color: '#E5E7EB', // light gray
                                    drawBorder: true
                                }
                            },
                            y: {
                                beginAtZero: false,
                                grid: {
                                    color: '#E5E7EB'
                                },
                                ticks: {
                                    color: '#6B7280' // gray text
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            // (Optional) annotation if you want a dotted vertical line
                            // annotation: {
                            //   annotations: {
                            //       lineAtFeb: {
                            //           type: 'line',
                            //           xMin: 1, // index for "Feb" if Jan=0, Feb=1
                            //           xMax: 1,
                            //           borderColor: '#3B82F6',
                            //           borderWidth: 2,
                            //           borderDash: [4,4],
                            //           label: {
                            //               enabled: true,
                            //               content: 'Feb',
                            //               position: 'end',
                            //               backgroundColor: '#3B82F6',
                            //               color: '#fff'
                            //           }
                            //       }
                            //   }
                            // }
                        },
                        interaction: {
                            mode: 'index',
                            intersect: false
                        }
                    }
                });
            });
        </script>
    @endpush
</x-admin-layout>
