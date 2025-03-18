<x-artist-layout>
    <div class="max-w-5xl mt-16 p-6 relative bg-white shadow-lg rounded-lg">
        <!-- Deadline Highlighted -->
        <div class="absolute top-6 left-4">
            <span class="px-4 py-2 rounded-full text-white bg-red-500">
                Deadline: {{ \Carbon\Carbon::parse($commission->deadline)->format('F j, Y') }}
                @if ($commission->is_extended)
                    (Extended to {{ \Carbon\Carbon::parse($commission->extended_deadline)->format('F j, Y') }})
                @endif
            </span>
        </div>

        <!-- Status Display -->
        <div class="absolute top-6 right-4">
            <span
                class="px-4 py-2 rounded-full text-white 
            {{ $commission->status == 'ready'
                ? 'bg-blue-500'
                : ($commission->status == 'wip'
                    ? 'bg-yellow-500'
                    : ($commission->status == 'done'
                        ? 'bg-green-500'
                        : 'bg-gray-500')) }}">
                {{ ucfirst($commission->status) }}
            </span>
        </div>

        <!-- Commission Details and Drafts Container -->
        <div class="flex flex-col md:flex-row gap-6 mt-12">
            <!-- Commission Details -->
            <div class="flex-1">
                <h1 class="text-2xl font-bold mb-2">{{ $commission->request->service->category->name }} Commission</h1>
                <h2 class="text-red-500 text-xl mb-2">₱{{ number_format($commission->request->total_price, 2) }}</h2>
                <p class="mb-2">{{ $commission->request->description }}</p>
                <p class="mb-2"><strong>Dimensions:</strong> {{ $commission->request->width }} x
                    {{ $commission->request->height }} {{ $commission->request->unit }}</p>
                <p class="mb-2"><strong>Quantity:</strong> {{ $commission->request->quantity }}</p>
                <p class="mb-2"><strong>Order Type:</strong> {{ ucfirst($commission->request->order_type) }}</p>

                <!-- Client Details -->
                <div class="mt-6">
                    <h2 class="text-xl font-semibold mb-2">Client Details</h2>
                    <p><strong>Name: </strong>{{ $commission->request->client->user->name }}</p>
                    <p><strong>Email: </strong>{{ $commission->request->client->user->email }}</p>
                </div>

                <!-- Delivery Address -->
                <div class="mt-6">
                    <h2 class="text-xl font-semibold mb-2">Delivery Details</h2>
                    <p><strong>Status: </strong>{{ ucfirst($commission->delivery->status) }}</p>
                    <p><strong>Contact: </strong> (+63) {{ $commission->request->client->user->phone_number }}</p>
                    <p><strong>Address:</strong> {{ $commission->delivery->address->barangay }},
                        {{ $commission->delivery->address->street }}, House No.
                        {{ $commission->delivery->address->house_number }}</p>
                </div>

                @if ($commission->extension)
                    <div class="mt-6">
                        <h2 class="text-xl font-semibold mb-2">Extension Request</h2>
                        <p><strong>Status: </strong>{{ ucfirst($commission->extension->status) }}</p>
                        <p><strong>Reason: </strong>
                            @if ($commission->status == 'wip')
                                {{ $commission->extension->reason }}
                            @else
                                {{ $commission->extension->reason }} (was requested)
                            @endif
                        </p>
                        @if ($commission->extension->status == 'denied')
                            <p class="text-red-500"><strong>Note: </strong>Your extension request has been denied.</p>
                        @endif
                    </div>
                @endif

                <!-- Action Buttons Based on Status -->
                <div class="flex flex-wrap justify-start gap-4 mt-6">
                    @if ($commission->status == 'ready')
                        <form action="{{ route('artist.commission.start', $commission) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="px-4 py-2 bg-blue-500 text-white rounded-lg shadow">Start</button>
                        </form>
                    @elseif ($commission->status == 'wip')
                        <button data-modal-target="draft-modal" data-modal-toggle="draft-modal"
                            class="px-4 py-2 bg-yellow-500 text-white rounded-lg shadow">Send Draft</button>
                        @if ($commission->deadline > now() && !$commission->extension)
                            <button data-modal-target="extension-modal" data-modal-toggle="extension-modal"
                                class="px-4 py-2 bg-blue-500 text-white rounded-lg shadow">
                                Request Extension
                            </button>
                        @endif
                        <form action="{{ route('artist.commission.done', $commission) }}" method="POST">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-lg shadow">Mark
                                Done</button>
                        </form>
                    @elseif ($commission->status == 'done')
                        <form action="{{ route('artist.commission.deliver', $commission) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="px-4 py-2 bg-green-600 text-white rounded-lg shadow">Deliver</button>
                        </form>
                    @elseif ($commission->status == 'delivered')
                        <form action="{{ route('artist.commission.complete', $commission) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="px-4 py-2 bg-gray-600 text-white rounded-lg shadow">Completed</button>
                        </form>
                    @endif
                </div>
            </div>

            <!-- Drafts Section -->
            <div class="flex-1">
                <h2 class="text-xl font-semibold mb-2">Drafts</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @foreach ($commission->drafts as $draft)
                        <div class="border rounded-lg overflow-hidden shadow-lg bg-white">
                            <img src="{{ asset('storage/' . $draft->attachment->path) }}" alt="Draft Image"
                                class="w-full h-48 object-cover">
                            <p class="text-sm p-2">{{ $draft->description }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div id="draft-modal" tabindex="-1" aria-hidden="true"
            class="hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full h-full overflow-y-auto">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <div class="relative bg-white rounded-lg shadow-lg">
                    <div class="p-4 border-b">
                        <h3 class="text-xl font-semibold">Upload Draft</h3>
                    </div>
                    <div class="p-4">
                        <form action="{{ route('artist.commission.draft', $commission) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="image" accept="image/*" id="draft-input" required
                                class="mb-2">
                            <img id="draft-preview" src="#" alt="Draft Preview"
                                class="hidden w-full h-auto mb-2">
                            <textarea name="description" class="w-full p-2 border rounded-lg" placeholder="Draft description" required></textarea>
                            <button type="submit" class="mt-4 w-full bg-yellow-500 text-white py-2 rounded-lg">Send
                                Draft</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div id="extension-modal" tabindex="-1" aria-hidden="true"
            class="hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full h-full overflow-y-auto">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <div class="relative bg-white rounded-lg shadow-lg">
                    <div class="p-4 border-b">
                        <h3 class="text-xl font-semibold">Request Extension</h3>
                    </div>
                    <div class="p-4">
                        <form action="{{ route('artist.commission.request-extension', $commission) }}" method="POST">
                            @csrf
                            <textarea name="reason" class="w-full p-2 border rounded-lg" placeholder="Reason for extension" required></textarea>
                            <button type="submit" class="mt-4 w-full bg-blue-500 text-white py-2 rounded-lg">Request
                                Extension</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.getElementById('draft-input').addEventListener('change', function(event) {
                const [file] = event.target.files;
                if (file) {
                    const preview = document.getElementById('draft-preview');
                    preview.src = URL.createObjectURL(file);
                    preview.classList.remove('hidden');
                }
            });
        </script>
    </div>
</x-artist-layout>
