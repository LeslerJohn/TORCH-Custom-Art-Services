<x-artist-layout>
    <div class="max-w-5xl mt-10 mx-auto bg-white p-6 rounded-lg mb-8 shadow-lg relative">
        <!-- Deadline Highlighted -->
        <div class="absolute top-6 left-6">
            <span class="px-4 py-2 rounded-full text-white bg-red-500">
                Deadline: {{ \Carbon\Carbon::parse($commission->deadline)->format('F j, Y') }}
            </span>
        </div>

        <!-- Status Display -->
        <div class="absolute top-6 right-6">
            <span class="px-4 py-2 rounded-full text-white 
            {{ $commission->status == 'ready' ? 'bg-blue-500' : 
                ($commission->status == 'wip' ? 'bg-yellow-500' : 
                ($commission->status == 'done' ? 'bg-green-500' : 'bg-gray-500')) }}">
                {{ ucfirst($commission->status) }}
            </span>
        </div>

        <!-- Commission Details -->
        <div class="mb-6 mt-12">
            <h1 class="text-2xl font-bold mb-2">Commission for {{ $commission->request->service->category->name }}</h1>
            <h2 class="text-red-500 text-xl mb-2">₱{{ number_format($commission->request->total_price, 2) }}</h2>
            <p class="mb-2">{{ $commission->request->description }}</p>
            <p class="mb-2"><strong>Dimensions:</strong> {{ $commission->request->width }} x {{ $commission->request->height }} {{ $commission->request->unit }}</p>
        </div>

        <!-- Drafts Section -->
        <div class="mb-8">
            <h2 class="text-xl font-semibold mb-2">Drafts</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                @foreach ($commission->drafts as $draft)
                    <div class="border rounded-lg overflow-hidden">
                        <img src="{{ asset('storage/' . $draft->attachment->path) }}" alt="Draft Image" class="w-full h-auto">
                        <p class="text-sm p-2">{{ $draft->description }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Delivery Address -->
        <div class="mb-6">
            <h2 class="text-xl font-semibold mb-2">Delivery Address</h2>
            <p><strong>Contact:</strong> {{ $commission->delivery->contact_number }}</p>
            <p><strong>Address:</strong> {{ $commission->delivery->address->full_address }}</p>
        </div>

        <!-- Action Buttons Based on Status -->
        <div class="flex justify-end gap-4">
            @if ($commission->status == 'ready')
                <form action="{{ route('artist.commission.start', $commission) }}" method="POST">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg shadow">Start</button>
                </form>
            @elseif ($commission->status == 'wip')
                <button data-modal-target="draft-modal" data-modal-toggle="draft-modal" 
                    class="px-4 py-2 bg-yellow-500 text-white rounded-lg shadow">Send Draft</button>
                <form action="{{ route('artist.commission.mark_done', $commission) }}" method="POST">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-lg shadow">Mark Done</button>
                </form>
            @elseif ($commission->status == 'done')
                <form action="{{ route('artist.commission.deliver', $commission) }}" method="POST">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg shadow">Deliver</button>
                </form>
            @elseif ($commission->status == 'delivered')
                <form action="{{ route('artist.commission.complete', $commission) }}" method="POST">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-gray-600 text-white rounded-lg shadow">Completed</button>
                </form>
            @endif
        </div>

        <!-- Draft Upload Modal -->
        <div id="draft-modal" tabindex="-1" aria-hidden="true" 
            class="hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <div class="relative bg-white rounded-lg shadow-lg">
                    <div class="p-4 border-b">
                        <h3 class="text-xl font-semibold">Upload Draft</h3>
                    </div>
                    <div class="p-4">
                        <form action="{{ route('artist.commission.draft', $commission) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="draft" required class="mb-2">
                            <textarea name="description" class="w-full p-2 border rounded-lg" placeholder="Draft description" required></textarea>
                            <button type="submit" class="mt-4 w-full bg-yellow-500 text-white py-2 rounded-lg">Send Draft</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-artist-layout>
