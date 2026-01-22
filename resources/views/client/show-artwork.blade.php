<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 bg-white">
        <!-- Navigation & Breadcrumbs -->
        <div class="mb-6">
            <button onclick="window.history.back()" class="group flex items-center text-gray-600 hover:text-blue-600 transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12l4-4m-4 4 4 4" />
                </svg>
                <span class="font-medium">Back to Gallery</span>
            </button>
        </div>

        <!-- Main Content -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Image Gallery Section -->
            <div class="space-y-4">
                <!-- Main Image -->
                <div class="relative aspect-square rounded-xl overflow-hidden shadow-lg bg-gray-100">
                    <img id="mainImage" src="{{ $artwork->images->first()?->attachment ? asset('storage/' . $artwork->images->first()->attachment->path) : asset('images/default.image.jpg') }}"
                        class="w-full h-full object-cover" alt="{{ $artwork->title }}">
                </div>

                <!-- Thumbnail Gallery -->
                <div class="grid grid-cols-5 gap-2">
                    @foreach ($artwork->images as $index => $image)
                    <button onclick="setMainImage('{{ $image->attachment ? asset('storage/' . $image->attachment->path) : asset('images/default.image.jpg') }}')"
                        class="aspect-square rounded-lg overflow-hidden border-2 {{ $index === 0 ? 'border-blue-500' : 'border-transparent' }} hover:border-blue-400 transition-colors duration-200">
                        <img src="{{ $image->attachment ? asset('storage/' . $image->attachment->path) : asset('images/default.image.jpg') }}"
                            class="w-full h-full object-cover" alt="{{ $artwork->title }} thumbnail">
                    </button>
                    @endforeach
                </div>
            </div>

            <!-- Artwork Details Section -->
            <div class="flex flex-col space-y-8">
                <!-- Header Section -->
                <div>
                    <!-- Category Badge -->
                    <span class="inline-block px-3 py-1 bg-blue-100 text-blue-800 text-sm font-medium rounded-full mb-3">
                        {{ $artwork->category->name }}
                    </span>

                    <!-- Title -->
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $artwork->title }}</h1>

                    <!-- Artist Info -->
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-bold mr-3">
                            {{ substr($artwork->artist->user->name ?? 'A', 0, 1) }}
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">{{ $artwork->artist->user->name ?? 'Unknown Artist' }}</p>
                            <p class="text-sm text-gray-500">{{ $artwork->created_at->diffForHumans() }}</p>
                        </div>
                    </div>

                    <!-- Price Section -->
                    <div class="bg-gray-50 p-4 rounded-lg">
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

                        <div class="flex items-center">
                            @if ($discount && $discount->status === 'active')
                            <div class="mr-3">
                                <span class="text-sm text-gray-500 line-through">₱{{ number_format($artwork->price, 0, '.', ',') }}</span>
                                <span class="block text-2xl font-bold text-red-600">₱{{ number_format($discountedPrice, 0, '.', ',') }}</span>
                            </div>
                            <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-1 rounded-full">
                                @if($discount->value_type === 'percentage')
                                {{ $discount->value }}% OFF
                                @else
                                ₱{{ number_format($discount->value, 0, '.', ',') }} OFF
                                @endif
                            </span>
                            @else
                            <span class="text-2xl font-bold text-gray-900">₱{{ number_format($artwork->price, 0, '.', ',') }}</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Artwork Details -->
                <div class="space-y-6">
                    <!-- Specs -->
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900 mb-3">Specifications</h2>
                        <div class="grid grid-cols-2 gap-y-2">
                            <div class="text-gray-600">Size</div>
                            <div class="font-medium">{{ $artwork->width }} x {{ $artwork->height }} {{ $artwork->unit }}</div>

                            <div class="text-gray-600">Material</div>
                            <div class="font-medium">Canvas</div>

                            <div class="text-gray-600">Status</div>
                            <div class="font-medium">
                                @if($artwork->status === 'sale')
                                <span class="text-green-600">Available for Sale</span>
                                @elseif($artwork->status === 'sold')
                                <span class="text-red-600">Sold</span>
                                @else
                                <span>{{ ucfirst($artwork->status) }}</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900 mb-3">About This Artwork</h2>
                        <p class="text-gray-600">{{ $artwork->description }}</p>
                    </div>

                    <!-- Tags -->
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900 mb-3">Tags</h2>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($artwork->tags as $tag)
                            <span class="bg-gray-100 text-gray-800 text-sm px-3 py-1 rounded-full hover:bg-gray-200 transition-colors">
                                #{{ $tag->name }}
                            </span>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="pt-4 border-t border-gray-200">
                    <div class="flex items-center justify-between mb-4">
                        <!-- Like Button -->
                        @if ($hasLiked ?? false)
                        <form action="{{ route('artwork.unlike', $artwork) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="flex items-center text-red-600 hover:text-red-700">
                                <svg class="w-6 h-6 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="m12.75 20.66 6.184-7.098c2.677-2.884 2.559-6.506.754-8.705-.898-1.095-2.206-1.816-3.72-1.855-1.293-.034-2.652.43-3.963 1.442-1.315-1.012-2.678-1.476-3.973-1.442-1.515.04-2.825.76-3.724 1.855-1.806 2.201-1.915 5.823.772 8.706l6.183 7.097c.19.216.46.34.743.34a.985.985 0 0 0 .743-.34Z" />
                                </svg>
                                <span>Liked</span>
                            </button>
                        </form>
                        @else
                        <form action="{{ route('artwork.like', $artwork) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="flex items-center text-gray-600 hover:text-red-600 transition-colors">
                                <svg class="w-6 h-6 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12.01 6.001C6.5 1 1 8 5.782 13.001L12.011 20l6.23-7C23 8 17.5 1 12.01 6.002Z" />
                                </svg>
                                <span>Like</span>
                            </button>
                        </form>
                        @endif

                        <!-- Share Button -->
                        <button class="flex items-center text-gray-600 hover:text-gray-800">
                            <svg class="w-5 h-5 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.5 15.5a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7 13.5 7.5-7.5M19.5 8.5a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM19.5 21.5a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM7 10.5l7.5 7.5" />
                            </svg>
                            <span>Share</span>
                        </button>
                    </div>

                    <!-- Purchase Buttons -->
                    @if (auth()->check() && auth()->user()->id !== $artwork->artist->user->id && $artwork->status === 'sale')
                    <div class="grid grid-cols-2 gap-4">
                        <form action="{{ route('client.cart.store', $artwork) }}" method="POST">
                            @csrf
                            @if (!auth()->user()->cart || !auth()->user()->cart->items->contains('artwork_id', $artwork->id))
                            <button type="submit" class="w-full flex items-center justify-center gap-2 bg-white border-2 border-blue-600 text-blue-600 px-4 py-3 rounded-lg hover:bg-blue-50 transition-colors font-medium">
                                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4h1.5L8 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm.75-3H7.5M11 7H6.312M17 4v6m-3-3h6" />
                                </svg>
                                Add to Cart
                            </button>
                            @else
                            <a href="{{ route('client.cart.index') }}" class="w-full flex items-center justify-center gap-2 bg-white border-2 border-blue-600 text-blue-600 px-4 py-3 rounded-lg hover:bg-blue-50 transition-colors font-medium">
                                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4h1.5L8 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm.75-3H7.5M11 7H6.312M17 4v6m-3-3h6" />
                                </svg>
                                View Cart
                            </a>
                            @endif
                        </form>
                        <button data-modal-target="checkout-modal" data-modal-toggle="checkout-modal"
                            class="w-full px-5 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                            Buy Now
                        </button>
                    </div>
                    @endif
                </div>

                <!-- Contact Artist -->
                <div class="bg-gray-50 p-5 rounded-xl">
                    <h2 class="flex items-center text-lg font-semibold text-gray-900 mb-4">
                        <svg class="w-5 h-5 mr-2 text-blue-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Contact the Artist
                    </h2>
                    <div class="space-y-3">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-gray-500 mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m3.5 5.5 7.9 6c.4.3.8.3 1.2 0l7.9-6M4 19h16c.6 0 1-.4 1-1V6c0-.6-.4-1-1-1H4a1 1 0 0 0-1 1v12c0 .6.4 1 1 1Z" />
                            </svg>
                            <span class="text-gray-700">{{ $artwork->artist->user->email ?? 'user@email.com' }}</span>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Checkout Modal -->
        <div id="checkout-modal" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-full bg-black/50">
            <div class="relative p-4 w-full max-w-2xl max-h-full">
                <!-- Modal Content -->
                <div class="relative bg-white rounded-xl shadow-2xl">
                    <!-- Modal Header -->
                    <div class="flex items-center justify-between p-5 border-b">
                        <h3 class="text-xl font-semibold text-gray-900">Complete Your Purchase</h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 rounded-lg text-sm w-8 h-8 flex justify-center items-center" data-modal-hide="checkout-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close</span>
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <div class="p-5 space-y-6">
                        <!-- Order Summary -->
                        <div>
                            <h4 class="text-lg font-medium text-gray-900 mb-3">Order Summary</h4>
                            <div class="flex items-start border-b border-gray-200 pb-4">
                                <img src="{{ $artwork->images->first()?->attachment ? asset('storage/' . $artwork->images->first()->attachment->path) : asset('images/default.image.jpg') }}"
                                    alt="{{ $artwork->title }}" class="w-20 h-20 object-cover rounded-lg mr-4">
                                <div>
                                    <h5 class="font-semibold text-gray-900">{{ $artwork->title }}</h5>
                                    <p class="text-sm text-gray-500">{{ $artwork->artist->user->name ?? 'Unknown' }}</p>
                                    <p class="text-sm text-gray-500">{{ $artwork->width }} x {{ $artwork->height }} {{ $artwork->unit }}</p>
                                </div>
                                <div class="ml-auto text-right">
                                    <p class="font-bold text-gray-900">₱{{ number_format($discountedPrice, 0, '.', ',') }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Shipping Benefits -->
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <div class="flex items-start mb-3">
                                <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3 flex-shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.5 11.5 11 14l4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                <div>
                                    <h5 class="font-medium text-gray-900">Free Shipping</h5>
                                    <p class="text-sm text-gray-600">Complimentary shipping within Zamboanga area</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3 flex-shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.5 11.5 11 14l4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                <div>
                                    <h5 class="font-medium text-gray-900">7-Day Money Back Guarantee</h5>
                                    <p class="text-sm text-gray-600">Not satisfied? Get a full refund within 7 days</p>
                                </div>
                            </div>
                        </div>

                        <!-- Shipping Address -->
                        @if (auth()->check() && auth()->user()->address && auth()->user()->phone_number)
                        <form action="{{ route('client.order.store', $artwork) }}" method="POST" class="space-y-4">
                            @csrf
                            <div class="border rounded-lg p-4">
                                <div class="flex justify-between items-center mb-3">
                                    <h4 class="text-lg font-medium text-gray-900">Shipping Address</h4>
                                    <a href="{{ route('profile.edit') }}" class="text-sm text-blue-600 hover:underline flex items-center">
                                        <svg class="w-4 h-4 mr-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                                        </svg>
                                        Edit
                                    </a>
                                </div>
                                <div class="space-y-1 text-gray-700">
                                    <p>{{ auth()->user()->name }}</p>
                                    <p>{{ auth()->user()->phone_number }}</p>
                                    <p>{{ auth()->user()->address->house_number ?? '' }} {{ auth()->user()->address->street ?? '' }}</p>
                                    <p>{{ auth()->user()->address->barangay ?? '' }}, Zamboanga City</p>
                                </div>
                            </div>
                            <div class="pt-4 border-t">
                                <div class="flex justify-between mb-2">
                                    <span class="text-gray-600">Subtotal</span>
                                    <span class="font-medium">₱{{ number_format($discountedPrice, 0, '.', ',') }}</span>
                                </div>
                                <div class="flex justify-between mb-2">
                                    <span class="text-gray-600">Shipping</span>
                                    <span class="font-medium text-green-600">Free</span>
                                </div>
                                <div class="flex justify-between text-lg font-bold mt-2 pt-2 border-t">
                                    <span>Total</span>
                                    <span>₱{{ number_format($discountedPrice, 0, '.', ',') }}</span>
                                </div>
                            </div>
                            <button type="submit" class="w-full px-5 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium mt-4">
                                Proceed to Payment
                            </button>
                        </form>
                        @else
                        <div class="border rounded-lg p-4 bg-yellow-50 border-yellow-200">
                            <div class="flex items-start">
                                <svg class="w-6 h-6 text-yellow-600 mr-3 flex-shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                                </svg>
                                <div>
                                    <h5 class="font-medium text-gray-900">Address Required</h5>
                                    <p class="text-sm text-gray-700 mb-4">Please add a shipping address before proceeding to payment.</p>
                                    <a href="{{ route('profile.edit') }}" class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium">
                                        <svg class="w-4 h-4 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                        Add Address
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for Image Gallery -->
    <script>
        function setMainImage(src) {
            document.getElementById('mainImage').src = src;
            // Update active thumbnail border
            document.querySelectorAll('[onclick^="setMainImage"]').forEach(el => {
                if (el.getAttribute('onclick').includes(src)) {
                    el.classList.add('border-blue-500');
                    el.classList.remove('border-transparent');
                } else {
                    el.classList.remove('border-blue-500');
                    el.classList.add('border-transparent');
                }
            });
        }
    </script>
</x-app-layout>