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
            <!-- Modal Trigger -->
            <button type="button" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 mt-4 shadow-md" 
                onclick="document.getElementById('proofModal').classList.remove('hidden')">
                Mark as Delivered
            </button>

            <!-- Modal -->
            <div id="proofModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 z-40 flex items-center justify-center hidden">
                <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Upload Proof of Delivery</h2>
                    <form action="{{ route('artist.order.delivered', $order) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="space-y-4">
                            <label class="block">
                                <span class="text-gray-700">Upload up to 5 images:</span>
                                <input type="file" name="proof_images[]" accept="image/*" multiple 
                                    class="block w-full mt-1 text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer focus:outline-none focus:ring focus:ring-orange-500">
                            </label>
                            <p class="text-sm text-gray-500">You can upload up to 5 images as proof of delivery.</p>
                        </div>
                        <div class="flex justify-end mt-6">
                            <button type="button" class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400 mr-2"
                                onclick="document.getElementById('proofModal').classList.add('hidden')">
                                Cancel
                            </button>
                            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @elseif ($order->delivery->status === 'delivered')
            <div class="bg-gray-50 p-6 rounded-md mt-8 shadow-md">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Proof of Delivery</h2>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach ($order->delivery->proofs as $proof)
                        <div class="relative group">
                            <img src="{{ asset('storage/' . $proof->attachment->path) }}" alt="Proof of Delivery" 
                                class="w-full h-32 object-cover rounded-md shadow-md">
                            <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-md">
                                <a href="{{ asset('storage/' . $proof->attachment->path) }}" target="_blank" 
                                    class="text-white text-sm font-semibold underline">
                                    View Full Image
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
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
