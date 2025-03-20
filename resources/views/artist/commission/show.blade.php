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
                        : ($commission->status == 'hold'
                            ? 'bg-red-500'
                            : 'bg-gray-500'))) }}">
                {{ ucfirst($commission->status) }}
            </span>
        </div>

        @if ($commission->status == 'hold')
        <div class="absolute top-16 right-4 bg-red-100 border border-red-500 text-red-700 p-4 rounded-lg">
            <h3 class="font-bold">Refund Requested</h3>
            <p><strong>Reason:</strong> {{ $commission->refund->reason }}</p>
            <p><strong>Requested On:</strong>
                {{ \Carbon\Carbon::parse($commission->refund->created_at)->format('F j, Y') }}
            </p>
            <p><strong>Status:</strong> {{ ucfirst($commission->refund->status) }}</p>
            @if ($commission->refund->status == 'denied')
            <p class="text-red-500"><strong>Note:</strong> Your refund request has been denied.</p>
            @endif
        </div>

        <!-- Main Content Area -->
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Commission Details Section -->
                <div>
                    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Commission Details</h2>

                    <div class="mb-4">
                        <h3 class="text-lg font-medium text-gray-700">{{ $commission->request->service->category->name }} Commission</h3>
                        <p class="text-red-500 text-xl">₱{{ number_format($commission->request->total_price, 2) }}</p>
                        <p class="text-gray-600">{{ $commission->request->description }}</p>
                    </div>

                    <div class="mb-4">
                        <h4 class="text-md font-semibold text-gray-700">Details:</h4>
                        <p class="text-gray-600"><strong>Dimensions:</strong> {{ $commission->request->width }} x {{ $commission->request->height }} {{ $commission->request->unit }}</p>
                        <p class="text-gray-600"><strong>Quantity:</strong> {{ $commission->request->quantity }}</p>
                        <p class="text-gray-600"><strong>Order Type:</strong> {{ ucfirst($commission->request->order_type) }}</p>
                    </div>

                    <div class="mb-4">
                        <h4 class="text-md font-semibold text-gray-700">Client Details:</h4>
                        <p class="text-gray-600"><strong>Name:</strong> {{ $commission->request->client->user->name }}</p>
                        <p class="text-gray-600"><strong>Email:</strong> {{ $commission->request->client->user->email }}</p>
                    </div>

                    <div class="mb-4">
                        <h4 class="text-md font-semibold text-gray-700">Delivery Details:</h4>
                        <p class="text-gray-600"><strong>Status:</strong> {{ ucfirst($commission->delivery->status) }}</p>
                        <p class="text-gray-600"><strong>Contact:</strong> (+63) {{ $commission->request->client->user->phone_number }}</p>
                        <p class="text-gray-600"><strong>Address:</strong> {{ $commission->delivery->address->barangay }}, {{ $commission->delivery->address->street }}, House No. {{ $commission->delivery->address->house_number }}</p>
                    </div>

                    @if ($commission->extension)
                    <div class="mb-4 border rounded-md p-4 bg-gray-50">
                        <h4 class="text-md font-semibold text-gray-700">Extension Request:</h4>
                        <p class="text-gray-600"><strong>Status:</strong> {{ ucfirst($commission->extension->status) }}</p>
                        <p class="text-gray-600"><strong>Reason:</strong>
                            @if ($commission->status == 'wip')
                            {{ $commission->extension->reason }}
                            @else
                            {{ $commission->extension->reason }} (was requested)
                            @endif
                        </p>
                        @if ($commission->extension->status == 'denied')
                        <p class="text-red-500"><strong>Note:</strong> Your extension request has been denied.</p>
                        @endif
                    </div>
                    @endif

                    @if ($commission->status == 'hold')
                    <div class="mb-4 border border-red-400 rounded-md p-4 bg-red-50">
                        <h4 class="text-md font-semibold text-red-700">Refund Requested:</h4>
                        <p class="text-gray-600"><strong>Reason:</strong> {{ $commission->refund->reason }}</p>
                        <p class="text-gray-600"><strong>Requested On:</strong> {{ \Carbon\Carbon::parse($commission->refund->created_at)->format('F j, Y') }}</p>
                        <p class="text-gray-600"><strong>Status:</strong> {{ ucfirst($commission->refund->status) }}</p>
                        @if ($commission->refund->status == 'denied')
                        <p class="text-red-500"><strong>Note:</strong> Your refund request has been denied.</p>
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
                        @elseif ($commission->status == 'done' && $commission->delivery->status == 'pending')
                        <form action="{{ route('artist.commission.deliver', $commission) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="px-4 py-2 bg-green-600 text-white rounded-lg shadow">Deliver</button>
                        </form>
                        @elseif ($commission->status == 'done' && $commission->delivery->status == 'in-transit')
                        <!-- Modal Trigger -->
                        <button type="button"
                            class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 mt-4 shadow-md"
                            onclick="document.getElementById('proofModal').classList.remove('hidden')">
                            Mark as Delivered
                        </button>

                        <!-- Modal -->
                        <div id="proofModal"
                            class="fixed inset-0 bg-gray-800 bg-opacity-50 z-40 flex items-center justify-center hidden">
                            <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
                                <h2 class="text-lg font-semibold text-gray-800 mb-4">Upload Proof of Delivery</h2>
                                <form action="{{ route('artist.commission.delivered', $commission) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="space-y-4">
                                        <label class="block">
                                            <span class="text-gray-700">Upload up to 5 images:</span>
                                            <input type="file" name="proof_images[]" accept="image/*" multiple
                                                class="block w-full mt-1 text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer focus:outline-none focus:ring focus:ring-orange-500">
                                        </label>
                                        <p class="text-sm text-gray-500">You can upload up to 5 images as proof of
                                            delivery.</p>
                                    </div>
                                    <div class="flex justify-end mt-6">
                                        <button type="button"
                                            class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400 mr-2"
                                            onclick="document.getElementById('proofModal').classList.add('hidden')">
                                            Cancel
                                        </button>
                                        <button type="submit"
                                            class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                                            Submit
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @elseif ($commission->delivery->status === 'delivered')
                        <div class="bg-gray-50 p-6 rounded-md mt-8 shadow-md">
                            <h2 class="text-lg font-semibold text-gray-800 mb-4">Proof of Delivery</h2>
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                @foreach ($commission->delivery->proofs as $proof)
                                <div class="relative group">
                                    <img src="{{ asset('storage/' . $proof->attachment->path) }}" alt="Proof of Delivery"
                                        class="w-full h-32 object-cover rounded-md shadow-md">
                                    <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-md">
                                        <a href="{{ asset('storage/' . $proof->attachment->path) }}" target="_blank"
                                            class="text-white text-sm font-semibold underline">
                                            View Full Image
                                        </a>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                <!-- Action Buttons -->
                <div class="flex flex-wrap gap-3 mt-4">
                    @if ($commission->status == 'ready')
                    <form action="{{ route('artist.commission.start', $commission) }}" method="POST">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1">Start</button>
                    </form>
                    @elseif ($commission->status == 'wip')
                    <button data-modal-target="draft-modal" data-modal-toggle="draft-modal" class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-1">Send Draft</button>
                    @if ($commission->deadline > now() && !$commission->extension)
                    <button data-modal-target="extension-modal" data-modal-toggle="extension-modal" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1">Request Extension</button>
                    @endif
                    <form action="{{ route('artist.commission.done', $commission) }}" method="POST">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-1">Mark Done</button>
                    </form>
                    @elseif ($commission->status == 'done' && $commission->delivery->status == 'pending')
                    <form action="{{ route('artist.commission.deliver', $commission) }}" method="POST">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-1">Deliver</button>
                    </form>
                    @elseif ($commission->status == 'delivered')
                    <form action="{{ route('artist.commission.complete', $commission) }}" method="POST">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-600 focus:ring-offset-1">Completed</button>
                    </form>
                    @endif
                </div>
            </div>

            <!-- Drafts Section -->
            <div>
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Drafts</h2>
                <div class="grid grid-cols-1 gap-4">
                    @if($commission->drafts->isEmpty())
                    <p class="text-gray-500">No drafts uploaded yet.</p>
                    @else
                    @foreach ($commission->drafts as $draft)
                    <div class="border rounded-md overflow-hidden shadow-sm">
                        <img src="{{ asset('storage/' . $draft->attachment->path) }}" alt="Draft Image" class="w-full h-48 object-cover">
                        <p class="text-sm p-2 text-gray-700">{{ $draft->description }}</p>
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Draft Modal -->
    <div id="draft-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 md:inset-0 h-modal md:h-full justify-center items-center flex">
        <div class="relative p-4 w-full max-w-md h-full md:h-auto">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow ">
                <!-- Modal header -->
                <div class="flex justify-between items-center p-5 rounded-t border-b ">
                    <h3 class="text-xl font-medium text-gray-900 ">
                        Upload Draft
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center " data-modal-toggle="draft-modal">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-6 space-y-6">
                    <form action="{{ route('artist.commission.draft', $commission) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Choose Image:</label>
                            <input type="file" name="image" accept="image/*" id="draft-input" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                        <img id="draft-preview" src="#" alt="Draft Preview" class="hidden w-full h-auto mb-4 rounded-md">
                        <div class="mb-4">
                            <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description:</label>
                            <textarea name="description" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Draft description" required></textarea>
                        </div>

                        <button type="submit" class="w-full bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Send Draft
                        </button>
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
                    <form action="{{ route('artist.commission.request-extension', $commission) }}"
                        method="POST">
                        @csrf
                        <textarea name="reason" class="w-full p-2 border rounded-lg" placeholder="Reason for extension" required></textarea>
                        <button type="submit" class="mt-4 w-full bg-blue-500 text-white py-2 rounded-lg">Request
                            Extension</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Extension Modal -->
    <div id="extension-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 md:inset-0 h-modal md:h-full justify-center items-center flex">
        <div class="relative p-4 w-full max-w-md h-full md:h-auto">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow ">
                <!-- Modal header -->
                <div class="flex justify-between items-center p-5 rounded-t border-b ">
                    <h3 class="text-xl font-medium text-gray-900 ">
                        Request Extension
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center " data-modal-toggle="extension-modal">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-6 space-y-6">
                    <form action="{{ route('artist.commission.request-extension', $commission) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="reason" class="block text-gray-700 text-sm font-bold mb-2">Reason for Extension:</label>
                            <textarea name="reason" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Reason for extension" required></textarea>
                        </div>

                        <button type="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Request Extension
                        </button>
                    </form>
                </div>

            </div>
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
</x-artist-layout>