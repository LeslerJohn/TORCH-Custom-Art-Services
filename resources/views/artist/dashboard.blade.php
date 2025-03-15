<x-artist-layout>
    <!-- Main Content Container -->
    <div class="container mx-auto p-2 sm:p-4 mt-16">
        <!-- Main Heading -->
        <h1 class="text-xl sm:text-2xl md:text-3xl font-bold mb-4">Artist Dashboard</h1>

        <!-- Grid Layout -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-2 sm:gap-4">
            <!-- Statistics Card -->
            <div class="bg-white shadow rounded p-3 sm:p-4">
                <h2 class="text-base sm:text-lg md:text-xl font-semibold mb-2">Statistics</h2>
                <div class="space-y-1 sm:space-y-2 text-xs sm:text-sm md:text-base">
                    <p>Total Revenue: ₱{{ number_format($totalRevenue ?? 0, 2) }}</p>
                    <p>Total Budget: ₱{{ number_format($totalBudget ?? 0, 2) }}</p>
                    <p>Ongoing Commissions: {{ $ongoingCommissionsCount }}</p>
                    <p>Ongoing Orders: {{ $ongoingOrdersCount }}</p>
                    <p>Orders to Deliver: {{ $toDeliverCount }}</p>
                    <p>Average Review: {{ number_format($averageReview ?? 0, 1) }}</p>
                </div>
            </div>

            <!-- Ongoing Commissions Card -->
            <div class="bg-white shadow rounded p-3 sm:p-4">
                <h2 class="text-base sm:text-lg md:text-xl font-semibold mb-2">Ongoing Commissions</h2>
                @if ($ongoingCommissions->isNotEmpty())
                <ul class="space-y-1 sm:space-y-2 text-xs sm:text-sm md:text-base">
                    @foreach ($ongoingCommissions as $commission)
                    <li class="truncate">
                        <a href="{{ route('artist.commission.show', $commission) }}">
                            {{ $commission->request->service->category->name }} - {{ $commission->request->description }}
                        </a>
                    </li>
                    @endforeach
                </ul>
                @else
                <p class="text-xs sm:text-sm md:text-base">No ongoing commissions.</p>
                @endif
            </div>

            <!-- Ongoing Orders Card -->
            <div class="bg-white shadow rounded p-3 sm:p-4">
                <h2 class="text-base sm:text-lg md:text-xl font-semibold mb-2">Ongoing Orders</h2>
                @if ($ongoingOrders->isNotEmpty())
                <ul class="space-y-1 sm:space-y-2 text-xs sm:text-sm md:text-base">
                    @foreach ($ongoingOrders as $order)
                    <li class="truncate">
                        <a href="{{ route('artist.order.show', $order) }}">
                            Order #{{ $order->id }} - {{ $order->created_at->format('F j, Y') }}
                        </a>
                    </li>
                    @endforeach
                </ul>
                @else
                <p class="text-xs sm:text-sm md:text-base">No ongoing orders.</p>
                @endif
            </div>

            <!-- Recent Reviews Card -->
            <div class="bg-white shadow rounded p-3 sm:p-4">
                <h2 class="text-base sm:text-lg md:text-xl font-semibold mb-2">Recent Reviews</h2>
                @if ($recentReviews->isNotEmpty())
                <ul class="space-y-1 sm:space-y-2 text-xs sm:text-sm md:text-base">
                    @foreach ($recentReviews as $review)
                    <li>
                        <p>"{{ $review->comment }}"</p>
                        <p class="text-xs sm:text-sm text-gray-500">Rating: {{ $review->rating }}</p>
                    </li>
                    @endforeach
                </ul>
                @else
                <p class="text-xs sm:text-sm md:text-base">No reviews yet.</p>
                @endif
            </div>
        </div>

        <!-- Milestones Section -->
        <div class="mt-6 sm:mt-8">
            <h2 class="text-lg sm:text-xl md:text-2xl font-semibold mb-2 sm:mb-4">Milestones</h2>
            <p class="text-xs sm:text-sm md:text-base">You've completed {{ $completedCommissionsCount }} commissions!</p>
            {{-- Add more milestones as needed --}}
        </div>
    </div>
</x-artist-layout>