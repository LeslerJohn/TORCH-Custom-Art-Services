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
            <p class="mb-2"><strong>Quantity:</strong> {{ $request->quantity }}</p>
            <p class="mb-2"><strong>Order Type:</strong> {{ ucfirst($request->order_type) }}</p>

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
                <a href="mailto:torchtech2024@gmail.com" class="text-blue-500 underline">Contact Support</a>
            </p>
        </div>

        <!-- Buttons -->
        <div class="flex justify-end gap-4">
            @if ($request->status == 'pending')
                <button type="button" data-modal-target="cancel-request-modal" data-modal-toggle="cancel-request-modal"
                    class="px-4 py-2 bg-red-500 text-white rounded-lg shadow hover:bg-red-600 transition-colors">
                    Cancel Request
                </button>

                <!-- Cancel Request Modal -->
                <div id="cancel-request-modal" tabindex="-1"
                    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative p-4 w-full max-w-md max-h-full">
                        <div class="relative bg-white rounded-lg py-6 shadow-sm dark:bg-gray-700">
                            <button type="button"
                                class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                data-modal-hide="cancel-request-modal">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                            <div class="p-4 md:p-5 text-center">
                                <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to cancel
                                    this request?</h3>
                                <form action="{{ route('client.request.destroy', $request) }}" method="POST" class="space-x-4">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                                        Yes, Cancel Request
                                    </button>
                                    <button type="button" data-modal-hide="cancel-request-modal"
                                        class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                        No, Keep Request
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
