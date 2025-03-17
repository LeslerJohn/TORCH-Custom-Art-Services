<x-app-layout>
    <div class="max-w-5xl mt-4 md:mt-10 mx-4 md:mx-auto bg-white p-4 md:p-6 rounded-lg shadow-lg relative">
        <!-- Back Button -->
        <div class="mb-4 pt-4">
            <button onclick="window.history.back()"
                class="flex items-center justify-center w-10 h-10 rounded-full bg-gray-200 hover:bg-gray-300 transition-colors">
                <svg class="w-6 h-6 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 12h14M5 12l4-4m-4 4 4 4" />
                </svg>
            </button>
        </div>

        <!-- Status on Top Right -->
        <div class="absolute top-10 right-2 md:top-10 md:right-6">
            <span
                class="px-3 py-1 md:px-4 md:py-2 rounded-full text-white text-sm md:text-base
            {{ $order->delivery->status == 'completed' ? 'bg-green-500' : ($order->delivery->status == 'in-transit' ? 'bg-yellow-500' : ($order->delivery->status == 'hold' ? 'bg-orange-500' : ($order->delivery->status == 'returned' ? 'bg-purple-500' : 'bg-red-500'))) }}">
                {{ ucfirst($order->delivery->status ?? 'Pending') }}
            </span>
        </div>

        <!-- Expected Delivery & Shipping Info -->
        <div class="mb-6">
            <!-- Status Heading -->
            <div class="flex items-center mb-6">
                <div class="mr-3">
                    @if ($order->delivery->status == 'pending')
                    <div class="bg-blue-100 p-2 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#5257ff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clock-fading">
                            <path d="M12 2a10 10 0 0 1 7.38 16.75" />
                            <path d="M12 6v6l4 2" />
                            <path d="M2.5 8.875a10 10 0 0 0-.5 3" />
                            <path d="M2.83 16a10 10 0 0 0 2.43 3.4" />
                            <path d="M4.636 5.235a10 10 0 0 1 .891-.857" />
                            <path d="M8.644 21.42a10 10 0 0 0 7.631-.38" />
                        </svg>
                    </div>
                    @elseif ($order->delivery->status == 'in-transit')
                    <div class="bg-blue-100 p-2 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#5257ff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-package">
                            <path d="M11 21.73a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73z" />
                            <path d="M12 22V12" />
                            <polyline points="3.29 7 12 12 20.71 7" />
                            <path d="m7.5 4.27 9 5.15" />
                        </svg>
                    </div>
                    @elseif ($order->delivery->status == 'completed')
                    <div class="bg-green-100 p-2 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#039900" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-check-big">
                            <path d="M21.801 10A10 10 0 1 1 17 3.335" />
                            <path d="m9 11 3 3L22 4" />
                        </svg>
                    </div>
                    @else
                    <div class="bg-red-100 p-2 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-red-500">
                            <path d="M18 6 6 18" />
                            <path d="m6 6 12 12" />
                        </svg>
                    </div>
                    @endif
                </div>
                <h2 class="text-xl md:text-2xl font-bold text-gray-800 status-title">
                    @if ($order->delivery->status == 'pending')
                    The artist is preparing your order
                    @elseif ($order->delivery->status == 'in-transit')
                    Your artwork is on the way
                    @elseif ($order->delivery->status == 'completed')
                    Your order is completed
                    @else
                    Cancelled
                    @endif
                </h2>
            </div>

            <div class="mb-6">
                <h2 class="text-lg md:text-xl font-semibold mb-6">Shipping Progress</h2>
                <div class="flex items-center justify-between relative">
                    <!-- Progress Line -->
                    <div class="absolute top-4 left-4 right-4 h-2 bg-gray-200 z-0 rounded-full overflow-hidden">
                        <div class="h-2 bg-blue-500 rounded-full progress-line" style="--progress-width: 
            {{ $order->delivery->status == 'pending' ? '0%' : 
               ($order->delivery->status == 'in-transit' ? '50%' : '100%') }}">
                        </div>
                    </div>

                    <!-- Pending -->
                    <div class="flex flex-col items-center relative z-10">
                        <div class="w-10 h-10 flex items-center justify-center rounded-full 
            {{ $order->delivery->status == 'pending' ? 'bg-blue-500 shadow-lg shadow-blue-200' : 
               ($order->delivery->status == 'in-transit' || $order->delivery->status == 'completed' ? 'bg-blue-500 shadow-lg shadow-blue-200' : 'bg-gray-300') }} icon-animation">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clock-fading">
                                <path d="M12 2a10 10 0 0 1 7.38 16.75" />
                                <path d="M12 6v6l4 2" />
                                <path d="M2.5 8.875a10 10 0 0 0-.5 3" />
                                <path d="M2.83 16a10 10 0 0 0 2.43 3.4" />
                                <path d="M4.636 5.235a10 10 0 0 1 .891-.857" />
                                <path d="M8.644 21.42a10 10 0 0 0 7.631-.38" />
                            </svg>
                        </div>
                        <p class="text-sm font-medium mt-2 text-animation {{ $order->delivery->status == 'pending' || $order->delivery->status == 'in-transit' || $order->delivery->status == 'completed' ? 'text-blue-500' : 'text-gray-400' }}">Pending</p>
                    </div>

                    <!-- In-Transit -->
                    <div class="flex flex-col items-center relative z-10">
                        <div class="w-10 h-10 flex items-center justify-center rounded-full 
            {{ $order->delivery->status == 'in-transit' || $order->delivery->status == 'completed' ? 'bg-blue-500 shadow-lg shadow-blue-200' : 'bg-gray-300' }} icon-animation-delay-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-package">
                                <path d="M11 21.73a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73z" />
                                <path d="M12 22V12" />
                                <polyline points="3.29 7 12 12 20.71 7" />
                                <path d="m7.5 4.27 9 5.15" />
                            </svg>
                        </div>
                        <p class="text-sm font-medium mt-2 text-animation-delay-1 {{ $order->delivery->status == 'in-transit' || $order->delivery->status == 'completed' ? 'text-blue-500' : 'text-gray-400' }}">In-Transit</p>
                    </div>

                    <!-- Completed -->
                    <div class="flex flex-col items-center relative z-10">
                        <div class="w-10 h-10 flex items-center justify-center rounded-full 
            {{ $order->delivery->status == 'completed' ? 'bg-green-500 shadow-lg shadow-green-200' : 'bg-gray-300' }} icon-animation-delay-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-check-big">
                                <path d="M21.801 10A10 10 0 1 1 17 3.335" />
                                <path d="m9 11 3 3L22 4" />
                            </svg>
                        </div>
                        <p class="text-sm font-medium mt-2 text-animation-delay-2 {{ $order->delivery->status == 'completed' ? 'text-green-500' : 'text-gray-400' }}">Completed</p>
                    </div>
                </div>
            </div>
            <style>
                /* Progress Line Animation */
                @keyframes progress-line-animation {
                    0% {
                        width: 0%;
                    }

                    100% {
                        width: var(--progress-width);
                    }
                }

                /* Animated stripes for progress line */
                @keyframes progress-stripes {
                    0% {
                        background-position: 0 0;
                    }

                    100% {
                        background-position: 50px 0;
                    }
                }

                /* Pulse animation for active state */
                @keyframes progress-pulse {
                    0% {
                        box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.4);
                    }

                    70% {
                        box-shadow: 0 0 0 5px rgba(59, 130, 246, 0);
                    }

                    100% {
                        box-shadow: 0 0 0 0 rgba(59, 130, 246, 0);
                    }
                }

                .progress-line {
                    position: relative;
                    width: var(--progress-width);
                    animation:
                        progress-line-animation 1.5s ease-out forwards,
                        progress-pulse 2s infinite;
                    background: linear-gradient(45deg,
                            rgba(59, 130, 246, 1) 25%,
                            rgba(96, 165, 250, 1) 25%,
                            rgba(96, 165, 250, 1) 50%,
                            rgba(59, 130, 246, 1) 50%,
                            rgba(59, 130, 246, 1) 75%,
                            rgba(96, 165, 250, 1) 75%,
                            rgba(96, 165, 250, 1));
                    background-size: 25px 25px;
                    animation:
                        progress-line-animation 1.5s ease-out forwards,
                        progress-stripes 1s linear infinite,
                        progress-pulse 2s infinite;
                }

                /* Add shine effect */
                .progress-line::after {
                    content: '';
                    position: absolute;
                    top: 0;
                    left: -100%;
                    width: 50%;
                    height: 100%;
                    background: linear-gradient(90deg,
                            rgba(255, 255, 255, 0) 0%,
                            rgba(255, 255, 255, 0.4) 50%,
                            rgba(255, 255, 255, 0) 100%);
                    animation: shine 2s infinite;
                }

                @keyframes shine {
                    0% {
                        left: -100%;
                    }

                    100% {
                        left: 200%;
                    }
                }

                /* Icon Animation */
                @keyframes icon-pulse {
                    0% {
                        transform: scale(0);
                        opacity: 0;
                    }

                    60% {
                        transform: scale(1.1);
                        opacity: 1;
                    }

                    100% {
                        transform: scale(1);
                        opacity: 1;
                    }
                }

                /* Text Animation */
                @keyframes text-fade-in {
                    0% {
                        opacity: 0;
                        transform: translateY(5px);
                    }

                    100% {
                        opacity: 1;
                        transform: translateY(0);
                    }
                }

                .icon-animation {
                    animation: icon-pulse 0.6s ease-in-out forwards;
                    opacity: 0;
                    /* Start invisible */
                }

                .icon-animation-delay-1 {
                    animation: icon-pulse 0.6s ease-in-out 0.2s forwards;
                    opacity: 0;
                    /* Start invisible */
                }

                .icon-animation-delay-2 {
                    animation: icon-pulse 0.6s ease-in-out 0.4s forwards;
                    opacity: 0;
                    /* Start invisible */
                }

                .text-animation {
                    animation: text-fade-in 0.5s ease-in-out 0.3s forwards;
                    opacity: 0;
                    /* Start invisible */
                }

                .text-animation-delay-1 {
                    animation: text-fade-in 0.5s ease-in-out 0.5s forwards;
                    opacity: 0;
                    /* Start invisible */
                }

                .text-animation-delay-2 {
                    animation: text-fade-in 0.5s ease-in-out 0.7s forwards;
                    opacity: 0;
                    /* Start invisible */
                }
            </style>

            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="font-medium text-gray-700 mb-2">Delivery Information</h3>
                <div class="space-y-2">
                    <div class="flex items-start">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-400 mr-2 mt-1">
                            <path d="M22 12h-4l-3 9L9 3l-3 9H2" />
                        </svg>
                        <div>
                            <p class="text-xs text-gray-500">Expected Delivery</p>
                            <p class="font-medium">{{ optional($order->delivery)->expected_delivery ? \Carbon\Carbon::parse($order->delivery->expected_delivery)->format('F j, Y') : 'TBD' }}</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-400 mr-2 mt-1">
                            <path d="M19 12H5" />
                            <path d="M12 19V5" />
                            <rect width="20" height="20" x="2" y="2" rx="5" />
                        </svg>
                        <div>
                            <p class="text-xs text-gray-500">Shipping Address</p>
                            <p class="font-medium">{{ $order->delivery->address->house_number }}, {{ $order->delivery->address->street }}, {{ $order->delivery->address->barangay }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <!-- Order Details -->
        <div class="bg-gray-50 p-4 rounded-lg">
            <h3 class="font-medium text-gray-700 mb-2">Order Summary</h3>
            <div class="space-y-2">
                @php
                $totalPrice = $order->items->sum('price');
                @endphp
                <div class="flex justify-between">
                    <span class="text-gray-600">Subtotal</span>
                    <span class="font-medium">₱{{ number_format($totalPrice, 2) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Shipping</span>
                    <span class="font-medium">Free</span>
                </div>
                <div class="border-t border-gray-200 my-2 pt-2">
                    <div class="flex justify-between">
                        <span class="font-semibold">Total</span>
                        <span class="font-semibold">₱{{ number_format($totalPrice, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>



        <!-- Artist and Ordered Items -->
        <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
            <!-- Artist Header -->
            <div class="flex items-center mb-6">

                <div>
                    <h2 class="text-xl font-bold text-gray-800">Your Order from {{ $order->items->first()->artwork->artist->user->name }}</h2>
                    <p class="text-gray-500 text-sm">{{ count($order->items) }} {{ count($order->items) > 1 ? 'items' : 'item' }}</p>
                </div>
            </div>

            <!-- Ordered Items -->
            <div class="space-y-6">
                @foreach ($order->items as $item)
                <div class="bg-gray-50 rounded-xl overflow-hidden transition-all duration-200 hover:shadow-md">
                    <div class="flex flex-col md:flex-row">
                        <!-- Artwork Image -->
                        @php
                        $thumbnail = $item->artwork->images->first()?->attachment;
                        @endphp
                        <div class="md:w-1/3 lg:w-1/4">
                            <div class="relative aspect-[4/3]">
                                <img
                                    src="{{ $thumbnail ? asset('storage/' . $thumbnail->path) : asset('images/default-image.jpg') }}"
                                    alt="{{ $item->artwork->title }}"
                                    class="w-full h-full object-cover">
                            </div>
                        </div>

                        <!-- Artwork Details -->
                        <div class="flex-1 p-4 md:p-6 flex flex-col justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $item->artwork->title }}</h3>

                                <div class="grid grid-cols-2 gap-x-4 gap-y-2 mb-4">
                                    <div>
                                        <p class="text-xs text-gray-500">Category</p>
                                        <p class="font-medium">{{ $item->artwork->category->name }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Size</p>
                                        <p class="font-medium">{{$item->artwork->width}} × {{$item->artwork->height}} {{$item->artwork->unit}}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center justify-between mt-2">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-400 mr-1">
                                        <path d="M12 2a10 10 0 1 0 0 20 10 10 0 0 0 0-20z" />
                                        <path d="M12 12h5" />
                                        <path d="M12 6v6" />
                                    </svg>
                                    <span class="text-sm text-gray-500">Item #{{ $loop->iteration }}</span>
                                </div>
                                <span class="text-lg font-bold text-blue-600">₱{{ number_format($item->price, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Support and Action Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <!-- Support Center -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex items-start">
                    <div class="bg-blue-100 p-3 rounded-full mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-500">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-800 mb-2">Support Center</h2>
                        <p class="text-gray-600 mb-4">Having issues with your order? Our support team is ready to help.</p>
                        <a href="mailto:torchtech2024@gmail.com" class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-600 rounded-lg hover:bg-blue-200 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                                <rect width="20" height="16" x="2" y="4" rx="2" />
                                <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
                            </svg>
                            Contact Support
                        </a>
                    </div>
                </div>
            </div>

            <!-- Buttons and Order Actions -->
            <div class="flex flex-col gap-6">
                <!-- Buttons Section -->
                <div class="flex flex-col md:flex-row justify-end gap-4">
                    @if ($order->delivery->status == 'pending')
                    <form action="{{ route('client.order.cancel', $order) }}" method="POST" class="w-full md:w-auto">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                            class="w-full md:w-auto px-4 py-2 bg-red-500 text-white rounded-lg shadow hover:bg-red-600 transition-colors">
                            Cancel Order
                        </button>
                    </form>
                    @elseif ($order->delivery->status == 'in-transit')
                    <button data-tooltip-target="tooltip-default" type="button"
                        class="w-full md:w-auto px-4 py-2 bg-gray-400 text-white rounded-lg shadow cursor-not-allowed"
                        disabled>
                        Cancel Order
                    </button>

                    <div id="tooltip-default" role="tooltip"
                        class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                        Order cannot be cancelled while in transit. </br> You can initiate a refund/return after delivery.
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>
                    @elseif ($order->delivery->status == 'delivered')
                    <!-- Received Button -->
                    <form action="{{ route('client.order.update', $order) }}" method="POST" class="w-full md:w-auto">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="completed">
                        <button type="submit"
                            class="w-full md:w-auto px-4 py-2 bg-green-500 text-white rounded-lg shadow hover:bg-green-600 transition-colors">
                            Received
                        </button>
                    </form>

                    <!-- Return/Refund Button -->
                    @if (!$order->refund)
                    <button data-modal-target="return-refund-modal" data-modal-toggle="return-refund-modal"
                        class="w-full md:w-auto px-4 py-2 text-white bg-yellow-500 hover:bg-yellow-600 rounded-lg shadow transition-colors">
                        Return/Refund
                    </button>
                    @else
                    <p class="text-red-500 text-sm md:text-base">Refund request already submitted for this order.</p>
                    @endif

                    @elseif ($order->delivery->status == 'completed')
                    <!-- Review Button -->
                    @if (!$order->reviews->where('order_id', $order->id)->count())
                    <button data-modal-target="crud-modal" data-modal-toggle="crud-modal"
                        class="w-full md:w-auto px-4 py-2 text-white bg-blue-700 hover:bg-blue-800 rounded-lg shadow transition-colors">
                        Review
                    </button>
                    @else
                    <p class="text-green-500 text-sm md:text-base">You have already reviewed this order.</p>
                    @endif

                    <!-- Return/Refund Button -->
                    @if (!$order->refund)
                    <button data-modal-target="return-refund-modal" data-modal-toggle="return-refund-modal"
                        class="w-full md:w-auto px-4 py-2 text-white bg-red-700 hover:bg-red-800 rounded-lg shadow transition-colors">
                        Return/Refund
                    </button>
                    @else
                    <p class="text-red-500 text-sm md:text-base">A refund request has already been submitted for this order. Please wait for further updates.</p>
                    @endif
                    @elseif ($order->status == 'hold')
                    <p class="text-red-500 text-sm md:text-base">A refund request has already been submitted for this order. </br> Please wait for further updates.</p>
                    @elseif ($order->status == 'returned')
                    <p class="text-red-500 text-sm md:text-base">Your order has been refunded with a 10% service fee deducted. Please check your payment method for the refund.</p>
                    @endif
                </div>

                <!-- Order Actions Section -->
                @if (!in_array($order->delivery->status, ['pending', 'in-transit']))
                <div class="bg-white rounded-xl shadow-sm p-6 flex flex-col justify-center">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Order Actions</h2>

                    <div class="flex flex-col sm:flex-row gap-4">
                        @if ($order->delivery->status == 'completed')
                        @if (!$order->reviews->where('order_id', $order->id)->count())
                        <button
                            data-modal-target="crud-modal"
                            data-modal-toggle="crud-modal"
                            class="w-full px-4 py-3 bg-blue-600 text-white hover:bg-blue-700 rounded-lg transition-colors font-medium flex items-center justify-center"
                            type="button">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                                <path d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5z" />
                            </svg>
                            Write a Review
                        </button>
                        @else
                        <div class="bg-green-50 border border-green-200 rounded-lg p-4 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-green-500 mr-3">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                                <path d="m9 11 3 3L22 4" />
                            </svg>
                            <p class="text-green-700 font-medium">You have already reviewed this order</p>
                        </div>
                        @endif
                        @endif
                    </div>
                </div>
                @endif
            </div>

            <!-- Return/Refund Modal -->
            <div id="return-refund-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full max-w-md max-h-full">
                    <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                        <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="return-refund-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                        <div class="p-4 md:p-5 text-center">
                            <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Return/Refund Request</h3>
                            <form action="{{ route('client.return.order', $order) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-4">
                                    <label for="reason" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Reason</label>
                                    <select id="reason" name="reason" class="block w-full p-2.5 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option value="Damaged item">Damaged item</option>
                                        <option value="Wrong item">Wrong item</option>
                                        <option value="Item not as described">Item not as described</option>
                                        <option value="Late delivery">Late delivery</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label for="evidence" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Attach Image</label>
                                    <input type="file" id="evidence" name="evidence" accept="image/*" required class="block w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 cursor-pointer focus:outline-none dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400">
                                </div>
                                <button type="submit" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                                    Submit Request
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
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
                    <form action="{{ route('client.review.order', $order) }}" method="POST" class="p-4 md:p-5">
                        @csrf
                        <div class="grid gap-4 mb-4 grid-cols-2">
                            <div class="mb-4" x-data="{ rating: 0 }">
                                <input type="hidden" name="rating" x-model="rating">

                                <div class="flex items-center">
                                    <template x-for="star in 5">
                                        <svg @click="rating = star"
                                            :class="rating >= star ? 'text-yellow-300' : 'text-gray-300'"
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