<x-artist-layout>
    <div class="container mx-auto p-4 mt-16">
        <div class="flex justify-between mb-6">
            <h1 class="text-2xl font-bold">Artist Dashboard</h1>
            <a href="{{ route('artist.dashboard.export-all') }}" class="bg-orange-500 text-white px-4 py-2 rounded shadow hover:bg-orange-600">
                Download All Statistics (CSV)
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 max-w-6xl mb-6">
            <!-- Artworks Sold -->
            <div class="bg-white shadow rounded-lg p-6">
                <div class="flex items-center justify-between">
                    <!-- Mini Chart -->
                    <div class="w-24 h-12">
                        <canvas id="artworksSoldMiniChart"></canvas>
                    </div>
                    <!-- Text / Statistic -->
                    <div class="text-right">
                        <h3 class="text-2xl font-bold">
                            {{ $artworksSold }}
                            <span class="ml-1 {{ $artworksSold > 0 ? 'text-green-500' : 'text-red-500' }}">
                                {{ $artworksSold > 0 ? '↑' : '↓' }}
                            </span>
                        </h3>
                        <p class="text-sm text-gray-500">Artworks Sold</p>
                    </div>
                </div>
            </div>

            <!-- Clients This Month -->
            <div class="bg-white shadow rounded-lg p-6">
                <div class="flex items-center justify-between">
                    <!-- Mini Chart -->
                    <div class="w-24 h-12">
                        <canvas id="clientsMiniChart"></canvas>
                    </div>
                    <!-- Text / Statistic -->
                    <div class="text-right">
                        <h3 class="text-2xl font-bold">
                            {{ $clientsThisMonth }}
                            <span class="ml-1 {{ $clientsThisMonth > 0 ? 'text-green-500' : 'text-red-500' }}">
                                {{ $clientsThisMonth > 0 ? '↑' : '↓' }}
                            </span>
                        </h3>
                        <p class="text-sm text-gray-500">Clients This Month</p>
                    </div>
                </div>
            </div>

            <!-- Pending Payout Section -->
            <div class="bg-white shadow rounded-lg p-6 max-w-3xl">
                <h2 class="text-lg font-semibold mb-4">Pending Payout</h2>
                <span class="text-green-600 text-2xl">₱</span><span class="text-2xl font-bold text-green-600">{{ number_format($pendingPayouts, 2) }}</span>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 max-w-6xl max-h-[600px]">
            <!-- Revenue Statistics -->
            <div class="bg-white rounded-lg shadow p-6 w-full">
                <!-- Header -->
                <h2 class="text-sm text-gray-500">Statistics</h2>
                <h3 class="text-xl font-semibold mb-2">Revenue This Month</h3>
                <!-- Big Number + Growth Indicator -->
                <div class="flex items-center space-x-2 mb-4">
                    <span class="text-3xl">₱</span><span class="text-3xl font-bold">{{ number_format($revenueTotals->last() ?? 0, 2) }}</span>
                    <span class="flex items-center {{ $revenueTotals->last() >= ($revenueTotals->slice(-2, 1)->first() ?? 0) ? 'text-green-500' : 'text-red-500' }} text-sm">
                        @if ($revenueTotals->last() >= ($revenueTotals->slice(-2, 1)->first() ?? 0))
                            <svg class="w-4 h-4 mr-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3.293 9.293a1 1 0 011.414 0L10 14.586l5.293-5.293a1 1 0 011.414 1.414l-6 6a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        @else
                            <svg class="w-4 h-4 mr-0.5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 9.293a1 1 0 00-1.414 0L10 14.586l-5.293-5.293a1 1 0 00-1.414 1.414l6 6a1 1 0 001.414 0l6-6a1 1 0 000-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        @endif
                        {{ round((($revenueTotals->last() - ($revenueTotals->slice(-2, 1)->first() ?? 0)) / max(($revenueTotals->slice(-2, 1)->first() ?? 1), 1)) * 100, 2) }}%
                    </span>
                </div>

                <!-- Chart Container -->
                <div class="relative w-full h-fit">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>

            <!-- Commissions Chart -->
            <div class="bg-white shadow rounded-lg p-6 max-h-[400px] max-w-6xl">
                <h2 class="text-lg font-semibold mb-4">Commissions Overview</h2>
                <div class="relative mx-auto" style="width: 200px; height: 200px;">
                    <canvas id="commissionsChart"></canvas>
                    <!-- Center Text Overlay -->
                    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-center">
                        <p class="text-2xl font-bold">{{ $commissionsCounts->sum() }}</p>
                        <p class="text-sm text-gray-400">Total Commissions</p>
                    </div>
                </div>
                <!-- Legend -->
                <div class="mt-6 space-y-2">
                    @foreach ($commissionsLabels as $index => $label)
                        <div class="flex items-center">
                            <span class="inline-block w-3 h-3 rounded-full mr-2"
                                style="background-color: {{ ['#6366F1', '#818CF8', '#A5B4FC', '#E0E7FF'][$index % 4] }}">
                            </span>
                            <span class="text-sm text-gray-700">{{ $label }}</span>
                            <span class="ml-auto text-sm text-gray-500">{{ $commissionsCounts[$index] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Orders Chart -->
            <div class="bg-white shadow rounded-lg p-6 max-h-[400px] max-6-3xl">
                <h2 class="text-lg font-semibold mb-4">Orders Overview</h2>
                <div class="relative mx-auto" style="width: 200px; height: 200px;">
                    <canvas id="ordersChart"></canvas>
                    <!-- Center Text Overlay -->
                    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-center">
                        <p class="text-2xl font-bold">{{ $ordersCounts->sum() }}</p>
                        <p class="text-sm text-gray-400">Total Orders</p>
                    </div>
                </div>
                <!-- Legend -->
                <div class="mt-6 space-y-2">
                    @foreach ($ordersLabels as $index => $label)
                        <div class="flex items-center">
                            <span class="inline-block w-3 h-3 rounded-full mr-2"
                                style="background-color: {{ ['#22C55E', '#86EFAC', '#D1FAE5', '#F0FDF4'][$index % 4] }}">
                            </span>
                            <span class="text-sm text-gray-700">{{ $label }}</span>
                            <span class="ml-auto text-sm text-gray-500">{{ $ordersCounts[$index] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Reviews Chart -->
            <div class="bg-white shadow rounded-lg p-6 max-h-[400px] max-w-3xl">
                <h2 class="text-lg font-semibold mb-4">User Reviews</h2>
                <canvas id="reviewsChart"></canvas>
            </div>
        </div>

        <!-- Chart.js Scripts -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Commissions Chart (By Status)
                const commissionsCtx = document.getElementById('commissionsChart').getContext('2d');
                const commissionsLabels = @json($commissionsLabels);
                const commissionsCounts = @json($commissionsCounts);

                new Chart(commissionsCtx, {
                    type: 'doughnut',
                    data: {
                        labels: commissionsLabels,
                        datasets: [{
                            data: commissionsCounts,
                            backgroundColor: ['#6366F1', '#818CF8', '#A5B4FC', '#E0E7FF'],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        cutout: '70%',
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        }
                    }
                });

                // Orders Chart (By Status)
                const ordersCtx = document.getElementById('ordersChart').getContext('2d');
                const ordersLabels = @json($ordersLabels);
                const ordersCounts = @json($ordersCounts);

                new Chart(ordersCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ordersLabels,
                        datasets: [{
                            data: ordersCounts,
                            backgroundColor: ['#22C55E', '#86EFAC', '#D1FAE5', '#F0FDF4'],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        cutout: '70%',
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        }
                    }
                });

                // Revenue Chart
                const revenueCtx = document.getElementById('revenueChart').getContext('2d');
                const revenueLabels = @json($revenueLabels);
                const revenueTotals = @json($revenueTotals);

                new Chart(revenueCtx, {
                    type: 'line',
                    data: {
                        labels: revenueLabels,
                        datasets: [{
                            label: 'Revenue',
                            data: revenueTotals,
                            borderColor: '#f59e0b',
                            backgroundColor: 'rgba(245,158,11,0.2)',
                            borderWidth: 2,
                            tension: 0.4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        }
                    }
                });

                // Reviews Chart
                const reviewsCtx = document.getElementById('reviewsChart').getContext('2d');
                const reviewsLabels = @json($reviewsLabels);
                const reviewsCounts = @json($reviewsCounts);

                new Chart(reviewsCtx, {
                    type: 'bar',
                    data: {
                        labels: reviewsLabels,
                        datasets: [{
                            label: 'Reviews',
                            data: reviewsCounts,
                            backgroundColor: 'rgba(239,68,68,0.2)',
                            borderColor: '#ef4444',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        }
                    }
                });

                // Artworks Sold Chart
                const artworksSoldCtx = document.getElementById('artworksSoldChart').getContext('2d');
                const artworksSoldLabels = @json($artworksSoldLabels);
                const artworksSoldCounts = @json($artworksSoldCounts);

                new Chart(artworksSoldCtx, {
                    type: 'line',
                    data: {
                        labels: artworksSoldLabels,
                        datasets: [{
                            label: 'Artworks Sold',
                            data: artworksSoldCounts,
                            borderColor: '#6366f1',
                            backgroundColor: 'rgba(99,102,241,0.2)',
                            borderWidth: 2,
                            tension: 0.4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        }
                    }
                });

                // Artworks Sold Mini Chart
                const artworksSoldMiniCtx = document.getElementById('artworksSoldMiniChart').getContext('2d');
                const artworksSoldLabels = @json($artworksSoldLabels);
                const artworksSoldCounts = @json($artworksSoldCounts);

                new Chart(artworksSoldMiniCtx, {
                    type: 'line',
                    data: {
                        labels: artworksSoldLabels,
                        datasets: [{
                            data: artworksSoldCounts,
                            borderColor: '#6366f1',
                            backgroundColor: 'rgba(99,102,241,0.2)',
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

                // Clients Mini Chart
                const clientsMiniCtx = document.getElementById('clientsMiniChart').getContext('2d');
                new Chart(clientsMiniCtx, {
                    type: 'line',
                    data: {
                        labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'], // Example labels
                        datasets: [{
                            data: [5, 10, 15, 20], // Example data
                            borderColor: '#22c55e',
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
            });
        </script>
    </div>
</x-artist-layout>
