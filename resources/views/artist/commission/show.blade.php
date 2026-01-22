<x-artist-layout>
    <div class="max-w-6xl mx-auto mt-16 mb-16">
        <a href="{{ route('artist.commission.index') }}" class="inline-flex items-center text-gray-600 hover:text-gray-900 transition-colors mb-4">
            <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m12 19-7-7 7-7"></path>
                <path d="M19 12H5"></path>
            </svg>
            <span class="font-medium">Back to Commissions</span>
        </a>
        <!-- Commission Header Card -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <!-- Header Section with Status and Deadline -->
            <div class="relative bg-gradient-to-r from-indigo-600 to-indigo-800 p-6 text-white">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                    <div>
                        <h1 class="text-2xl font-bold">Commission #{{ $commission->id }}</h1>
                        <p class="text-indigo-100">{{ $commission->request->service->category->name }} Commission</p>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3 mt-4 md:mt-0">
                        <!-- Status Badge -->
                        <span class="px-4 py-2 rounded-full text-white text-sm font-medium
                            {{ $commission->status == 'ready' ? 'bg-blue-500' : 
                              ($commission->status == 'wip' ? 'bg-yellow-400' : 
                              ($commission->status == 'done' || $commission->status == 'completed'  ? 'bg-green-500' : 
                              ($commission->status == 'hold' ? 'bg-red-500' : 'bg-gray-500'))) }}">
                            {{ ucfirst($commission->status) }}
                        </span>

                        <!-- Deadline Badge -->
                        <span class="px-4 py-2 rounded-full text-white text-sm font-medium bg-red-500">
                            Due: {{ \Carbon\Carbon::parse($commission->deadline)->format('M j, Y') }}
                            @if ($commission->is_extended)
                            <span class="block text-xs mt-1">(Extended to {{ \Carbon\Carbon::parse($commission->extended_deadline)->format('M j, Y') }})</span>
                            @endif
                        </span>
                    </div>
                </div>
            </div>

            <!-- Main Content Section -->
            <div class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Column 1: Commission Details -->
                    <div class="lg:col-span-2">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Commission Details Card -->
                            <div class="bg-gray-50 p-5 rounded-lg">
                                <h2 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Commission Details</h2>

                                <div class="space-y-3 text-sm">
                                    <p class="text-red-500 text-xl font-bold">₱{{ number_format($commission->request->total_price, 2) }}</p>
                                    <p class="text-gray-700">{{ $commission->request->description }}</p>

                                    <div class="mt-4">
                                        <p><span class="font-medium">Dimensions:</span> {{ $commission->request->width }} x {{ $commission->request->height }} {{ $commission->request->unit }}</p>
                                        <p><span class="font-medium">Quantity:</span> {{ $commission->request->quantity }}</p>
                                        <p><span class="font-medium">Order Type:</span> {{ ucfirst($commission->request->order_type) }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Client & Delivery Details Card -->
                            <div class="bg-gray-50 p-5 rounded-lg">
                                <h2 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Client & Delivery</h2>

                                <div class="space-y-3 text-sm">
                                    <div>
                                        <h3 class="font-medium text-gray-700">Client:</h3>
                                        <p>{{ $commission->request->client->user->name }}</p>
                                        <p>{{ $commission->request->client->user->email }}</p>
                                        <p>(+63) {{ $commission->request->client->user->phone_number }}</p>
                                    </div>

                                    <div class="mt-3">
                                        <h3 class="font-medium text-gray-700">Delivery Status:</h3>
                                        <p>{{ ucfirst($commission->delivery->status) }}</p>
                                        <p>{{ $commission->delivery->address->barangay }}, {{ $commission->delivery->address->street }}, House No. {{ $commission->delivery->address->house_number }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Special Requests & Notifications -->
                        @if ($commission->extension || $commission->status == 'hold')
                        <div class="mt-6">
                            @if ($commission->extension)
                            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-4 rounded-md">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-blue-800">Extension Request</h3>
                                        <div class="mt-1 text-sm text-blue-700">
                                            <p><strong>Status:</strong> {{ ucfirst($commission->extension->status) }}</p>
                                            <p><strong>Reason:</strong> {{ $commission->extension->reason }}</p>
                                            @if ($commission->extension->status == 'denied')
                                            <p class="text-red-600 font-medium mt-1">Your extension request has been denied.</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            @if ($commission->status == 'hold')
                            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-md">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-red-800">Refund Requested</h3>
                                        <div class="mt-1 text-sm text-red-700">
                                            <p><strong>Reason:</strong> {{ $commission->refund->reason }}</p>
                                            <p><strong>Requested On:</strong> {{ \Carbon\Carbon::parse($commission->refund->created_at)->format('F j, Y') }}</p>
                                            <p><strong>Status:</strong> {{ ucfirst($commission->refund->status) }}</p>
                                            @if ($commission->refund->status == 'denied')
                                            <p class="font-medium mt-1">Your refund request has been denied.</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                        @endif

                        <!-- Action Buttons -->
                        <div class="mt-6 flex flex-wrap gap-3">
                            @if ($commission->status == 'ready')
                            <form action="{{ route('artist.commission.start', $commission) }}" method="POST">
                                @csrf
                                <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg text-sm transition-colors duration-200">Start Commission</button>
                            </form>
                            @elseif ($commission->status == 'wip')
                            <button data-modal-target="draft-modal" data-modal-toggle="draft-modal" class="px-5 py-2.5 bg-yellow-400 hover:bg-yellow-500 text-white font-medium rounded-lg text-sm transition-colors duration-200">
                                Send Draft
                            </button>

                            @if ($commission->deadline > now() && !$commission->extension)
                            <button data-modal-target="extension-modal" data-modal-toggle="extension-modal" class="px-5 py-2.5 bg-blue-500 hover:bg-blue-600 text-white font-medium rounded-lg text-sm transition-colors duration-200">
                                Request Extension
                            </button>
                            @endif

                            <form action="{{ route('artist.commission.done', $commission) }}" method="POST">
                                @csrf
                                <button type="submit" class="px-5 py-2.5 bg-green-500 hover:bg-green-600 text-white font-medium rounded-lg text-sm transition-colors duration-200">
                                    Mark as Done
                                </button>
                            </form>
                            @elseif ($commission->status == 'done' && $commission->delivery->status == 'pending')
                            <form action="{{ route('artist.commission.deliver', $commission) }}" method="POST">
                                @csrf
                                <button type="submit" class="px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg text-sm transition-colors duration-200">
                                    Start Delivery
                                </button>
                            </form>
                            @elseif ($commission->status == 'done' && $commission->delivery->status == 'in-transit')
                            <button type="button" class="px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg text-sm transition-colors duration-200"
                                onclick="document.getElementById('proofModal').classList.remove('hidden')">
                                Mark as Delivered
                            </button>
                            @elseif ($commission->status == 'delivered')
                            <form action="{{ route('artist.commission.complete', $commission) }}" method="POST">
                                @csrf
                                <button type="submit" class="px-5 py-2.5 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg text-sm transition-colors duration-200">
                                    Complete Commission
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>

                    <!-- Column 2: Drafts Gallery -->
                    <div>
                        <div class="bg-white border border-gray-100 rounded-lg shadow-sm">
                            <div class="bg-gray-50 px-4 py-3 border-b border-gray-100 rounded-t-lg">
                                <h2 class="text-lg font-semibold text-gray-800">Drafts</h2>
                            </div>

                            <div class="p-4">
                                @if($commission->drafts->isEmpty())
                                <div class="flex flex-col items-center justify-center py-8 text-center text-gray-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <p>No drafts uploaded yet</p>
                                    @if ($commission->status == 'wip')
                                    <button data-modal-target="draft-modal" data-modal-toggle="draft-modal" class="mt-4 px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                        Upload First Draft
                                    </button>
                                    @endif
                                </div>
                                @else
                                <div class="grid grid-cols-1 gap-4">
                                    @foreach ($commission->drafts as $draft)
                                    <div class="border rounded-md overflow-hidden shadow-sm group relative">
                                        <img src="{{ asset('storage/' . $draft->attachment->path) }}" alt="Draft Image" class="w-full h-48 object-cover">
                                        <div class="p-3 bg-white">
                                            <p class="text-sm text-gray-700">{{ $draft->description }}</p>
                                            <p class="text-xs text-gray-500 mt-1">{{ $draft->created_at->format('M j, Y g:i A') }}</p>
                                        </div>
                                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-200">
                                            <a href="{{ asset('storage/' . $draft->attachment->path) }}" target="_blank" class="bg-white text-gray-800 px-4 py-2 rounded-lg text-sm shadow-md transform translate-y-2 group-hover:translate-y-0 transition-transform duration-200">
                                                View Full Size
                                            </a>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Delivery Proof Gallery (if delivered) -->
                        @if ($commission->delivery->status === 'delivered')
                        <div class="mt-6 bg-white border border-gray-100 rounded-lg shadow-sm">
                            <div class="bg-gray-50 px-4 py-3 border-b border-gray-100 rounded-t-lg">
                                <h2 class="text-lg font-semibold text-gray-800">Proof of Delivery</h2>
                            </div>

                            <div class="p-4">
                                <div class="grid grid-cols-2 gap-3">
                                    @foreach ($commission->delivery->proofs as $proof)
                                    <div class="relative group overflow-hidden rounded-md shadow-sm">
                                        <img src="{{ asset('storage/' . $proof->attachment->path) }}" alt="Proof of Delivery" class="w-full h-32 object-cover">
                                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-200">
                                            <a href="{{ asset('storage/' . $proof->attachment->path) }}" target="_blank" class="bg-white text-gray-800 px-3 py-1 rounded text-xs shadow-md">
                                                View Full Size
                                            </a>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Draft Modal -->
    <div id="draft-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 md:inset-0 h-modal md:h-full justify-center items-center flex">
        <div class="relative p-4 w-full max-w-md h-full md:h-auto">
            <div class="relative bg-white rounded-lg shadow">
                <div class="flex justify-between items-center p-4 border-b rounded-t">
                    <h3 class="text-xl font-semibold text-gray-900">
                        Upload Draft
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-toggle="draft-modal">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
                <div class="p-6">
                    <form action="{{ route('artist.commission.draft', $commission) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Choose Image:</label>
                            <div class="relative border-2 border-dashed border-gray-300 rounded-lg p-6 text-center cursor-pointer hover:bg-gray-50 transition-colors duration-200" id="drop-area">
                                <input type="file" name="image" accept="image/*" id="draft-input" required class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                <div id="placeholder" class="flex flex-col items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <p class="text-sm text-gray-500">Click or drag an image here</p>
                                    <p class="text-xs text-gray-400 mt-1">PNG, JPG or JPEG up to 10MB</p>
                                </div>
                                <img id="draft-preview" src="#" alt="Draft Preview" class="hidden max-h-48 mx-auto rounded-md">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description:</label>
                            <textarea name="description" class="w-full px-3 py-2 text-gray-700 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Explain the draft to the client..." rows="3" required></textarea>
                        </div>

                        <button type="submit" class="w-full bg-yellow-400 hover:bg-yellow-500 border-blue-500 text-white font-medium py-2.5 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-1 transition-colors duration-200">
                            Send Draft
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Extension Modal -->
    <div id="extension-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 md:inset-0 h-modal md:h-full justify-center items-center flex">
        <div class="relative p-4 w-full max-w-md h-full md:h-auto">
            <div class="relative bg-white rounded-lg shadow">
                <div class="flex justify-between items-center p-4 border-b rounded-t">
                    <h3 class="text-xl font-semibold text-gray-900">
                        Request Deadline Extension
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-toggle="extension-modal">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
                <div class="p-6">
                    <form action="{{ route('artist.commission.request-extension', $commission) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="reason" class="block text-gray-700 text-sm font-bold mb-2">Reason for Extension:</label>
                            <textarea name="reason" class="w-full px-3 py-2 text-gray-700 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Please explain why you need more time..." rows="4" required></textarea>
                            <p class="text-xs text-gray-500 mt-2">Be detailed and honest about why you need an extension. The client will review this request.</p>
                        </div>

                        <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-medium py-2.5 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1 transition-colors duration-200">
                            Submit Request
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Proof of Delivery Modal -->
    <div id="proofModal" class="fixed inset-0 bg-black bg-opacity-50 z-40 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md overflow-hidden">
            <div class="p-4 border-b">
                <h2 class="text-lg font-semibold text-gray-800">Upload Proof of Delivery</h2>
            </div>
            <form action="{{ route('artist.commission.delivered', $commission) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="p-6">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Upload images (max 5):</label>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:bg-gray-50 transition-colors duration-200">
                            <input type="file" name="proof_images[]" accept="image/*" multiple class="hidden" id="proof-images">
                            <label for="proof-images" class="cursor-pointer">
                                <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="#b8b8b8" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-image-plus">
                                    <path d="M16 5h6" />
                                    <path d="M19 2v6" />
                                    <path d="M21 11.5V19a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h7.5" />
                                    <path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21" />
                                    <circle cx="9" cy="9" r="2" />
                                </svg>
                                <p class="mt-1 text-sm text-gray-600">Click to upload or drag and drop</p>
                                <p class="text-xs text-gray-500">PNG, JPG, JPEG up to 10MB</p>
                            </label>
                        </div>
                        <div id="preview-container" class="mt-4 grid grid-cols-3 gap-2 hidden"></div>
                        <p class="text-sm text-gray-500 mt-2">Upload clear photos showing the delivered commission.</p>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 flex justify-end">
                    <button type="button" class="bg-gray-200 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-300 mr-2 transition-colors duration-200" onclick="document.getElementById('proofModal').classList.add('hidden')">
                        Cancel
                    </button>
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors duration-200">
                        Confirm Delivery
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Draft image preview
        document.getElementById('draft-input').addEventListener('change', function(event) {
            const [file] = event.target.files;
            if (file) {
                const preview = document.getElementById('draft-preview');
                const placeholder = document.getElementById('placeholder');

                preview.src = URL.createObjectURL(file);
                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');
            }
        });

        // Proof images preview
        document.getElementById('proof-images').addEventListener('change', function(event) {
            const files = event.target.files;
            const container = document.getElementById('preview-container');

            // Clear previous previews
            container.innerHTML = '';

            if (files.length > 0) {
                container.classList.remove('hidden');

                for (let i = 0; i < Math.min(files.length, 5); i++) {
                    const file = files[i];
                    const div = document.createElement('div');
                    div.className = 'relative';

                    const img = document.createElement('img');
                    img.src = URL.createObjectURL(file);
                    img.className = 'h-24 w-full object-cover rounded';

                    div.appendChild(img);
                    container.appendChild(div);
                }
            } else {
                container.classList.add('hidden');
            }
        });
    </script>
</x-artist-layout>