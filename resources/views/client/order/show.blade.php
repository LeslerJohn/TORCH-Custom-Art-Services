<x-app-layout>
    <div class="max-w-5xl mt-10 mx-auto bg-white p-6 rounded-lg shadow-lg relative">
        <!-- Status on Top Right -->
        <div class="absolute top-6 right-6">
            <span
                class="px-4 py-2 rounded-full text-white 
                {{ $order->delivery->status == 'completed' ? 'bg-green-500' : ($order->delivery->status == 'in-transit' ? 'bg-yellow-500' : 'bg-red-500') }}">
                {{ ucfirst($order->delivery->status ?? 'Pending') }}
            </span>
        </div>

        <!-- Expected Delivery & Shipping Info -->
        <div class="mb-6">
            <p class="text-2xl font-bold mb-2">
                @if ($order->delivery->status == 'pending')
                    The artist is preparing your order.
                @elseif ($order->delivery->status == 'in-transit')
                    Your artwork is on the way.
                @elseif ($order->delivery->status == 'completed')
                    Your order is completed.
                @else
                    Cancelled
                @endif
            </p>
            <p class="text-gray-600">Expected Delivery Date:
                <strong
                    class="text-blue-500">{{ optional($order->delivery)->expected_delivery ? \Carbon\Carbon::parse($order->delivery->expected_delivery)->format('F j, Y') : 'TBD' }}</strong>
            </p>
            <p class="text-gray-600">Shipping to:
                <strong>{{ $order->delivery->address->house_number }},
                    {{ $order->delivery->address->street }},
                    {{ $order->delivery->address->barangay }}</strong>
            </p>
        </div>

        <!-- Shipping Progress -->
        <div class="mb-6">
            <h2 class="text-xl font-semibold mb-2">Shipping Progress</h2>
            <div class="w-full bg-gray-200 rounded-full h-2.5 mb-4">
                <div class="bg-blue-500 h-2.5 rounded-full"
                    style="width: 
                    {{ $order->delivery->status == 'completed' ? '100%' : ($order->delivery->status == 'in-transit' ? '50%' : '10%') }}">
                </div>
            </div>
            <div class="flex justify-between text-sm text-gray-600">
                <span>Pending</span>
                <span>In-Transit</span>
                <span>Completed</span>
            </div>
        </div>

        <!-- Artist and Ordered Items -->
        <div class="mb-6">
            <h2 class="text-xl font-semibold mb-2">Your Order from
                {{ $order->items->first()->artwork->artist->user->name }}</h2>
            <div class="space-y-4">
                @foreach ($order->items as $item)
                    <div class="flex gap-4 bg-white p-4 rounded-lg shadow-lg border border-gray-200 w-full max-w-md">
                        <!-- Artwork Image -->
                        @php
                            $thumbnail = $item->artwork->images->first()?->attachment;
                        @endphp
                        <img src="{{ $thumbnail ? asset('storage/' . $thumbnail->path) : asset('images/default-image.jpg') }}"
                            alt="{{ $item->artwork->title }}" class="w-48 h-32 object-cover rounded-md">

                        <!-- Artwork Details -->
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold"><strong>Title:</strong> {{ $item->artwork->title }}</h3>
                            <p><strong>Category:</strong> {{ $item->artwork->category->name }}</p>
                            <p><strong>Price:</strong> ₱{{ number_format($item->price, 2) }}</p>
                            <p><strong>Size:</strong> {{$item->artwork->width}} x {{$item->artwork->height}} {{$item->artwork->unit}}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Support Center & Order Details -->
        <div class="mb-6">
            <h2 class="text-xl font-semibold mb-2">Support Center</h2>
            <p class="text-gray-600">Having issues with your order?
                <a href="#" class="text-blue-500 underline">Contact Support</a>
            </p>
        </div>

        <div class="mb-6">
            <h2 class="text-xl font-semibold mb-2">Order Details</h2>
            <p><strong>Order ID:</strong> #{{ $order->id }}</p>
            <p><strong>Total Price:</strong> ₱{{ number_format($order->total, 2) }}</p>
        </div>

        <!-- Buttons -->
        <div class="flex justify-end gap-4">
            @if ($order->delivery->status == 'pending')
                <form action="{{ route('client.order.destroy', $order) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-lg shadow">Cancel
                        Order</button>
                </form>
            @elseif ($order->delivery->status == 'completed')
                <!-- Modal toggle -->
                @if (!$order->reviews->count())
                    <button data-modal-target="crud-modal" data-modal-toggle="crud-modal"
                        class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                        type="button">
                        Review
                    </button>
                @else
                    <p class="text-green-500">You have already reviewed this order.</p>
                @endif
            @endif
        </div>

        <!-- Main modal -->
        <div id="crud-modal" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                    <!-- Modal header -->
                    <div
                        class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Leave a review
                        </h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-toggle="crud-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <form action="{{route('client.review.order', $order)}}" method="POST" class="p-4 md:p-5">
                        @csrf
                        <div class="grid gap-4 mb-4 grid-cols-2">
                            <div class="mb-4" x-data="{ rating: 0 }">
                                <input type="hidden" name="rating" x-model="rating">
                    
                                <div class="flex items-center">
                                    <template x-for="star in 5">
                                        <svg @click="rating = star" :class="rating >= star ? 'text-yellow-300' : 'text-gray-300'"
                                            class="w-8 h-8 cursor-pointer transition duration-200" fill="currentColor"
                                            viewBox="0 0 22 20" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z">
                                            </path>
                                        </svg>
                                    </template>
                                </div>
                    
                                <p class="mt-2 text-lg">Selected Rating: <span x-text="rating"></span>/5</p>
                            </div>
                            <div class="col-span-2">
                                <label for="comment"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Comment</label>
                                <textarea name="comment" id="comment" rows="4"
                                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Write your review here"></textarea>
                            </div>
                        </div>
                        <button type="submit"
                            class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Submit Review
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
