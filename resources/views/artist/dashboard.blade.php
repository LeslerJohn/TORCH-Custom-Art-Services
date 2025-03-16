<x-artist-layout>
    <div class="container mx-auto p-4 mt-16">
        <h1 class="text-3xl font-bold mb-4">Artist Dashboard</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">

            <div class="bg-white shadow rounded p-4">
                <h2 class="text-xl font-semibold mb-2">Statistics</h2>
                <div class="space-y-2">
                    <p>Total Revenue: ₱{{ number_format($totalRevenue ?? 0, 2) }}</p>
                    <p>Total Budget: ₱{{ number_format($totalBudget ?? 0, 2) }}</p>
                    <p>Ongoing Commissions: {{ $ongoingCommissionsCount }}</p>
                    <p>Ongoing Orders: {{ $ongoingOrdersCount }}</p>
                    <p>Orders to Deliver: {{ $toDeliverCount }}</p>
                    <p>Average Review: {{ number_format($averageReview ?? 0, 1) }}</p>
                </div>
            </div>

            <div class="bg-white shadow rounded p-4">
                <h2 class="text-xl font-semibold mb-2">Ongoing Commissions</h2>
                @if ($ongoingCommissions->isNotEmpty())  <ul class="space-y-2">
                        @foreach ($ongoingCommissions as $commission)
                            <li>
                                <a href="{{ route('artist.commission.show', $commission) }}">  {{ $commission->request->service->category->name }} - {{ $commission->request->description }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p>No ongoing commissions.</p>
                @endif
            </div>

            <div class="bg-white shadow rounded p-4">
                <h2 class="text-xl font-semibold mb-2">Ongoing Orders</h2>
                @if ($ongoingOrders->isNotEmpty())
                    <ul class="space-y-2">
                        @foreach ($ongoingOrders as $order)
                            <li>
                                <a href="{{ route('artist.order.show', $order) }}">
                                    Order #{{ $order->id }} - {{ $order->created_at->format('F j, Y') }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p>No ongoing orders.</p>
                @endif
            </div>

            <div class="bg-white shadow rounded p-4">
                <h2 class="text-xl font-semibold mb-2">Recent Reviews</h2>
                @if ($recentReviews->isNotEmpty())
                <ul class="space-y-2">
                    @foreach ($recentReviews as $review)
                        <li>
                            <p>"{{ $review->comment }}"</p>
                            <p class="text-sm text-gray-500">Rating: {{ $review->rating }}</p>
                        </li>
                    @endforeach
                </ul>
                @else
                    <p>No reviews yet.</p>
                @endif
            </div>

        </div>

        <div class="mt-8">  <h2 class="text-2xl font-semibold mb-4">Milestones</h2>
            <p>You've completed {{ $completedCommissionsCount }} commissions!</p>
            {{-- Add more milestones as needed --}}
        </div>
    </div>
</x-artist-layout>
