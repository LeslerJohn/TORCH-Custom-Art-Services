<x-app-layout>
    <div class="mt-4 md:mt-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 bg-gray-50">
        <!-- Back Button -->
        <div class="mb-4 pt-4">
            <button onclick="window.history.back()" class="flex items-center justify-center w-10 h-10 rounded-full bg-white hover:bg-gray-100 transition-colors shadow-sm">
                <svg class="w-6 h-6 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12l4-4m-4 4 4 4" />
                </svg>
            </button>
        </div>

        <!-- Main Content -->
        <div class="flex flex-col md:flex-row gap-6 py-6">
            <!-- Carousel Section -->
            <div class="w-full md:w-1/2">
                <div id="default-carousel" class="relative w-full h-full" data-carousel="slide">
                    <!-- Carousel Wrapper -->
                    <div class="relative h-64 md:h-96 overflow-hidden rounded-lg shadow-lg">
                        @foreach ($artwork->images as $index => $image)
                        <div class="{{ $index === 0 ? '' : 'hidden' }} duration-700 ease-in-out" data-carousel-item>
                            <img src="{{ $image->attachment ? asset('storage/' . $image->attachment->path) : asset('images/default.image.jpg') }}"
                                class="absolute block w-full h-full object-cover"
                                alt="{{ $artwork->title }}">
                        </div>
                        @endforeach
                    </div>

                    <!-- Slider Indicators -->
                    <div class="absolute z-30 flex -translate-x-1/2 bottom-5 left-1/2 space-x-3 rtl:space-x-reverse">
                        @foreach ($artwork->images as $index => $image)
                        <button type="button" class="w-3 h-3 rounded-full bg-white/50 hover:bg-white/80 transition-colors"
                            aria-current="{{ $index === 0 ? 'true' : 'false' }}" aria-label="Slide {{ $index + 1 }}"
                            data-carousel-slide-to="{{ $index }}"></button>
                        @endforeach
                    </div>

                    <!-- Slider Controls -->
                    <button type="button" class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-prev>
                        <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 hover:bg-white/50 transition-colors">
                            <svg class="w-4 h-4 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4" />
                            </svg>
                            <span class="sr-only">Previous</span>
                        </span>
                    </button>
                    <button type="button" class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-next>
                        <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 hover:bg-white/50 transition-colors">
                            <svg class="w-4 h-4 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                            <span class="sr-only">Next</span>
                        </span>
                    </button>
                </div>
            </div>

            <!-- Artwork Details Section -->
            <div class="w-full md:w-1/2 flex flex-col space-y-6">
                <!-- Title and Price -->
                <div class="flex flex-col md:flex-row items-start md:items-center justify-between">
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900">{{ $artwork->title }}</h1>
                    @php
                    $discount = $artwork->discount;
                    $discountedPrice = $artwork->price;
                    if ($discount && $discount->status === 'active') {
                    if ($discount->value_type === 'percentage') {
                    $discountedPrice -= ($artwork->price * $discount->value) / 100;
                    } else {
                    $discountedPrice -= $discount->value;
                    }
                    }
                    @endphp
                    <p class="text-xl md:text-2xl text-red-600 mt-2 md:mt-0">
                        @if ($discount && $discount->status === 'active')
                        <span class="line-through text-gray-500">₱{{ number_format($artwork->price, 0, '.', ',') }}</span>
                        <strong>₱{{ number_format($discountedPrice, 0, '.', ',') }}</strong>
                        @else
                        ₱<strong>{{ number_format($artwork->price, 0, '.', ',') }}</strong>
                        @endif
                    </p>
                </div>

                <!-- Artist and Like Button -->
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-md text-gray-700">{{ $artwork->artist->user->name ?? 'Unknown' }}</p>
                        <p class="text-md text-gray-500">{{ $artwork->created_at->diffForHumans() }}</p>
                    </div>
                    @if ($hasLiked ?? false)
                    <!-- Unlike Form -->
                    <form action="{{ route('artwork.unlike', $artwork) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="flex items-center gap-2 text-red-600 hover:text-red-700">
                            <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                <path d="m12.75 20.66 6.184-7.098c2.677-2.884 2.559-6.506.754-8.705-.898-1.095-2.206-1.816-3.72-1.855-1.293-.034-2.652.43-3.963 1.442-1.315-1.012-2.678-1.476-3.973-1.442-1.515.04-2.825.76-3.724 1.855-1.806 2.201-1.915 5.823.772 8.706l6.183 7.097c.19.216.46.34.743.34a.985.985 0 0 0 .743-.34Z" />
                            </svg>
                            <span>Unlike</span>
                        </button>
                    </form>
                    @else
                    <!-- Like Form -->
                    <form action="{{ route('artwork.like', $artwork) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="flex items-center gap-2 text-gray-600 hover:text-gray-700">
                            <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12.01 6.001C6.5 1 1 8 5.782 13.001L12.011 20l6.23-7C23 8 17.5 1 12.01 6.002Z" />
                            </svg>
                            <span>Like</span>
                        </button>
                    </form>
                    @endif
                </div>

                <!-- Divider -->
                <hr class="border-gray-300">

                <!-- About Section -->
                <div>
                    <h2 class="text-xl font-semibold text-gray-900">About</h2>
                    <p class="mt-2 text-gray-700"><strong>{{ $artwork->category->name }}</strong></p>
                    <p class="mt-1 text-gray-700"><strong>Size:</strong> {{ $artwork->width }} x {{ $artwork->height }} {{ $artwork->unit }}</p>
                    <div class="flex flex-wrap gap-2 mt-2">
                        @foreach ($artwork->tags as $tag)
                        <span class="bg-green-100 text-sm text-gray-700 px-3 py-1 rounded-full">{{ $tag->name }}</span>
                        @endforeach
                    </div>
                    <p class="mt-4 text-sm md:text-base text-gray-600">{{ $artwork->description }}</p>
                </div>

                <!-- Contact Section -->
                <div>
                    <h2 class="text-xl font-semibold text-gray-900">Contact</h2>
                    <p class="mt-2 text-gray-700"><strong>Email:</strong> {{ $artwork->artist->user->email ?? 'user@email.com' }}</p>
                    <p class="mt-1 text-gray-700"><strong>Phone:</strong> {{ $artwork->artist->user->phone_number }}</p>
                </div>

                <!-- Buttons Section -->
                @if (auth()->check() && auth()->user()->id !== $artwork->artist->user->id && $artwork->status === 'sale')
                <div class="mt-6 flex gap-4 justify-end">
                    <form action="{{ route('client.cart.store', $artwork) }}" method="POST">
                        @csrf
                        @if (!auth()->user()->cart || !auth()->user()->cart->items->contains('artwork_id', $artwork->id))
                        <button type="submit" class="flex items-center gap-2 bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-50 transition-colors">
                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4h1.5L8 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm.75-3H7.5M11 7H6.312M17 4v6m-3-3h6" />
                            </svg>
                            Add to Cart
                        </button>
                        @else
                        <a href="{{ route('client.cart.index') }}" class="flex items-center gap-2 bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-50 transition-colors">
                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4h1.5L8 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm.75-3H7.5M11 7H6.312M17 4v6m-3-3h6" />
                            </svg>
                            View Cart
                        </a>
                        @endif
                    </form>
                    <button data-modal-target="authentication-modal" data-modal-toggle="authentication-modal"
                        class="px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        Buy Now
                    </button>
                </div>
                @endif
            </div>
        </div>

        <!-- Modal -->
        <div id="authentication-modal" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-full bg-black/50">
            <div class="relative p-4 w-full max-w-3xl max-h-full">
                <!-- Modal Content -->
                <div class="relative bg-white rounded-lg shadow-lg">
                    <!-- Modal Header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                        <h3 class="text-xl font-semibold text-gray-900">Checkout</h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 rounded-lg text-sm w-8 h-8 flex justify-center items-center" data-modal-hide="authentication-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close</span>
                        </button>
                    </div>
                    <!-- Modal Body -->
                    <div class="p-4 md:p-5 space-y-4">
                        <!-- Total Price -->
                        <div class="flex items-center justify-between">
                            <p class="text-xl font-bold text-gray-900">Total:</p>
                            <p class="text-xl text-red-600 font-bold">₱{{ number_format($discountedPrice, 0, '.', ',') }}</p>
                        </div>
                        <!-- Artwork Details -->
                        <div class="flex items-center gap-4">
                            <img src="{{ $artwork->images->first()?->attachment ? asset('storage/' . $artwork->images->first()->attachment->path) : asset('images/default.image.jpg') }}"
                                alt="{{ $artwork->title }}" class="w-16 h-16 object-cover rounded-lg">
                            <div>
                                <h1 class="text-lg font-bold text-gray-900">{{ $artwork->title }}</h1>
                                <p class="text-sm text-gray-500">{{ $artwork->artist->user->name ?? 'Unknown' }}</p>
                            </div>
                        </div>
                        <!-- Payment and Shipping Info -->
                        <div class="space-y-2">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M13 7h6l2 4m-8-4v8m0-8V6a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v9h2m8 0H9m4 0h2m4 0h2v-4m0 0h-5m3.5 5.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Zm-10 0a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Z" />
                                </svg>
                                <p class="text-sm text-gray-700">Free shipping within Zamboanga.</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8.5 11.5 11 14l4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                <p class="text-sm text-gray-700">7-day money back guarantee.</p>
                            </div>
                        </div>
                        <!-- Shipping Address -->
                        @if (auth()->check() && auth()->user()->address && auth()->user()->phone_number)
                        <form action="{{ route('client.order.store', $artwork) }}" method="POST" class="space-y-4">
                            @csrf
                            <div class="p-4 border rounded-lg bg-gray-50">
                                <h2 class="text-lg font-semibold text-gray-900">Shipping Address</h2>
                                <p class="mt-2 text-gray-700"><strong>Barangay:</strong> {{ auth()->user()->address->barangay ?? 'N/A' }}</p>
                                <p class="mt-1 text-gray-700"><strong>Street/Drive:</strong> {{ auth()->user()->address->street ?? 'N/A' }}</p>
                                <p class="mt-1 text-gray-700"><strong>House Number:</strong> {{ auth()->user()->address->house_number ?? 'N/A' }}</p>
                                <a href="{{ route('profile.edit') }}" class="mt-4 flex items-center text-blue-600 hover:underline">
                                    <svg class="w-5 h-5 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                                    </svg>
                                    Edit Address
                                </a>
                            </div>
                            <button type="submit" class="w-full px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                Go to Payment
                            </button>
                        </form>
                        @else
                        <div class="p-4 border rounded-lg bg-gray-50">
                            <h2 class="text-lg font-semibold text-gray-900">Shipping Address</h2>
                            <p class="mt-2 text-red-600">Please add a shipping address before proceeding to payment.</p>
                            <a href="{{ route('profile.edit') }}" class="mt-4 flex items-center text-blue-600 hover:underline">
                                <svg class="w-5 h-5 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                                </svg>
                                Add Address
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>