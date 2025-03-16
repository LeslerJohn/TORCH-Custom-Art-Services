<x-app-layout>
    <div class="max-w-5xl my-4 mx-auto bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold mb-4">Your Cart</h1>

        @if ($cart && $cart->items->count() > 0)
            <form action="{{ route('client.cart.checkout', $cart) }}" method="POST">
                @csrf

                <div class="space-y-6">
                    @php
                        $groupedItems = $cart->items->groupBy(fn($item) => $item->artwork->artist->user->name);
                    @endphp

                    @foreach ($groupedItems as $artistName => $items)
                        <div class="p-4 border border-gray-300 rounded-lg">
                            <h2 class="text-xl font-semibold mb-2">{{ $artistName }}</h2>

                            @foreach ($items as $item)
                                <div class="flex gap-4 p-2 bg-gray-50 rounded-lg items-center">
                                    <!-- Checkbox (Disabled if Sold) -->
                                    @if ($item->artwork->status === 'sold')
                                        <span class="text-red-500 font-bold">Sold</span>
                                    @else
                                        <input type="checkbox" name="selected_items[]" value="{{ $item->id }}" data-price="{{ $item->artwork->discount && $item->artwork->discount->status === 'active' ? ($item->artwork->discount->value_type === 'percentage' ? $item->artwork->price * (1 - $item->artwork->discount->value / 100) : $item->artwork->price - $item->artwork->discount->value) : $item->artwork->price }}" onchange="updateTotal()">
                                    @endif

                                    <!-- Artwork Image -->
                                    @php
                                        $thumbnail = $item->artwork->images->first()?->attachment;
                                    @endphp
                                    <img src="{{ $thumbnail ? asset("storage/{$thumbnail->path}") : asset('images/default-image.jpg') }}"
                                        alt="{{ $item->artwork->title }}" class="w-24 h-24 object-cover rounded-md">

                                    <!-- Artwork Details -->
                                    <div class="flex-1 flex justify-between">
                                        <div>
                                            <h3 class="text-md font-semibold">{{ $item->artwork->title }}</h3>
                                            <p class="text-sm text-gray-400">{{ $item->artwork->category->name }}</p>
                                            @if ($item->artwork->discount && $item->artwork->discount->status === 'active')
                                                @php
                                                    $discount = $item->artwork->discount;
                                                    $discountedPrice = $discount->value_type === 'percentage' ? $item->artwork->price * (1 - $discount->value / 100) : $item->artwork->price - $discount->value;
                                                @endphp
                                                <p class="text-sm text-green-500">Discount: {{ $discount->value }}{{ $discount->value_type === 'percentage' ? '%' : '₱' }}</p>
                                                <p class="text-sm text-gray-500 line-through">₱{{ number_format($item->artwork->price, 2) }}</p>
                                                <p class="text-red-500 text-md font-bold">₱{{ number_format($discountedPrice, 2) }}</p>
                                            @else
                                                <p class="text-red-500 text-md font-bold">₱{{ number_format($item->artwork->price, 2) }}</p>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Remove Button (Passes Artwork ID Instead of Cart Item ID) -->
                                    <button type="button" onclick="openModal('{{ $item->artwork->id }}')"
                                        class="text-red-500 hover:text-red-700 font-semibold text-sm"
                                        data-modal-target="popup-modal" data-modal-toggle="popup-modal">
                                        Remove
                                    </button>

                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>

                <!-- Total Price and Selected Artworks -->
                <div class="mt-6 text-right">
                    <p id="total-price" class="text-lg font-semibold">Total Price: ₱0.00</p>
                    <p id="total-selected" class="text-md text-gray-500">Total Selected Artworks: 0</p>
                </div>

                <!-- Checkout Button -->
                <div class="mt-6 text-right">
                    <button type="submit" id="checkout-button" class="bg-blue-500 text-white py-2 px-6 rounded-lg shadow" disabled>
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
                <a href="{{ route('client.artwork') }}"
                    class="bg-blue-500 text-white px-6 py-2 rounded-lg shadow-lg hover:bg-blue-600">
                    Browse Artworks
                </a>
            </div>
        @endif
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="popup-modal" tabindex="-1"
        class="hidden fixed top-0 left-0 w-full h-full flex items-center justify-center bg-black bg-opacity-50 z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-sm text-center dark:bg-gray-700 relative">
            <button type="button" class="absolute top-3 right-3 text-gray-400 hover:text-gray-900"
                onclick="closeModal()">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        d="M1 1l6 6m0 0l6 6M7 7l6-6M7 7L1 13" />
                </svg>
            </button>

            <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 20 20">
                <path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>

            <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
                Are you sure you want to remove this artwork from your cart?
            </h3>

            <!-- Delete Form (Separate from Main Form) -->
            <form id="delete-form" action="" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                    Yes, Remove
                </button>
                <button type="button" onclick="closeModal()"
                    class="py-2.5 px-5 ml-3 text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700">
                    No, Cancel
                </button>
            </form>
        </div>
    </div>

    <!-- JavaScript to Handle Modal and Total Calculation -->
    <script>
        function openModal(artworkId) {
            if (!artworkId) {
                console.error("Artwork ID is undefined");
                return;
            }

            const modal = document.getElementById("popup-modal");
            const deleteForm = document.getElementById("delete-form");

            // Correctly set the form action with the artwork ID
            deleteForm.action = `/cart/remove/${artworkId}`;

            // Show modal
            modal.classList.remove("hidden");
            modal.classList.add("flex");
        }

        function closeModal() {
            const modal = document.getElementById("popup-modal");

            // Hide modal
            modal.classList.add("hidden");
            modal.classList.remove("flex");
            modal.classList.remove("z-50");
        }

        function updateTotal() {
            const checkboxes = document.querySelectorAll('input[name="selected_items[]"]:checked');
            let totalPrice = 0;
            let totalSelected = checkboxes.length;

            checkboxes.forEach(checkbox => {
                totalPrice += parseFloat(checkbox.getAttribute('data-price'));
            });

            document.getElementById('total-price').innerText = `Total Price: ₱${totalPrice.toFixed(2)}`;
            document.getElementById('total-selected').innerText = `Total Selected Artworks: ${totalSelected}`;

            // Enable or disable the checkout button based on the number of selected items
            const checkoutButton = document.getElementById('checkout-button');
            checkoutButton.disabled = totalSelected === 0;
        }
    </script>
</x-app-layout>
