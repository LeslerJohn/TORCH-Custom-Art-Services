<x-app-layout>
    <div class="max-w-6xl my-8 mx-auto">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <!-- Cart Header -->
            <div class="bg-gradient-to-r from-orange-500 to-amber-600 p-6">
                <h1 class="text-3xl font-bold text-white flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    Your Cart
                </h1>
            </div>

            <!-- Cart Content -->
            <div class="p-6">
                @if ($cart && $cart->items->count() > 0)
                <form id="cart-form" action="{{ route('client.cart.checkout', $cart) }}" method="POST">
                    @csrf

                    <!-- Select All Option -->
                    <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-200">
                        <div class="flex items-center">
                            <input type="checkbox" id="select-all" class="w-5 h-5 text-orange-500 rounded" onchange="toggleSelectAll(this)">
                            <label for="select-all" class="ml-2 text-lg font-medium text-gray-700">Select All</label>
                        </div>
                        <div class="flex items-center">
                            <span id="total-selected" class="text-gray-600 mr-6">0 Selected</span>
                            <span id="total-price" class="text-xl font-bold text-orange-500">₱0.00</span>
                        </div>
                    </div>

                    <!-- Artworks Grouped by Artist -->
                    <div class="space-y-8">
                        @php
                        $groupedItems = $cart->items->groupBy(fn($item) => $item->artwork->artist->user->name);
                        @endphp

                        @foreach ($groupedItems as $artistName => $items)
                        <div class="border border-gray-200 rounded-lg overflow-hidden">
                            <!-- Artist Header -->
                            <div class="bg-gray-50 p-4 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                                </svg>
                                <h2 class="text-lg font-semibold text-gray-800">{{ $artistName }}</h2>
                            </div>

                            <!-- Artist Items -->
                            <div class="divide-y divide-gray-200">
                                @foreach ($items as $item)
                                <div class="p-4 hover:bg-gray-50 transition-colors">
                                    <div class="flex items-center gap-6">
                                        <!-- Selection & Status -->
                                        <div class="w-10 flex-shrink-0">
                                            @if ($item->artwork->status === 'sold')
                                            <span class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-red-500 rounded">SOLD</span>
                                            @else
                                            <input type="checkbox" name="selected_items[]" value="{{ $item->id }}"
                                                class="artwork-checkbox w-5 h-5 text-orange-500 rounded cursor-pointer"
                                                data-price="{{ $item->artwork->discount && $item->artwork->discount->status === 'active' ? 
                                                    ($item->artwork->discount->value_type === 'percentage' ? 
                                                        $item->artwork->price * (1 - $item->artwork->discount->value / 100) : 
                                                        $item->artwork->price - $item->artwork->discount->value) : 
                                                    $item->artwork->price }}"
                                                onchange="updateTotal()">
                                            @endif
                                        </div>

                                        <!-- Artwork Image -->
                                        @php
                                        $thumbnail = $item->artwork->images->first()?->attachment;
                                        @endphp
                                        <div class="w-24 h-24 flex-shrink-0 overflow-hidden rounded-lg border border-gray-200">
                                            <img src="{{ $thumbnail ? asset("storage/{$thumbnail->path}") : asset('images/default-image.jpg') }}"
                                                alt="{{ $item->artwork->title }}" class="w-full h-full object-cover">
                                        </div>

                                        <!-- Artwork Details -->
                                        <div class="flex-1">
                                            <h3 class="text-lg font-medium text-gray-900">{{ $item->artwork->title }}</h3>
                                            <p class="text-sm text-gray-500">{{ $item->artwork->category->name }}</p>
                                        </div>

                                        <!-- Pricing -->
                                        <div class="text-right">
                                            @if ($item->artwork->discount && $item->artwork->discount->status === 'active')
                                            @php
                                            $discount = $item->artwork->discount;
                                            $discountedPrice = $discount->value_type === 'percentage' ?
                                            $item->artwork->price * (1 - $discount->value / 100) :
                                            $item->artwork->price - $discount->value;
                                            @endphp
                                            <div class="flex items-center mb-1">
                                                <span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded bg-green-100 text-green-800">
                                                    {{ $discount->value }}{{ $discount->value_type === 'percentage' ? '%' : '₱' }} OFF
                                                </span>
                                            </div>
                                            <p class="text-sm text-gray-400 line-through">₱{{ number_format($item->artwork->price, 2) }}</p>
                                            <p class="text-lg font-bold text-red-600">₱{{ number_format($discountedPrice, 2) }}</p>
                                            @else
                                            <p class="text-lg font-bold text-gray-900">₱{{ number_format($item->artwork->price, 2) }}</p>
                                            @endif
                                        </div>

                                        <!-- Remove Button -->
                                        <div class="ml-4">
                                            <button type="button" onclick="openModal('{{ $item->artwork->id }}')"
                                                class="flex items-center text-gray-500 hover:text-red-600 transition-colors">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Checkout Button -->
                    <div class="mt-8 flex justify-end">
                        <button type="button" id="checkout-button"
                            class="flex items-center px-8 py-3 text-lg font-medium text-white bg-orange-500 rounded-lg shadow-md hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
                            disabled onclick="openCheckoutModal()">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
                            </svg>
                            Checkout
                        </button>
                    </div>
                </form>
                @else
                <!-- Empty Cart State -->
                <div class="flex flex-col items-center justify-center py-16">
                    <div class="mb-6 bg-gray-100 rounded-full p-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800 mb-2">Your cart is empty</h2>
                    <p class="text-gray-600 mb-8 text-center max-w-md">Looks like you haven't added any artworks to your cart yet. Explore our collection to find something you love!</p>
                    <a href="{{ route('client.artwork') }}"
                        class="inline-flex items-center px-6 py-3 bg-orange-500 text-white font-medium rounded-lg shadow-md hover:bg-orange-700 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Browse Artworks
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="popup-modal" tabindex="-1"
        class="hidden fixed top-0 left-0 w-full h-full flex items-center justify-center bg-black bg-opacity-50 z-50">
        <div class="bg-white p-6 rounded-xl shadow-xl max-w-sm text-center relative">
            <button type="button" class="absolute top-3 right-3 text-gray-400 hover:text-gray-900 transition-colors"
                onclick="closeModal()">
                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <div class="p-2 mx-auto mb-4 bg-red-100 rounded-full w-16 h-16 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>

            <h3 class="mb-5 text-lg font-medium text-gray-800">
                Remove from Cart
            </h3>

            <p class="mb-5 text-gray-600">
                Are you sure you want to remove this artwork from your cart?
            </p>

            <!-- Delete Form -->
            <form id="delete-form" action="" method="POST" class="flex justify-center space-x-4">
                @csrf
                @method('DELETE')
                <button type="button" onclick="closeModal()"
                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300 transition-colors">
                    Cancel
                </button>
                <button type="submit"
                    class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 transition-colors">
                    Yes, Remove
                </button>
            </form>
        </div>
    </div>

    <!-- Checkout Details Modal -->
    <div id="checkout-modal" tabindex="-1"
        class="hidden fixed top-0 left-0 w-full h-full flex items-center justify-center bg-black bg-opacity-50 z-50">
        <div class="bg-white p-8 rounded-xl shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto relative">
            <button type="button" class="absolute top-4 right-4 text-gray-400 hover:text-gray-900 transition-colors"
                onclick="closeCheckoutModal()">
                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <div class="mb-6">
                <h3 class="text-2xl font-bold text-gray-800 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Confirm Your Order
                </h3>
                <p class="text-gray-600">Please review your selected items before placing your order.</p>
            </div>

            <div class="mb-8">
                <h4 class="text-lg font-medium text-gray-800 mb-3">Selected Artworks</h4>
                <div id="checkout-details" class="bg-gray-50 p-4 rounded-lg max-h-64 overflow-y-auto divide-y divide-gray-200">
                    <!-- Selected artworks will be populated here -->
                </div>
            </div>

            <div class="mb-8">
                <h4 class="text-lg font-medium text-gray-800 mb-3">Shipping Details</h4>
                <div class="bg-gray-50 p-4 rounded-lg">
                    @if(Auth::user()->phone_number && Auth::user()->address)
                    <div class="flex items-start">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-2 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <div>
                            <p class="font-medium text-gray-800">{{ Auth::user()->name }}</p>
                            <p class="text-gray-600">{{ Auth::user()->phone_number }}</p>
                            <p class="text-gray-600">{{ Auth::user()->address->house_number . ' ' . Auth::user()->address->street . ' ' . Auth::user()->address->barangay }}</p>
                        </div>
                    </div>
                    @else
                    <div class="text-center p-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-red-500 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <p class="text-red-600 font-medium mb-2">Missing Shipping Information</p>
                        <p class="text-gray-600 mb-4">Please update your profile with your phone number and address to complete your order.</p>
                        <a href="{{ route('profile.edit') }}" class="inline-flex items-center px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition-colors">
                            Update Profile
                        </a>
                    </div>
                    @endif
                </div>
            </div>

            <div class="flex justify-between items-center border-t border-gray-200 pt-4">
                <div>
                    <p id="modal-total-selected" class="text-gray-600">0 Items</p>
                    <p id="modal-total-price" class="text-xl font-bold text-orange-500">₱0.00</p>
                </div>
                <div class="flex space-x-4">
                    <button type="button" onclick="closeCheckoutModal()"
                        class="px-5 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                        Cancel
                    </button>
                    @if(Auth::user()->phone_number && Auth::user()->address)
                    <button type="submit" form="cart-form"
                        class="px-5 py-2 text-white bg-orange-500 rounded-lg hover:bg-orange-700 transition-colors flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Place Order
                    </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        // Toggle Select All
        function toggleSelectAll(checkbox) {
            const artworkCheckboxes = document.querySelectorAll('.artwork-checkbox:not([disabled])');
            artworkCheckboxes.forEach(box => {
                box.checked = checkbox.checked;
            });
            updateTotal();
        }

        // Update Total Price and Selected Count
        function updateTotal() {
            const checkboxes = document.querySelectorAll('input[name="selected_items[]"]:checked');
            let totalPrice = 0;
            let totalSelected = checkboxes.length;

            checkboxes.forEach(checkbox => {
                totalPrice += parseFloat(checkbox.getAttribute('data-price'));
            });

            // Update main display
            document.getElementById('total-price').innerText = `₱${totalPrice.toFixed(2)}`;
            document.getElementById('total-selected').innerText = `${totalSelected} Selected`;

            // Enable or disable checkout button
            const checkoutButton = document.getElementById('checkout-button');
            checkoutButton.disabled = totalSelected === 0;

            // Update select all checkbox state
            updateSelectAllCheckbox();
        }

        // Update select all checkbox based on individual selections
        function updateSelectAllCheckbox() {
            const selectAllCheckbox = document.getElementById('select-all');
            const artworkCheckboxes = document.querySelectorAll('.artwork-checkbox:not([disabled])');
            const checkedBoxes = document.querySelectorAll('.artwork-checkbox:checked');

            selectAllCheckbox.checked = checkedBoxes.length > 0 && checkedBoxes.length === artworkCheckboxes.length;
            selectAllCheckbox.indeterminate = checkedBoxes.length > 0 && checkedBoxes.length < artworkCheckboxes.length;
        }

        // Remove Item Modal
        function openModal(artworkId) {
            if (!artworkId) {
                console.error("Artwork ID is undefined");
                return;
            }

            const modal = document.getElementById("popup-modal");
            const deleteForm = document.getElementById("delete-form");

            // Set form action
            deleteForm.action = `/cart/remove/${artworkId}`;

            // Show modal
            modal.classList.remove("hidden");
            modal.classList.add("flex");
        }

        function closeModal() {
            const modal = document.getElementById("popup-modal");
            modal.classList.add("hidden");
            modal.classList.remove("flex");
        }

        // Checkout Modal
        function openCheckoutModal() {
            const modal = document.getElementById("checkout-modal");
            const checkoutDetails = document.getElementById("checkout-details");
            const checkboxes = document.querySelectorAll('input[name="selected_items[]"]:checked');

            // Clear previous content
            checkoutDetails.innerHTML = '';

            // Build the details HTML
            checkboxes.forEach(checkbox => {
                const item = checkbox.closest('.flex');
                const imageUrl = item.querySelector('img').src;
                const title = item.querySelector('h3').innerText;
                const category = item.querySelector('.text-gray-500').innerText;
                const price = checkbox.getAttribute('data-price');

                const itemElement = document.createElement('div');
                itemElement.className = 'py-3 first:pt-0 last:pb-0';
                itemElement.innerHTML = `
                    <div class="flex items-center gap-4">
                        <img src="${imageUrl}" alt="${title}" class="w-12 h-12 object-cover rounded">
                        <div class="flex-1">
                            <h5 class="font-medium text-gray-800">${title}</h5>
                            <p class="text-sm text-gray-500">${category}</p>
                        </div>
                        <p class="font-medium text-gray-800">₱${parseFloat(price).toFixed(2)}</p>
                    </div>
                `;

                checkoutDetails.appendChild(itemElement);
            });

            // Update totals in modal
            const totalPrice = document.getElementById('total-price').innerText;
            const totalSelected = document.getElementById('total-selected').innerText;

            document.getElementById('modal-total-price').innerText = totalPrice;
            document.getElementById('modal-total-selected').innerText = `${totalSelected}`;

            // Show modal
            modal.classList.remove("hidden");
            modal.classList.add("flex");
        }

        function closeCheckoutModal() {
            const modal = document.getElementById("checkout-modal");
            modal.classList.add("hidden");
            modal.classList.remove("flex");
        }

        // Initialize totals on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateTotal();
        });
    </script>
</x-app-layout>