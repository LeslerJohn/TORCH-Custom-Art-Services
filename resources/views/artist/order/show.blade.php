<x-artist-layout>
    <div class="max-w-5xl mx-auto py-4 mt-8 sm:py-8 px-4">
        <!-- Back to Orders Link -->
        <a href="{{ route('artist.order.index') }}" class="inline-flex items-center text-gray-600 hover:text-gray-900 transition-colors mt-4">
            <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m12 19-7-7 7-7"></path>
                <path d="M19 12H5"></path>
            </svg>
            <span class="font-medium">Back to Orders</span>
        </a>

        <!-- Order Header -->
        <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 mb-4 sm:mb-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
                <div>
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Order #{{ $order->id }}</h1>
                    <p class="text-sm text-gray-500 mt-1">Placed on {{ \Carbon\Carbon::parse($order->created_at)->format('F j, Y') }}</p>
                </div>
                <div class="mt-3 sm:mt-0">
                    <span class="text-xl sm:text-2xl font-bold text-indigo-600">₱{{ number_format($order->total, 2) }}</span>
                </div>
            </div>
        </div>

        <!-- Client Info and Delivery Status -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6 mb-4 sm:mb-6">
            <!-- Client Information -->
            <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6">
                <h2 class="text-base sm:text-lg font-semibold mb-3 sm:mb-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-500" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                    </svg>
                    Client Information
                </h2>
                <div class="space-y-2 sm:space-y-3 text-sm sm:text-base text-gray-700">
                    <div class="flex flex-col sm:flex-row">
                        <span class="font-medium sm:w-24">Name:</span>
                        <span class="mt-1 sm:mt-0">{{ $order->client->user->name }}</span>
                    </div>
                    <div class="flex flex-col sm:flex-row">
                        <span class="font-medium sm:w-24">Contact:</span>
                        <span class="mt-1 sm:mt-0">+63 {{ $order->client->user->phone_number }}</span>
                    </div>
                    <div class="flex flex-col sm:flex-row">
                        <span class="font-medium sm:w-24">Address:</span>
                        <span class="mt-1 sm:mt-0">
                            {{ $order->delivery->address->house_number }},
                            {{ $order->delivery->address->street }},
                            {{ $order->delivery->address->barangay }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Delivery Status -->
            <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6">
                <h2 class="text-base sm:text-lg font-semibold mb-3 sm:mb-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 h-5 w-5 mr-2 text-indigo-500">
                        <path d="M3.375 4.5C2.339 4.5 1.5 5.34 1.5 6.375V13.5h12V6.375c0-1.036-.84-1.875-1.875-1.875h-8.25ZM13.5 15h-12v2.625c0 1.035.84 1.875 1.875 1.875h.375a3 3 0 1 1 6 0h3a.75.75 0 0 0 .75-.75V15Z" />
                        <path d="M8.25 19.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0ZM15.75 6.75a.75.75 0 0 0-.75.75v11.25c0 .087.015.17.042.248a3 3 0 0 1 5.958.464c.853-.175 1.522-.935 1.464-1.883a18.659 18.659 0 0 0-3.732-10.104 1.837 1.837 0 0 0-1.47-.725H15.75Z" />
                        <path d="M19.5 19.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0Z" />
                    </svg>
                    Delivery Details
                </h2>
                <div class="space-y-2 sm:space-y-3 text-sm sm:text-base">
                    @php
                    $statusClass = [
                        'pending' => 'bg-amber-100 text-amber-800',
                        'in-transit' => 'bg-blue-100 text-blue-800',
                        'delivered' => 'bg-green-100 text-green-800',
                        'completed' => 'bg-green-100 text-green-800',
                        'hold' => 'bg-red-100 text-red-800',
                        'cancelled' => 'bg-gray-100 text-gray-800',
                        'returned' => 'bg-purple-100 text-purple-800'
                    ][$order->delivery->status ?? 'pending'];
                    @endphp
                    <div class="flex flex-col sm:flex-row sm:items-center">
                        <span class="font-medium text-gray-700 sm:w-24">Status:</span>
                        <span class="mt-1 sm:mt-0 px-3 py-1 rounded-full text-sm font-medium inline-block {{ $statusClass }}">
                            {{ ucfirst($order->delivery->status ?? 'Pending') }}
                        </span>
                    </div>
                    <div class="flex flex-col sm:flex-row text-gray-700">
                        <span class="font-medium sm:w-24">Expected:</span>
                        <span class="mt-1 sm:mt-0">
                            {{ $order->delivery->expected_delivery ? \Carbon\Carbon::parse($order->delivery->expected_delivery)->format('F j, Y') : 'To be determined' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ordered Artworks -->
        <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 mb-4 sm:mb-6">
            <h2 class="text-base sm:text-lg font-semibold mb-3 sm:mb-4 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-500" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                </svg>
                Ordered Artworks
            </h2>
            <div class="space-y-3 sm:space-y-4">
                @foreach ($order->items as $item)
                <div class="flex flex-col sm:flex-row items-center gap-3 sm:gap-4 p-3 sm:p-4 border border-gray-100 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                    <!-- Artwork Image -->
                    @php
                    $thumbnail = $item->artwork->images->first()?->attachment;
                    @endphp
                    <img src="{{ $thumbnail ? asset('storage/' . $thumbnail->path) : asset('images/default-image.jpg') }}"
                        alt="{{ $item->artwork->title }}" class="w-full sm:w-24 h-36 sm:h-24 object-cover rounded-lg shadow-sm">

                    <!-- Artwork Details -->
                    <div class="flex-1 w-full text-center sm:text-left mt-2 sm:mt-0 sm:ml-2">
                        <h3 class="text-base sm:text-lg font-semibold text-gray-800">{{ $item->artwork->title }}</h3>
                        <div class="grid grid-cols-1 gap-1 text-gray-600 text-sm mt-1">
                            <p><span class="font-medium">Category:</span> {{ $item->artwork->category->name }}</p>
                            <p><span class="font-medium">Artist:</span> {{ $item->artwork->artist->user->name }}</p>
                            <p><span class="font-medium">Price:</span> ₱{{ number_format($item->price, 2) }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Delivery Actions -->
        <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6">
            @if ($order->delivery->status === 'pending')
            <form action="{{ route('artist.order.deliver', $order) }}" method="POST">
                @csrf
                <button class="w-full sm:w-auto bg-indigo-600 hover:bg-indigo-700 text-white px-4 sm:px-6 py-2 sm:py-3 rounded-lg font-medium transition duration-200 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 h-5 w-5 mr-2">
                        <path d="M3.375 4.5C2.339 4.5 1.5 5.34 1.5 6.375V13.5h12V6.375c0-1.036-.84-1.875-1.875-1.875h-8.25ZM13.5 15h-12v2.625c0 1.035.84 1.875 1.875 1.875h.375a3 3 0 1 1 6 0h3a.75.75 0 0 0 .75-.75V15Z" />
                        <path d="M8.25 19.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0ZM15.75 6.75a.75.75 0 0 0-.75.75v11.25c0 .087.015.17.042.248a3 3 0 0 1 5.958.464c.853-.175 1.522-.935 1.464-1.883a18.659 18.659 0 0 0-3.732-10.104 1.837 1.837 0 0 0-1.47-.725H15.75Z" />
                        <path d="M19.5 19.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0Z" />
                    </svg>
                    Deliver Order
                </button>
            </form>
            @elseif ($order->delivery->status === 'in-transit')
            <!-- Modal Trigger -->
            <button type="button" class="w-full sm:w-auto bg-green-600 hover:bg-green-700 text-white px-4 sm:px-6 py-2 sm:py-3 rounded-lg font-medium transition duration-200 flex items-center justify-center"
                onclick="document.getElementById('proofModal').classList.remove('hidden')">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
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
            @elseif ($order->delivery->status === 'hold')
            <div class="bg-gray-50 p-3 sm:p-4 rounded-lg text-gray-500 italic text-sm sm:text-base">
                The order is currently on hold.
            </div>
            @elseif ($order->delivery->status === 'completed')
            <div>
                <h2 class="text-base sm:text-lg font-semibold mb-3 sm:mb-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-500" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                    Customer Review
                </h2>
                @if ($order->reviews->isNotEmpty())
                @foreach ($order->reviews as $review)
                <div class="bg-gray-50 p-3 sm:p-4 rounded-lg">
                    <div class="flex items-center mb-2">
                        <span class="font-medium mr-2">Rating:</span>
                        <div class="flex text-amber-400">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <=$review->rating)
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 sm:h-5 w-4 sm:w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 sm:h-5 w-4 sm:w-5 text-gray-300" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                @endif
                                @endfor
                        </div>
                    </div>
                    <div>
                        <p class="font-medium">Comment:</p>
                        <p class="text-gray-700 mt-1 text-sm sm:text-base">{{ $review->comment }}</p>
                    </div>
                </div>
                @endforeach
                @else
                <div class="bg-gray-50 p-3 sm:p-4 rounded-lg text-gray-500 italic text-sm sm:text-base">
                    No review has been submitted yet.
                </div>
                @endif
            </div>
            @endif
        </div>
    </div>
</x-artist-layout>