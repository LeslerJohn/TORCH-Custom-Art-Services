<x-app-layout>
    <div class="max-w-5xl pt-24 my-4 mx-auto bg-white p-6 rounded-lg shadow-lg">

        <h1 class="text-2xl font-bold mb-4"> Your Cart
            {{-- Your Cart ({{ optional($cart)->items->count() ?? 0 }} items) --}}
        </h1>

        @if ($cart && $cart->items->count() > 0)
            <form action="{{ route('client.cart.checkout') }}" method="POST" id="checkout-form">
                @csrf

                <div class="space-y-6">
                    @php
                        $groupedItems = $cart->items->groupBy(fn($item) => $item->artwork->artist->user->name);
                    @endphp

                    @foreach ($groupedItems as $artistName => $items)
                        <div class="p-4 border border-gray-300 rounded-lg">
                            <div class="flex items-center gap-2 mb-2">
                                <h2 class="text-xl">{{ $artistName }}</h2>
                                <svg class="w-4 h-4 text-blue-400 ml-1" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 15l-4-4 1.41-1.41L11 13.17l5.59-5.59L18 9l-7 7z" />
                                </svg>
                            </div>

                            @foreach ($items as $item)
                                <div class="flex gap-4 p-2 bg-gray-50 rounded-lg">
                                    <!-- Checkbox -->
                                    <div class="flex items-center justify-center">
                                        <input type="checkbox" name="selected_items[]" value="{{ $item->id }}"
                                            class="artwork-checkbox" data-price="{{ $item->artwork->price }}">
                                    </div>

                                    <!-- Artwork Image -->
                                    @php
                                        $thumbnail = $item->artwork->images->first()
                                            ? $item->artwork->images->first()->attachment
                                            : null;
                                    @endphp
                                    <img src="{{ $thumbnail ? asset("storage/{$thumbnail->path}") : asset('images/default-image.jpg') }}"
                                        alt="{{ $item->artwork->title }}" class="w-36 h-36 object-cover rounded-md">

                                    <!-- Artwork Details -->
                                    <div class="flex-1 flex justify-between">
                                        <div>
                                            <h3 class="text-xl font-semibold">{{ $item->artwork->title }}</h3>
                                            <p class="text-md text-gray-400">{{ $item->artwork->category->name }}</p>
                                        </div>
                                        <div>
                                            <p class="text-red-500 text-lg font-bold">
                                                ₱{{ number_format($item->artwork->price, 2) }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>

                <!-- Total Price Calculation -->
                <div class="mt-6 text-right">
                    <h3 class="text-xl font-semibold">Total: ₱<span id="total-price">0.00</span></h3>
                </div>

                <!-- Checkout Button -->
                <div class="mt-6 flex justify-end items-center gap-2">
                    <span id="selected-count" class="text-gray-600">0 items selected</span>
                    <button type="submit" class="w-full max-w-32 bg-blue-500 text-white py-2 rounded-lg shadow"
                        id="checkout-btn" disabled>
                        Checkout
                    </button>
                </div>
            </form>
        @else
            <!-- Fallback Message -->
            <div class="flex flex-col items-center justify-center text-center py-12">
                <img src="{{ asset('images/cart-empty.png') }}" alt="Empty Cart" class="w-48 h-48 mb-4">
                <h2 class="text-2xl font-semibold text-gray-700">Your cart is empty!</h2>
                <p class="text-gray-500 mb-4">Looks like you haven’t added anything to your cart yet.</p>
                <a href="" class="bg-blue-500 text-white px-6 py-2 rounded-lg shadow-lg hover:bg-blue-600">
                    Browse Artworks
                </a>
            </div>
        @endif
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const checkboxes = document.querySelectorAll('.artwork-checkbox');
            const totalPriceElement = document.getElementById('total-price');
            const checkoutBtn = document.getElementById('checkout-btn');
            const selectedCountElement = document.getElementById('selected-count');

            function updateTotal() {
                let total = 0;
                let selectedCount = 0;
                checkboxes.forEach(checkbox => {
                    if (checkbox.checked) {
                        total += parseFloat(checkbox.dataset.price);
                        selectedCount++;
                    }
                });
                totalPriceElement.textContent = total.toLocaleString('en-PH', {
                    minimumFractionDigits: 2
                });
                selectedCountElement.textContent = `${selectedCount} items selected`;
                checkoutBtn.disabled = selectedCount === 0;
            }

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateTotal);
            });
        });
    </script>
</x-app-layout>
