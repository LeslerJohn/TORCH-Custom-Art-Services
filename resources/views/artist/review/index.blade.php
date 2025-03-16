<x-artist-layout>
    <div class="max-w-6xl px-6 py-8 mt-6">
        <h1 class="text-3xl font-bold text-center mb-6">Your Reviews</h1>

        <!-- Order Reviews Section -->
        <div class="bg-white p-6 mb-4">
            <h2 class="text-2xl font-semibold mb-4">Order Reviews</h2>

            @if($order_reviews->isEmpty())
                <p class="text-gray-500">No order reviews available.</p>
            @else
                <div class="grid md:grid-cols-2 gap-6">
                    @foreach($order_reviews as $review)
                        <div class="bg-gray-100 rounded-lg p-4 shadow-md">
                            <div class="flex items-center gap-4 mb-2">
                                <img src="{{ asset('images/default-user.jpg') }}" alt="Client Avatar" class="w-12 h-12 rounded-full border">
                                <div>
                                    <h3 class="font-semibold">{{ $review->order->client->name }}</h3>
                                    <small class="text-gray-500">{{ $review->created_at->format('d M Y') }}</small>
                                </div>
                            </div>
                            <div class="flex items-center gap-1 text-yellow-500">
                                @for ($i = 0; $i < $review->rating; $i++)
                                    <svg class="w-5 h-5 text-yellow-400" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M13.849 4.22c-.684-1.626-3.014-1.626-3.698 0L8.397 8.387l-4.552.361c-1.775.14-2.495 2.331-1.142 3.477l3.468 2.937-1.06 4.392c-.413 1.713 1.472 3.067 2.992 2.149L12 19.35l3.897 2.354c1.52.918 3.405-.436 2.992-2.15l-1.06-4.39 3.468-2.938c1.353-1.146.633-3.336-1.142-3.477l-4.552-.36-1.754-4.17Z" />
                                    </svg>
                                @endfor
                                @for ($i = $review->rating; $i < 5; $i++)
                                    <svg class="w-5 h-5 text-gray-300" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M13.849 4.22c-.684-1.626-3.014-1.626-3.698 0L8.397 8.387l-4.552.361c-1.775.14-2.495 2.331-1.142 3.477l3.468 2.937-1.06 4.392c-.413 1.713 1.472 3.067 2.992 2.149L12 19.35l3.897 2.354c1.52.918 3.405-.436 2.992-2.15l-1.06-4.39 3.468-2.938c1.353-1.146.633-3.336-1.142-3.477l-4.552-.36-1.754-4.17Z" />
                                    </svg>
                                @endfor
                            </div>
                            <p class="mt-2 text-gray-700">{{ $review->comment }}</p>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Commission Reviews Section -->
        <div class="bg-white p-6">
            <h2 class="text-2xl font-semibold mb-4">Commission Reviews</h2>

            @if($commission_reviews->isEmpty())
                <p class="text-gray-500">No commission reviews available.</p>
            @else
                <div class="grid md:grid-cols-2 gap-6">
                    @foreach($commission_reviews as $review)
                        <div class="bg-gray-100 rounded-lg p-4 shadow-md">
                            <div class="flex items-center gap-4 mb-2">
                                <img src="{{ asset('images/default-user.jpg') }}" alt="Client Avatar" class="w-12 h-12 rounded-full border">
                                <div>
                                    <h3 class="font-semibold">{{ $review->commission->request->client->name }}</h3>
                                    <small class="text-gray-500">{{ $review->created_at->format('d M Y') }}</small>
                                </div>
                            </div>
                            <div class="flex items-center gap-1 text-yellow-500">
                                @for ($i = 0; $i < $review->rating; $i++)
                                    <svg class="w-5 h-5 text-yellow-400" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M13.849 4.22c-.684-1.626-3.014-1.626-3.698 0L8.397 8.387l-4.552.361c-1.775.14-2.495 2.331-1.142 3.477l3.468 2.937-1.06 4.392c-.413 1.713 1.472 3.067 2.992 2.149L12 19.35l3.897 2.354c1.52.918 3.405-.436 2.992-2.15l-1.06-4.39 3.468-2.938c1.353-1.146.633-3.336-1.142-3.477l-4.552-.36-1.754-4.17Z" />
                                    </svg>
                                @endfor
                                @for ($i = $review->rating; $i < 5; $i++)
                                    <svg class="w-5 h-5 text-gray-300" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M13.849 4.22c-.684-1.626-3.014-1.626-3.698 0L8.397 8.387l-4.552.361c-1.775.14-2.495 2.331-1.142 3.477l3.468 2.937-1.06 4.392c-.413 1.713 1.472 3.067 2.992 2.149L12 19.35l3.897 2.354c1.52.918 3.405-.436 2.992-2.15l-1.06-4.39 3.468-2.938c1.353-1.146.633-3.336-1.142-3.477l-4.552-.36-1.754-4.17Z" />
                                    </svg>
                                @endfor
                            </div>
                            <p class="mt-2 text-gray-700">{{ $review->comment }}</p>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-artist-layout>
