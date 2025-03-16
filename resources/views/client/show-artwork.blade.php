<x-app-layout>
    <div class="mt-4 md:mt-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 bg-gray-200">
        <!-- Back Button -->
        <div class="mb-4 pt-4">
            <button onclick="window.history.back()" class="flex items-center justify-center w-10 h-10 rounded-full bg-gray-200 hover:bg-gray-300 transition-colors">
                <svg class="w-6 h-6 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12l4-4m-4 4 4 4" />
                </svg>
            </button>
        </div>
        <div class="flex flex-col md:flex-row gap-4 md:gap-6 py-4 w-full">
            <!-- Carousel Section -->
            <div id="default-carousel" class="relative w-full md:w-1/2 h-full" data-carousel="slide">
                <!-- Carousel wrapper -->
                <div class="relative h-56 md:h-96 overflow-hidden rounded-lg">
                    @foreach ($artwork->images as $index => $image)
                    <div class="{{ $index === 0 ? '' : 'hidden' }} duration-700 ease-in-out" data-carousel-item>
                        <img src="{{ $image->attachment ? asset('storage/' . $image->attachment->path) : asset('images/default.image.jpg') }}"
                            class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
                            alt="...">
                    </div>
                    @endforeach
                </div>
                <!-- Slider indicators -->
                <div class="absolute z-30 flex -translate-x-1/2 bottom-5 left-1/2 space-x-3 rtl:space-x-reverse">
                    @foreach ($artwork->images as $index => $image)
                    <button type="button" class="w-3 h-3 rounded-full"
                        aria-current="{{ $index === 0 ? 'true' : 'false' }}" aria-label="Slide {{ $index + 1 }}"
                        data-carousel-slide-to="{{ $index }}"></button>
                    @endforeach
                </div>
                <!-- Slider controls -->
                <button type="button"
                    class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                    data-carousel-prev>
                    <span
                        class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                        <svg class="w-4 h-4 text-black dark:text-gray-800 rtl:rotate-180" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 1 1 5l4 4" />
                        </svg>
                        <span class="sr-only">Previous</span>
                    </span>
                </button>
                <button type="button"
                    class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                    data-carousel-next>
                    <span
                        class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                        <svg class="w-4 h-4 text-black dark:text-gray-800 rtl:rotate-180" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 9 4-4-4-4" />
                        </svg>
                        <span class="sr-only">Next</span>
                    </span>
                </button>
            </div>

            <!-- Artwork Details Section -->
            <div class="flex w-full md:w-1/2 flex-col">
                <div class="flex flex-col md:flex-row items-start md:items-center justify-between">
                    <h1 class="text-2xl md:text-3xl font-bold">{{ $artwork->title }}</h1>
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
                        <span class="line-through">₱{{ number_format($artwork->price, 0, '.', ',') }}</span>
                        <strong>₱{{ number_format($discountedPrice, 0, '.', ',') }}</strong>
                        @else
                        ₱<strong>{{ number_format($artwork->price, 0, '.', ',') }}</strong>
                        @endif
                    </p>
                </div>
                <div class="flex justify-between">
                    <div>
                        <p class="text-md text-black-500">{{ $artwork->artist->user->name ?? 'Unknown' }}</p>
                        <p class="text-md text-black-500">{{ $artwork->created_at->diffForHumans() }}</p>
                    </div>
                    @if ($hasLiked ?? false)
                    <!-- Unlike Form -->
                    <form action="{{ route('artwork.unlike', $artwork) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="flex items-center gap-2 mt-4">
                            <!-- Filled Heart (Unliked) -->
                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path
                                    d="m12.75 20.66 6.184-7.098c2.677-2.884 2.559-6.506.754-8.705-.898-1.095-2.206-1.816-3.72-1.855-1.293-.034-2.652.43-3.963 1.442-1.315-1.012-2.678-1.476-3.973-1.442-1.515.04-2.825.76-3.724 1.855-1.806 2.201-1.915 5.823.772 8.706l6.183 7.097c.19.216.46.34.743.34a.985.985 0 0 0 .743-.34Z" />
                            </svg>
                            <p class="text-md text-gray-700">Unlike</p>
                        </button>
                    </form>
                    @else
                    <!-- Like Form -->
                    <form action="{{ route('artwork.like', $artwork) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="flex items-center gap-2 mt-4">
                            <!-- Outlined Heart (Liked) -->
                            <svg class="w-8 h-8 text-black-500" xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12.01 6.001C6.5 1 1 8 5.782 13.001L12.011 20l6.23-7C23 8 17.5 1 12.01 6.002Z" />
                            </svg>
                            <p class="text-md text-gray-700">Like</p>
                        </button>
                    </form>
                    @endif
                </div>

                <hr class="w-full my-4 h-2 border-gray-500">

                <div>
                    <h2 class="text-xl font-semibold">About</h2>
                    <p class="mt-2"><strong>{{ $artwork->category->name }}</strong></p>
                    <p class="mt-1"><strong>Size:</strong> {{ $artwork->width }} x {{ $artwork->height }}
                        {{ $artwork->unit }}
                    </p>
                    <div class="flex flex-wrap gap-2 mt-2">
                        @foreach ($artwork->tags as $tag)
                        <span
                            class="bg-green-200 text-sm text-gray-700 px-3 py-1 rounded-full">{{ $tag->name }}</span>
                        @endforeach
                    </div>
                    <p class="mt-4 text-sm md:text-base">{{ $artwork->description }}</p>
                </div>

                <!-- Contact Section -->
                <div>
                    <h2 class="text-xl font-semibold mt-4">Contact</h2>
                    <p class="mt-2 text-sm md:text-base"><strong>Email:</strong> {{ $artwork->artist->user->email ?? 'user@email.com' }}</p>
                    <p class="mt-1 text-sm md:text-base"><strong>Phone:</strong> {{ $artwork->artist->user->phone_number }}</p>
                </div>

                <!-- Buttons Section -->
                @if (auth()->check() && auth()->user()->id !== $artwork->artist->user->id && $artwork->status === 'sale')
                <div class="mt-4 flex gap-4 justify-end">
                    <form action="{{ route('client.cart.store', $artwork) }}" method="POST">
                        @csrf
                        @if (!auth()->user()->cart || !auth()->user()->cart->items->contains('artwork_id', $artwork->id))
                        <button type="submit"
                            class="flex items-center gap-2 justify-center bg-gray-200 border border-black text-gray-800 px-4 py-2 rounded hover:bg-gray-300">
                            Add to cart
                            <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M4 4h1.5L8 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm.75-3H7.5M11 7H6.312M17 4v6m-3-3h6" />
                            </svg>
                        </button>
                        @else
                        <a href="{{ route('client.cart.index') }}"
                            class="flex items-center gap-2 justify-center bg-gray-200 border border-black text-gray-800 px-4 py-2 rounded hover:bg-gray-300">
                            Check cart
                            <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M4 4h1.5L8 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm.75-3H7.5M11 7H6.312M17 4v6m-3-3h6" />
                            </svg>
                        </a>
                        @endif
                    </form>
                    <button data-modal-target="authentication-modal" data-modal-toggle="authentication-modal"
                        class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                        type="button">
                        Buy Now
                    </button>
                </div>
                @endif
            </div>
        </div>

        <!-- Main modal -->
        <div id="authentication-modal" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-full">
            <div class="relative p-4 w-full max-w-3xl max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                    <!-- Modal header -->
                    <div
                        class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            Checkout
                        </h3>
                        <button type="button"
                            class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="authentication-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="flex gap-2 justify-center p-4 md:p-5">
                        <div class="w-1/2">
                            @if ($artwork->discount && $artwork->discount->status === 'active')
                            @php
                            $discount = $artwork->discount;
                            $discountedPrice = $artwork->price;
                            if ($discount->value_type === 'percentage') {
                            $discountedPrice -= ($artwork->price * $discount->value) / 100;
                            } else {
                            $discountedPrice -= $discount->value;
                            }
                            @endphp
                            @endif
                            <p class="mb-3 text-xl text-red-600 font-bold"><strong>Total:
                                </strong>₱{{ number_format($discountedPrice, 0, '.', ',') }}</p>
                            <div class="flex gap-4 items-center">
                                <img src="{{ $artwork->images->first()?->attachment ? asset('storage/' . $artwork->images->first()->attachment->path) : asset('images/default.image.jpg') }}"
                                    alt="{{ $artwork->title }}" class="w-16 h-16 object-cover rounded-lg">
                                <div>
                                    <h1 class="text-lg font-bold">{{ $artwork->title }}</h1>
                                    <p class="text-sm text-gray-500">
                                        {{ $artwork->artist->user->name ?? 'Unknown' }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center mt-4 w-full border border-black rounded-md p-2">
                                <p class="text-sm mr-4">Accepts</p>
                                <img src="{{ asset('images/paymongo.png') }}" alt="Paymongo" class="h-4">
                            </div>
                            <div class="mt-4 flex flex-col gap-2">
                                <div class="flex items-center gap-2">
                                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="1"
                                            d="M13 7h6l2 4m-8-4v8m0-8V6a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v9h2m8 0H9m4 0h2m4 0h2v-4m0 0h-5m3.5 5.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Zm-10 0a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Z" />
                                    </svg>
                                    <p class="text-sm">Shipping within Zamboanga is Free.</p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="1"
                                            d="M8.5 11.5 11 14l4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                    <p class="text-sm">7-day money back guarantee.</p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="1"
                                            d="M10 3v4a1 1 0 0 1-1 1H5m4 10v-2m3 2v-6m3 6v-3m4-11v16a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V7.914a1 1 0 0 1 .293-.707l3.914-3.914A1 1 0 0 1 9.914 3H18a1 1 0 0 1 1 1Z" />
                                    </svg>
                                    <p class="text-sm">Quality assured.</p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="1"
                                            d="M6 6l12 12M6 18L18 6" />
                                    </svg>
                                    <p class="text-sm">Not refundable once paid.</p>
                                </div>
                            </div>
                        </div>
                        @if (auth()->check() && auth()->user()->address && auth()->user()->phone_number)
                        <form class="space-y-4 w-1/2 flex flex-col justify-between"
                            action="{{ route('client.order.store', $artwork) }}" method="POST">
                            @csrf
                            @if (auth()->user())
                            <h2>{{ auth()->user()->name }} | (+63) {{ auth()->user()->phone_number }}
                            </h2>
                            @endif
                            <div class="p-4 border rounded-lg bg-gray-100">
                                <h2 class="text-lg font-semibold">Shipping Address</h2>
                                <p class="mt-2"><strong>Barangay:</strong>
                                    {{ auth()->user()->address->barangay ?? 'N/A' }}
                                </p>
                                <p class="mt-1"><strong>Street/Drive:</strong>
                                    {{ auth()->user()->address->street ?? 'N/A' }}
                                </p>
                                <p class="mt-1"><strong>House Number:</strong>
                                    {{ auth()->user()->address->house_number ?? 'N/A' }}
                                </p>
                                <a href="{{ route('profile.edit') }}"
                                    class="mt-4 flex text-orange-500 hover:underline">
                                    <svg class="w-6 h-6 text-orange-500 dark:text-white"
                                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" fill="none"
                                        viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="2"
                                            d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                                    </svg>
                                    Edit Address
                                </a>
                            </div>
                            <button type="submit"
                                class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Go
                                to Payment
                            </button>
                        </form>
                        @else
                        <div class="space-y-4 w-1/2 flex flex-col justify-start">
                            @if (auth()->user())
                            <h2>{{ auth()->user()->name }} | (+63) {{ auth()->user()->phone_number }}
                            </h2>
                            @endif
                            <div class="p-4 border rounded-lg bg-gray-100">
                                <h2 class="text-lg font-semibold">Shipping Address</h2>
                                <p class="mt-2 text-red-600">Please add a shipping address before
                                    proceeding to payment.</p>
                                <a href="{{ route('profile.edit') }}"
                                    class="mt-4 flex text-orange-500 hover:underline">
                                    <svg class="w-6 h-6 text-orange-500 dark:text-white"
                                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" fill="none"
                                        viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="2"
                                            d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                                    </svg>
                                    Add Address
                                </a>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
    </div>
    </div>
</x-app-layout>