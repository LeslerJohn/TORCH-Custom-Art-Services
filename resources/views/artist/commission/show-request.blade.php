<x-artist-layout>
    <div class="max-w-5xl mt-10 p-6 relative">
        <!-- Status on Top Right -->
        <div class="absolute top-6 right-6">
            <span class="px-4 py-2 rounded-full text-white 
                {{ $request->status == 'accepted' ? 'bg-green-500' : ($request->status == 'pending' ? 'bg-yellow-500' : 'bg-red-500') }}">
                {{ ucfirst($request->status ?? 'Pending') }}
            </span>
        </div>

        <div class="mb-6">
            <h1 class="text-2xl font-bold mb-2">{{ $request->service->category->name }}</h1>
            <h2 class="text-red-500 text-xl mb-2">₱{{ number_format($request->total_price, 2) }}</h2>
            <p class="mb-2">{{ $request->description }}</p>
            <p class="mb-2"><strong>Dimension:</strong> {{ $request->width }} x {{ $request->height }} {{ $request->unit }}</p>
            <p class="mb-2"><strong>Deadline:</strong> {{ \Carbon\Carbon::parse($request->deadline)->format('F j, Y') }}</p>
        </div>

        <!-- Reference Images -->
        <div class="mb-8">
            <h2 class="text-xl font-semibold mb-2">Reference Images</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
            @foreach ($request->images as $image)
                <div class="border rounded-lg overflow-hidden">
                <img src="{{ asset('storage/' . $image->attachment->path) }}" alt="Reference Image" class="w-full h-auto">
                </div>
            @endforeach
            </div>
        </div>
    
        <!-- Buttons -->
        <div class="flex justify-start gap-4">
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