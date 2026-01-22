<x-artist-layout>
    <div class="max-w-6xl mx-auto my-8 px-4">
        <!-- Header with back button and status badge -->
        <div class="flex justify-between items-center mb-4 mt-16">
            <a href="{{ route('artist.commission.index') }}" class="inline-flex items-center text-gray-600 hover:text-gray-900 transition-colors">
                <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m12 19-7-7 7-7"></path>
                    <path d="M19 12H5"></path>
                </svg>
                <span class="font-medium">Back to Commissions</span>
            </a>

            <div class="flex items-center">
                <span class="px-4 py-1.5 rounded-full text-sm font-medium
                    {{ $request->status == 'accepted' ? 'bg-green-100 text-green-800' : 
                    ($request->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                    {{ ucfirst($request->status ?? 'Pending') }}
                </span>
            </div>
        </div>

        <!-- Main content card -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <!-- Commission header -->
            <div class="bg-gradient-to-r from-orange-400 to-orange-600 p-6 text-white">
                <h1 class="text-2xl font-bold mb-2">{{ $request->service->category->name }}</h1>
                <div class="flex items-center space-x-2">
                    {{-- <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                    </svg> --}}
                    <span class="text-xl font-semibold">₱{{ number_format($request->total_price, 2) }}</span>
                </div>
            </div>

            <!-- Content grid -->
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 p-6">
                <!-- Left column (3/5) -->
                <div class="lg:col-span-3 space-y-6">
                    <!-- Commission details -->
                    <div class="space-y-4">
                        <h2 class="text-lg font-semibold border-b pb-2">Commission Details</h2>

                        <p class="text-gray-700">{{ $request->description }}</p>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-gray-50 p-3 rounded-lg">
                                <p class="text-sm text-gray-500 mb-1">Dimensions</p>
                                <p class="font-medium">{{ $request->width }} × {{ $request->height }} {{ $request->unit }}</p>
                            </div>

                            <div class="bg-gray-50 p-3 rounded-lg">
                                <p class="text-sm text-gray-500 mb-1">Quantity</p>
                                <p class="font-medium">{{ $request->quantity }}</p>
                            </div>

                            <div class="bg-gray-50 p-3 rounded-lg">
                                <p class="text-sm text-gray-500 mb-1">Order Type</p>
                                <p class="font-medium">{{ ucfirst($request->order_type) }}</p>
                            </div>

                            <div class="bg-gray-50 p-3 rounded-lg">
                                <div class="flex items-center">
                                    <div>
                                        <p class="text-sm text-gray-500 mb-1">Deadline</p>
                                        <p class="font-medium">{{ \Carbon\Carbon::parse($request->deadline)->format('F j, Y') }}</p>
                                    </div>
                                    <button data-tooltip-target="tooltip-deadline" type="button" class="ml-2 text-gray-400 hover:text-gray-600">
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <line x1="12" y1="16" x2="12" y2="12"></line>
                                            <line x1="12" y1="8" x2="12.01" y2="8"></line>
                                        </svg>
                                    </button>
                                    <div id="tooltip-deadline" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                        The deadline can be extended for 5 days upon acceptance.
                                        <div class="tooltip-arrow" data-popper-arrow></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Client information -->
                    <div class="space-y-4">
                        <h2 class="text-lg font-semibold border-b pb-2">Client Information</h2>

                        <div class="flex items-start space-x-3">
                            <div class="bg-orange-100 rounded-full p-2">
                                <svg class="w-5 h-5 text-orange-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium">{{ $request->client->user->name }}</p>
                                <p class="text-gray-600 text-sm">{{ $request->client->user->email }}</p>
                                <p class="text-gray-600 text-sm">(+63) {{ $request->client->user->phone_number }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Delivery information -->
                    <div class="space-y-4">
                        <h2 class="text-lg font-semibold border-b pb-2">Delivery Information</h2>

                        <div class="flex items-start space-x-3">
                            <div class="bg-orange-100 rounded-full p-2">
                                <svg class="w-5 h-5 text-orange-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium">{{ $request->client->user->address->house_number . ' ' . $request->client->user->address->street }}</p>
                                <p class="text-gray-600 text-sm">{{ $request->client->user->address->barangay }}, Zamboanga City 7000</p>
                            </div>
                        </div>
                    </div>

                    <!-- Action buttons -->
                    @if ($request->status == 'pending')
                    <div class="flex flex-wrap gap-3 mt-6">
                        <form action="{{ route('artist.request.accept', $request) }}" method="POST">
                            @csrf
                            <button type="submit" class="px-6 py-2.5 bg-orange-500 hover:bg-orange-700 text-white font-medium rounded-lg transition-colors">
                                Accept Request
                            </button>
                        </form>

                        <form action="{{ route('artist.request.reject', $request) }}" method="POST">
                            @csrf
                            <button type="submit" class="px-6 py-2.5 bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 font-medium rounded-lg transition-colors">
                                Reject Request
                            </button>
                        </form>
                    </div>
                    @endif
                </div>

                <!-- Right column (2/5) - Reference Images -->
                <div class="lg:col-span-2">
                    <h2 class="text-lg font-semibold border-b pb-2 mb-4">Reference Images</h2>

                    <div class="grid grid-cols-1 gap-4">
                        @foreach ($request->images as $image)
                        <div class="group relative rounded-lg overflow-hidden bg-gray-100 border border-gray-200">
                            <a href="{{ asset('storage/' . $image->attachment->path) }}" class="block relative" download>
                                <img src="{{ asset('storage/' . $image->attachment->path) }}" alt="Reference Image" class="w-full h-auto object-cover">
                                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 flex items-center justify-center transition-all duration-200">
                                    <div class="p-2 bg-white rounded-full opacity-0 group-hover:opacity-100 transition-opacity">
                                        <svg class="w-5 h-5 text-gray-700" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                            <polyline points="7 10 12 15 17 10"></polyline>
                                            <line x1="12" y1="15" x2="12" y2="3"></line>
                                        </svg>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-artist-layout>