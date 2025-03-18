<x-artist-layout>
    <div class="max-w-5xl mt-10 p-6 relative bg-white shadow-lg rounded-lg">
        <!-- Status on Top Right -->
        <div class="absolute top-6 right-6">
            <span class="px-4 py-2 rounded-full text-white 
                {{ $request->status == 'accepted' ? 'bg-green-500' : ($request->status == 'pending' ? 'bg-yellow-500' : 'bg-red-500') }}">
                {{ ucfirst($request->status ?? 'Pending') }}
            </span>
        </div>

        <div class="flex flex-col lg:flex-row">
            <div class="flex-1 mb-6">
                <h1 class="text-2xl font-bold mb-2">{{ $request->service->category->name }}</h1>
                <h2 class="text-red-500 text-xl mb-2">₱{{ number_format($request->total_price, 2) }}</h2>
                <p class="mb-2">{{ $request->description }}</p>
                <p class="mb-2"><strong>Dimension:</strong> {{ $request->width }} x {{ $request->height }} {{ $request->unit }}</p>
                <p class="mb-2"><strong>Quantity:</strong> {{ $request->quantity }}</p>
                <p class="mb-2"><strong>Order Type:</strong> {{ ucfirst($request->order_type) }}</p>
                <div class="relative flex items-center justify-start gap-2 mb-4">
                    <p><strong>Deadline:</strong> {{ \Carbon\Carbon::parse($request->deadline)->format('F j, Y') }}</p>
                    <button data-tooltip-target="tooltip-deadline" type="button" class="ml-2">
                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 13V8m0 8h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                        </svg>
                    </button>
                    <div id="tooltip-deadline" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-black transition-opacity duration-300 bg-gray-300 rounded-lg shadow-xs opacity-0 tooltip">
                        <p class="text-sm">The deadline can be extended for 5 days upon acceptance.</p>
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>
                </div>

                <!-- Client Information -->
                <div class="mb-6">
                    <h2 class="text-xl font-semibold mb-2">Client Information</h2>
                    <p class="mb-2"><strong>Name:</strong> {{ $request->client->user->name }}</p>
                    <p class="mb-2"><strong>Email:</strong> {{ $request->client->user->email }}</p>
                    <p class="mb-2"><strong>Phone:</strong> (+63) {{ $request->client->user->phone_number }}</p>
                </div>

                <!-- Delivery Information -->
                <div class="mb-6">
                    <h2 class="text-xl font-semibold mb-2">Delivery Information</h2>
                    <p class="mb-2"><strong>Address:</strong> {{ $request->client->user->address->house_number . ' ' . $request->client->user->address->street . ' ' . $request->client->user->address->barangay }}</p>
                    <p class="mb-2"><strong>City:</strong> {{ 'Zamboanga' }}</p>
                    <p class="mb-2"><strong>Postal Code:</strong> 7000</p>
                </div>
            </div>

            <!-- Reference Images -->
            <div class="lg:w-1/2 lg:ml-2 lg:mt-12 mb-8">
                <h2 class="text-xl font-semibold mb-2">Reference Images</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-4">
                    @foreach ($request->images as $image)
                        <div class="border rounded-lg overflow-hidden">
                            <a href="{{ asset('storage/' . $image->attachment->path) }}" download>
                                <img src="{{ asset('storage/' . $image->attachment->path) }}" alt="Reference Image" class="w-full h-auto" style="width: 100%; height: auto; max-height: 500px;">
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Buttons -->
        <div class="flex flex-col sm:flex-row justify-start gap-4">
            @if ($request->status == 'pending')
                <form action="{{ route('artist.request.accept', $request) }}" method="POST">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-lg shadow">Accept request</button>
                </form>
                <form action="{{ route('artist.request.reject', $request) }}" method="POST">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-lg shadow">Reject request</button>
                </form>
            @endif
        </div>
    </div>
</x-artist-layout>