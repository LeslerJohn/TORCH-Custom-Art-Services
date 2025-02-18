<x-app-layout>
    <div class="max-w-5xl mt-10 mx-auto bg-white p-6 rounded-lg mb-8 shadow-lg relative">
        <!-- Header based on status -->
        <div
            class="mb-4 absolute top-0 left-0 right-0 rounded-lg 
            {{ $commission->status == 'done' ? 'bg-green-100' : ($commission->status == 'wip' ? 'bg-yellow-100' : ($commission->status == 'ready' ? 'bg-blue-100' : ($commission->status == 'completed' ? 'bg-gray-100' : 'bg-red-100')) }}">
            <h1 class="text-2xl font-bold p-4">
            @if ($commission->status == 'done')
                Your artwork is ready to be delivered!
            @elseif ($commission->status == 'wip')
                Your commission is in progress.
            @elseif ($commission->status == 'ready')
                Awaiting artist to start your commission.
            @elseif ($commission->status == 'completed')
                Awaiting artist to start your commission.
            @else
                Your commission has been cancelled.
            @endif
            </h1>
        </div>

        <!-- Status on Top Right -->
        <div class="absolute top-6 right-6">
            <span
                class="px-4 py-2 rounded-full text-white 
            {{ $commission->status == 'completed' ? 'bg-green-500' : ($commission->status == 'in_progress' ? 'bg-yellow-500' : 'bg-red-500') }}">
                {{ ucfirst($commission->status ?? 'in_progress') }}
            </span>
        </div>

        <div class="mb-6 mt-12">
            <h1 class="text-2xl font-bold mb-2">{{ $commission->request->service->category->name }}</h1>
            <h2 class="text-red-500 text-xl mb-2">₱{{ number_format($commission->request->total_price, 2) }}</h2>
            <p class="mb-2">{{ $commission->request->description }}</p>
            <p class="mb-2"><strong>Dimension:</strong> {{ $commission->request->width }} x {{ $commission->request->height }}
                {{ $commission->request->unit }}</p>
            <p class="mb-2"><strong>Deadline:</strong>
                {{ \Carbon\Carbon::parse($commission->deadline)->format('F j, Y') }}</p>
        </div>

        <!-- Drafts -->
        <div class="mb-8">
            <h2 class="text-xl font-semibold mb-2">Drafts</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                @foreach ($commission->drafts as $draft)
                    <div class="border rounded-lg overflow-hidden">
                        <img src="{{ asset('storage/' . $draft->attachment->path) }}" alt="Draft Image" class="w-full h-auto">
                        <p class="p-2 text-sm">{{ $draft->description }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Delivery Information -->
        <div class="mb-6">
            <h2 class="text-xl font-semibold mb-2">Delivery Details</h2>
            <p><strong>Contact Number:</strong> +63{{ $commission->delivery->contact_number }}</p>
            <p><strong>Address:</strong> {{ $commission->delivery->address->barangay }}, {{ $commission->delivery->address->street }}, House No. {{ $commission->delivery->address->house_number }}</p>
            <p><strong>Expected Delivery:</strong> {{ \Carbon\Carbon::parse($commission->delivery->expected_delivery)->format('F j, Y') }}</p>
        </div>

        <!-- Support Center & Commission Details -->
        <div class="mb-6">
            <h2 class="text-xl font-semibold mb-2">Support Center</h2>
            <p class="text-gray-600">Having issues with your commission?
                <a href="#" class="text-blue-500 underline">Contact Support</a>
            </p>
        </div>

        @if ($commission->status == 'done')
            <div class="flex justify-end space-x-4">
                <a href="" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600">
                    Request Refund
                </a>
                <a href="" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                    Leave a Review
                </a>
            </div>
        @endif
    </div>
</x-app-layout>
