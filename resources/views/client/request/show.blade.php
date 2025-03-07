<x-app-layout>
    <div class="max-w-5xl mt-10 mx-auto bg-white p-6 rounded-lg mb-8 shadow-lg relative">
        <!-- Header based on status -->
        <div
            class="mb-4 absolute top-0 left-0 right-0 rounded-lg 
            {{ $request->status == 'accepted' ? 'bg-green-100' : ($request->status == 'pending' ? 'bg-yellow-100' : 'bg-red-100') }}">
            <h1 class="text-2xl font-bold p-4">
                @if ($request->status == 'accepted')
                    Your request has been accepted! Make payment to proceed.
                @elseif ($request->status == 'pending')
                    The artist is reviewing your request.
                @else
                    Your request has been rejected.
                @endif
            </h1>
        </div>

        <!-- Status on Top Right -->
        <div
            class="absolute top-6 right-6 rounded-lg 
            {{ $request->status == 'accepted' ? 'bg-green-100' : ($request->status == 'pending' ? 'bg-yellow-100' : 'bg-red-100') }}">
            <span
            class="px-4 py-2 rounded-full text-white 
            {{ $request->status == 'accepted' ? 'bg-green-300' : ($request->status == 'pending' ? 'bg-yellow-300' : 'bg-red-300') }}">
            {{ ucfirst($request->status ?? 'pending') }}
            </span>
        </div>

        <div class="mb-6 mt-12">
            <h1 class="text-2xl font-bold mb-2">{{ $request->service->category->name }}</h1>
            <h2 class="text-red-500 text-xl mb-2">₱{{ number_format($request->total_price, 2) }}</h2>
            <p class="mb-2">{{ $request->description }}</p>
            <p class="mb-2"><strong>Dimension:</strong> {{ $request->width }} x {{ $request->height }}
                {{ $request->unit == 'in' ? 'inches' : 'centimeters' }}</p>
            <p class="mb-2"><strong>Estimated Arival:</strong>
                {{ \Carbon\Carbon::parse($request->deadline)->addDays(5)->format('j') }} - {{ \Carbon\Carbon::parse($request->deadline)->addDays(10)->format('j F, Y') }}</p>
        </div>

        <!-- Reference Images -->
        <div class="mb-8">
            <h2 class="text-xl font-semibold mb-2">Reference Images</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                @foreach ($request->images as $image)
                    <div class="border rounded-lg overflow-hidden">
                        <img src="{{ asset('storage/' . $image->attachment->path) }}" alt="Reference Image"
                            class="w-full h-auto">
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Support Center & request Details -->
        <div class="mb-6">
            <h2 class="text-xl font-semibold mb-2">Support Center</h2>
            <p class="text-gray-600">Having issues with your request?
                <a href="#" class="text-blue-500 underline">Contact Support</a>
            </p>
        </div>

        <!-- Buttons -->
        <div class="flex justify-end gap-4">
            @if ($request->status == 'pending')
                <form action="{{ route('client.request.destroy', $request) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-lg shadow">Cancel
                        request</button>
                </form>
            @elseif ($request->status == 'accepted' && !$request->commissions->first())
                <button data-modal-target="authentication-modal" data-modal-toggle="authentication-modal"
                    class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                    type="button">
                    Make Payment
                </button>
            @endif
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
                            Commission Payment
                        </h3>
                        <button type="button"
                            class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="authentication-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="flex gap-2 justify-center p-4 md:p-5">
                        <div class="w-1/2">
                            <p class="mb-3 text-xl text-red-600 font-bold"><strong>Total:
                                </strong>₱{{ number_format($request->total, 0, '.', ',') }}</p>
                            <div class="flex gap-4 items-center">
                                <img src="{{ $request->images->first()?->attachment ? asset('storage/' . $request->images->first()->attachment->path) : asset('images/default.image.jpg') }}"
                                    alt="{{ $request->description }}" class="w-16 h-16 object-cover rounded-lg">
                                <div>
                                    <h1 class="text-lg font-bold">{{ $request->description }}</h1>
                                    <p class="text-sm text-gray-500">
                                        {{ $request->service->artist->user->name ?? 'Unknown' }}</p>
                                </div>
                            </div>
                            <div class="flex items-center mt-4 w-full max-w-sm border border-black rounded-md p-2">
                                <p class="text-sm mr-4">Accepts</p>
                                <img src="{{ asset('images/paymongo.png') }}" alt="Paymongo" class="h-4">
                            </div>
                            <div class="mt-4 flex flex-col gap-2">
                                <div class="flex items-center gap-2">
                                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                        viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="1"
                                            d="M13 7h6l2 4m-8-4v8m0-8V6a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v9h2m8 0H9m4 0h2m4 0h2v-4m0 0h-5m3.5 5.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Zm-10 0a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Z" />
                                    </svg>
                                    <p class="text-sm">Shipping within Zamboanga is Free.</p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                        viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="1"
                                            d="M8.5 11.5 11 14l4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                    <p class="text-sm">7-day money back guarantee.</p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                        viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="1"
                                            d="M10 3v4a1 1 0 0 1-1 1H5m4 10v-2m3 2v-6m3 6v-3m4-11v16a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V7.914a1 1 0 0 1 .293-.707l3.914-3.914A1 1 0 0 1 9.914 3H18a1 1 0 0 1 1 1Z" />
                                    </svg>
                                    <p class="text-sm">Quality assured.</p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="1" d="M6 6l12 12M6 18L18 6" />
                                    </svg>
                                    <p class="text-sm">Not refundable once paid.</p>
                                </div>
                            </div>
                        </div>
                        <form class="space-y-4 w-1/2" action="{{ route('client.commission.store', $request) }}"
                            method="POST">
                            @csrf
                            <h1 class="text-xl font-bold">Address</h1>
                            <div>
                                <x-input-label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                    for="contact_number" :value="__('Contact Number')" />
                                <div class="flex">
                                    <span
                                        class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">+63</span>
                                    <x-text-input id="contact_number" class="block w-full rounded-l-none"
                                        type="text" name="contact_number" placeholder="9123456789"
                                        :value="old('contact_number')" required autocomplete="username" />
                                </div>
                                <x-input-error :messages="$errors->get('contact_number')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                    for="barangay" :value="__('Barangay')" />
                                <x-text-input id="barangay" class="block mt-1 w-full" type="text"
                                    name="barangay" placeholder="Canelar" :value="old('barangay')" required
                                    autocomplete="barangay" />
                                <x-input-error :messages="$errors->get('barangay')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                    for="street" :value="__('Street/Drive')" />
                                <x-text-input id="street" class="block mt-1 w-full" type="text" name="street"
                                    placeholder="Gregorio" :value="old('street')" required autocomplete="street" />
                                <x-input-error :messages="$errors->get('street')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                    for="house_number" :value="__('House Number')" />
                                <x-text-input id="house_number" class="block mt-1 w-full" type="text"
                                    name="house_number" placeholder="C-1276" :value="old('house_number')" required
                                    autocomplete="house_number" />
                                <x-input-error :messages="$errors->get('house_number')" class="mt-2" />
                            </div>
                            <button type="submit"
                                class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Continue</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
