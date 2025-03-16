<x-artist-layout>
    <div class="flex justify-between items-center px-6 py-4 bg-white dark:bg-gray-800  mt-16">
        <h1 class="text-xl">Discounts</h1>
        <button data-modal-target="add-discount" data-modal-toggle="add-discount"
            class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
            type="button">
            Create Discount
        </button>
        <!-- Main modal -->
        <div id="add-discount" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                    <!-- Modal header -->
                    <div
                        class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            Create custom discounts
                        </h3>
                        <button type="button"
                            class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="add-discount">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-4 md:p-5">
                        <form class="space-y-4" action="{{ route('artist.discount.store') }}" method="POST">
                            @csrf

                            <!-- Artwork Selection -->
                            <div class="relative">
                                <label for="artwork"
                                    class="block text-sm font-medium text-gray-900 dark:text-white">Select
                                    Artwork</label>

                                <!-- Button to Open Dropdown -->
                                <button type="button" onclick="toggleDropdown()"
                                    class="w-full flex items-center justify-between bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white">
                                    <span id="selected-artwork-text">Select an artwork</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>

                                <!-- Dropdown List -->
                                <div id="artwork-dropdown"
                                    class="absolute mt-1 w-full bg-white border border-gray-300 rounded-lg shadow-lg max-h-60 overflow-y-auto dark:bg-gray-700 dark:border-gray-600 hidden">
                                    @foreach ($artworks->where('status', 'sale') as $artwork)
                                        <div onclick="selectArtwork(this)" data-id="{{ $artwork->id }}"
                                            data-title="{{ $artwork->title }}"
                                            data-price="{{ number_format($artwork->price, 2) }}"
                                            data-category="{{ $artwork->category->name ?? 'Uncategorized' }}"
                                            data-thumbnail="{{ $artwork->images->first()?->attachment ? asset('storage/' . $artwork->images->first()->attachment->path) : asset('images/default.image.jpg') }}"
                                            class="flex items-center p-2 hover:bg-gray-100 dark:hover:bg-gray-600 cursor-pointer">

                                            <!-- Artwork Image -->
                                            <img src="{{ $artwork->images->first()?->attachment ? asset('storage/' . $artwork->images->first()->attachment->path) : asset('images/default.image.jpg') }}"
                                                alt="Artwork Image" class="w-12 h-12 rounded-lg object-cover">

                                            <!-- Artwork Details -->
                                            <div class="ml-3">
                                                <p class="text-sm font-medium text-gray-900 dark:text-white">
                                                    {{ $artwork->title }}</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-300">
                                                    ₱{{ number_format($artwork->price, 2) }}</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                                    {{ $artwork->category->name ?? 'Uncategorized' }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Hidden Input to Store Selected Artwork ID -->
                                <input type="hidden" name="artwork_id" id="selected-artwork-id">
                            </div>

                            <!-- JavaScript -->
                            <script>
                                function toggleDropdown() {
                                    document.getElementById("artwork-dropdown").classList.toggle("hidden");
                                }

                                function selectArtwork(element) {
                                    // Get selected artwork details
                                    let artworkId = element.getAttribute("data-id");
                                    let artworkTitle = element.getAttribute("data-title");
                                    let artworkPrice = element.getAttribute("data-price");
                                    let artworkCategory = element.getAttribute("data-category");
                                    let artworkImage = element.getAttribute("data-thumbnail");

                                    // Update UI with selected artwork
                                    document.getElementById("selected-artwork-text").innerHTML = `
                                        <div class="flex items-center">
                                            <img src="${artworkImage}" class="w-8 h-8 rounded-lg object-cover mr-2">
                                            <div>
                                                <p class="text-sm font-medium">${artworkTitle}</p>
                                                <p class="text-xs text-gray-500">₱${artworkPrice} | ${artworkCategory}</p>
                                            </div>
                                        </div>
                                    `;

                                    // Store selected artwork ID
                                    document.getElementById("selected-artwork-id").value = artworkId;

                                    // Hide dropdown after selection
                                    document.getElementById("artwork-dropdown").classList.add("hidden");
                                }
                            </script>

                            <!-- Discount Type Selection -->
                            <div class="mt-4">
                                <label class="block text-sm font-medium text-gray-900 dark:text-white">Discount
                                    Type</label>
                                <div class="flex space-x-4 mt-2">
                                    <!-- Percentage Button -->
                                    <button type="button" id="percentage-btn"
                                        onclick="selectDiscountType('percentage')"
                                        class="flex-1 py-2.5 px-4 text-sm font-medium text-center rounded-lg border border-gray-300 bg-gray-50 text-gray-900 hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-600 dark:text-white dark:border-gray-500 dark:hover:bg-blue-700">
                                        Percentage (e.g., 10% off)
                                    </button>

                                    <!-- Fixed Amount Button -->
                                    <button type="button" id="fixed-btn" onclick="selectDiscountType('fixed')"
                                        class="flex-1 py-2.5 px-4 text-sm font-medium text-center rounded-lg border border-gray-300 bg-gray-50 text-gray-900 hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-600 dark:text-white dark:border-gray-500 dark:hover:bg-blue-700">
                                        Fixed Amount (e.g., ₱100 off)
                                    </button>
                                </div>

                                <!-- Hidden Input to Store Selected Discount Type -->
                                <input type="hidden" id="discount_type" name="value_type" value="">

                                <p class="mt-1 text-sm text-green-600 dark:text-gray-400">Choose the type of discount you
                                    want to apply.</p>
                            </div>

                            <!-- Discount Value Input -->
                            <div class="mt-4">
                                <label for="discount_value"
                                    class="block text-sm font-medium text-gray-900 dark:text-white">Discount
                                    Value</label>
                                <input type="number" id="discount_value" name="value" max="75"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                    placeholder="Enter discount value" required>
                                <p class="mt-1 text-sm text-green-600 dark:text-gray-400">For percentage discounts, the maximum value is 75%.</p>
                                <p class="mt-1 text-sm text-green-600 dark:text-gray-400">For fixed amount discounts, the maximum value is 75% of the artwork price.</p>
                            </div>

                            <!-- JavaScript for Selecting Discount Type -->
                            <script>
                                function selectDiscountType(type) {
                                    document.getElementById('discount_type').value = type;

                                    // Get button elements
                                    let percentageBtn = document.getElementById('percentage-btn');
                                    let fixedBtn = document.getElementById('fixed-btn');

                                    // Reset styles
                                    percentageBtn.classList.remove('bg-blue-500', 'text-white');
                                    fixedBtn.classList.remove('bg-blue-500', 'text-white');

                                    // Apply active styles
                                    if (type === 'percentage') {
                                        percentageBtn.classList.add('bg-blue-500', 'text-white');
                                        percentageBtn.classList.remove('bg-gray-50', 'text-gray-900');
                                        document.getElementById('discount_value').max = 75;
                                    } else {
                                        fixedBtn.classList.add('bg-blue-500', 'text-white');
                                        fixedBtn.classList.remove('bg-gray-50', 'text-gray-900');
                                        document.getElementById('discount_value').removeAttribute('max');
                                    }
                                }
                            </script>


                            <!-- Submit Button -->
                            <button type="submit"
                                class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                Apply Discount
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3 bg-gray-50 dark:bg-gray-800">
                        Name
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3 bg-gray-50 dark:bg-gray-800">
                        Type
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Value
                    </th>
                    <th scope="col" class="px-6 py-3 bg-gray-50 dark:bg-gray-800">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse($discounts as $discount)
                    <tr class="border-b border-gray-200 dark:border-gray-700">
                        <th scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                            {{ $discount->artwork->title }}
                        </th>
                        <td class="px-6 py-4">
                            <form action="{{ route('artist.discount.status-update', $discount) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <select name="status" onchange="this.form.submit()" class="text-gray-900 text-sm rounded-lg border-none {{ $discount->status == 'active' ? 'text-green-600' : 'text-red-600' }}">
                                    <option value="active" {{ $discount->status == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ $discount->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </form>
                        </td>
                        <td class="px-6 py-4 bg-gray-50 dark:bg-gray-800">
                            {{ $discount->type == 'off_product' ? 'Amount off artwork' : 'Amount off order' }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $discount->value }} {{ $discount->value_type == 'percentage' ? '%' : '₱' }}
                        </td>
                        <td class="px-6 py-4">
                            <!-- Edit Button -->
                            <button data-modal-target="edit-discount-{{ $discount->id }}" data-modal-toggle="edit-discount-{{ $discount->id }}"
                                class="text-white bg-yellow-500 hover:bg-yellow-600 focus:ring-4 focus:outline-none focus:ring-yellow-300 font-medium rounded-lg text-sm px-4 py-2.5 text-center dark:bg-yellow-400 dark:hover:bg-yellow-500 dark:focus:ring-yellow-600"
                                type="button">
                                Edit
                            </button>

                            <!-- Edit Modal -->
                            <div id="edit-discount-{{ $discount->id }}" tabindex="-1" aria-hidden="true"
                                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                <div class="relative p-4 w-full max-w-md max-h-full">
                                    <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                                Edit Discount
                                            </h3>
                                            <button type="button"
                                                class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                                data-modal-hide="edit-discount-{{ $discount->id }}">
                                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 14 14">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                </svg>
                                                <span class="sr-only">Close modal</span>
                                            </button>
                                        </div>
                                        <div class="p-4 md:p-5">
                                            <form class="space-y-4" action="{{ route('artist.discount.update', $discount) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="mt-4">
                                                    <label for="discount_value_{{ $discount->id }}"
                                                        class="block text-sm font-medium text-gray-900 dark:text-white">Discount Value</label>
                                                    <input type="number" id="discount_value_{{ $discount->id }}" name="value"
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                                        value="{{ $discount->value }}" required>
                                                </div>
                                                <div class="mt-4">
                                                    <label for="value_type_{{ $discount->id }}"
                                                        class="block text-sm font-medium text-gray-900 dark:text-white">Discount Type</label>
                                                    <select id="value_type_{{ $discount->id }}" name="value_type"
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required>
                                                        <option value="percentage" {{ $discount->value_type == 'percentage' ? 'selected' : '' }}>Percentage</option>
                                                        <option value="fixed" {{ $discount->value_type == 'fixed' ? 'selected' : '' }}>Fixed Amount</option>
                                                    </select>
                                                </div>
                                                <button type="submit"
                                                    class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                                    Update Discount
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Delete Button -->
                            <form action="{{ route('artist.discount.destroy', $discount) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-4 py-2.5 text-center dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-800"
                                    onclick="return confirm('Are you sure you want to delete this discount?')">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            No discounts found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-artist-layout>
