<x-artist-layout>
    <div class="max-w-4xl mt-16 p-6 bg-white shadow-lg rounded-lg">
        <!-- Order Info -->
        <div class="mb-4">
            <h1 class="text-2xl font-bold mb-4 text-wrap break-words text-gray-800 text-start md:text-md">Order #{{ $order->id }}</h1>
            <h2 class="text-xl font-bold text-gray-700">Total: ₱{{ number_format($order->total, 2) }}</h2>
        </div>

        <!-- Client Info and Delivery Status -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <!-- Client Info -->
            <div class="bg-gray-50 p-4 rounded-md shadow-md">
                <h2 class="text-lg font-semibold text-gray-800">Client Information</h2>
                <p><strong>Name:</strong> {{ $order->client->user->name }}</p>
                <p><strong>Contact:</strong> +63 {{ $order->client->user->phone_number }}</p>
                <p><strong>Address:</strong>
                    {{ $order->delivery->address->house_number }},
                    {{ $order->delivery->address->street }},
                    {{ $order->delivery->address->barangay }}
                </p>
            </div>

            <!-- Delivery Status -->
            <div class="bg-gray-50 p-4 rounded-md shadow-md">
                <h2 class="text-lg font-semibold text-gray-800">Delivery Details</h2>
                <p class="text-lg font-bold text-gray-700">Status: {{ ucfirst($order->delivery->status ?? 'Pending') }}</p>
                <p><strong>Expected Delivery Date:</strong>
                    {{ $order->delivery->expected_delivery ? \Carbon\Carbon::parse($order->delivery->expected_delivery)->format('F j, Y') : 'TBD' }}
                </p>
            </div>
        </div>

        <!-- Ordered Artworks -->
        <div class="space-y-4">
            <h2 class="text-xl font-semibold text-gray-800">Ordered Artworks</h2>
            @foreach ($order->items as $item)
                <div class="flex flex-col md:flex-row items-center gap-4 bg-gray-50 p-4 rounded-lg shadow-md">
                    <!-- Artwork Image -->
                    @php
                        $thumbnail = $item->artwork->images->first()?->attachment;
                    @endphp
                    <img src="{{ $thumbnail ? asset('storage/' . $thumbnail->path) : asset('images/default-image.jpg') }}"
                        alt="{{ $item->artwork->title }}" class="w-24 h-24 object-cover rounded-md">

                    <!-- Artwork Details -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">{{ $item->artwork->title }}</h3>
                        <p><strong>Category:</strong> {{ $item->artwork->category->name }}</p>
                        <p><strong>Artist:</strong> {{ $item->artwork->artist->user->name }}</p>
                        <p><strong>Price:</strong> ₱{{ number_format($item->price, 2) }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Delivery Actions -->
        @if ($order->delivery->status === 'pending')
            <form action="{{ route('artist.order.deliver', $order) }}" method="POST" class="mt-8">
                @csrf
                <button class="bg-orange-600 text-white px-4 py-2 rounded-lg hover:bg-orange-700 mt-4 shadow-md">
                    Deliver
                </button>
            </form>
        @elseif ($order->delivery->status === 'in-transit')
            <form action="{{ route('artist.order.delivered', $order) }}" method="POST" class="mt-8">
                @csrf
                <button class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 mt-4 shadow-md">
                    Mark as Delivered
                </button>
            </form>
        @elseif ($order->delivery->status === 'completed')
            @if ($order->reviews->isNotEmpty())
                <div class="bg-gray-50 p-4 rounded-md mt-8 shadow-md">
                    <h2 class="text-lg font-semibold text-gray-800">Review</h2>
                    @foreach ($order->reviews as $review)
                        <p><strong>Rating:</strong> {{ $review->rating }} / 5</p>
                        <p><strong>Comment:</strong> {{ $review->comment }}</p>
                    @endforeach
                </div>
            @else
                <div class="bg-gray-50 p-4 rounded-md mt-8 shadow-md">
                    <h2 class="text-lg font-semibold text-gray-800">Review</h2>
                    <p>No review yet.</p>
                </div>
            @endif
        @endif
    </div>
</x-artist-layout>
