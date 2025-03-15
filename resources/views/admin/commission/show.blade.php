<x-admin-layout>
    <div>
        <div class="flex gap-4 items-center mb-6">
            <a href="{{ route('admin.commission.index') }}"
                class="text-blue-600 hover:text-blue-800 flex items-center transition duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                Back
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Commission ID {{ $commission->id }}</h1>
        </div>
        <div class="flex bg-white shadow-md rounded-lg p-6 mb-6 gap-4">
            <div class="w-1/2">
                <!-- Header -->
                <h2 class="text-2xl font-bold text-gray-900 mb-6 border-b pb-3">Commission Details</h2>

                <!-- Details Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Client & Artist -->
                    <div>
                        <label class="text-gray-500 font-medium">Client Name</label>
                        <p class="text-gray-800 font-semibold">{{ $commission->request->client->user->name }}</p>
                    </div>
                    <div>
                        <label class="text-gray-500 font-medium">Artist Name</label>
                        <p class="text-gray-800 font-semibold">{{ $commission->request->service->artist->user->name }}
                        </p>
                    </div>

                    <!-- Artwork Info -->
                    <div>
                        <label class="text-gray-500 font-medium">Category</label>
                        <p class="text-gray-800">{{ $commission->request->service->category->name }}</p>
                    </div>
                    <div>
                        <label class="text-gray-500 font-medium">Deadline</label>
                        @if ($commission->is_extended && $commission->extended_deadline)
                            <p class="text-red-500 font-semibold">
                                {{ \Carbon\Carbon::parse($commission->extended_deadline)->format('F j, Y') }} (Extended)
                            </p>
                        @else
                            <p class="text-red-500 font-semibold">
                                {{ \Carbon\Carbon::parse($commission->deadline)->format('F j, Y') }}</p>
                        @endif
                        @if (!$commission->is_extended)
                            <form action="{{ route('admin.commission.extendDeadline', $commission) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="number" name="count" value="7" hidden>
                                <button type="submit" class="mt-2 px-3 py-1 bg-blue-100 text-blue-500 text-xs rounded-full" data-tooltip-target="tooltip-animation">Extend Deadline</button>
                            </form>
                            <div id="tooltip-animation" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-black transition-opacity duration-300 bg-gray-300 rounded-lg shadow-xs opacity-0 tooltip">
                                <p class="text-sm">Automatically add 7 days extension.</p>
                                <div class="tooltip-arrow" data-popper-arrow></div>
                            </div>
                        @endif
                    </div>

                    <!-- Progress & Status -->
                    <div>
                        <label class="text-gray-500 font-medium">Quantity</label>
                        <p class="text-gray-800 text-sm mt-1">{{$commission->request->quantity}}</p>
                    </div>
                    
                    <div class="flex flex-col">
                        <label class="text-gray-500 font-medium">Status</label>
                        <form action="{{ route('admin.commission.updateStatus', $commission) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <select name="status" onchange="this.form.submit()" class="mt-1 px-2 py-1 text-xs leading-5 font-semibold rounded-full
                                    @if ($commission->status === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($commission->status === 'ready') bg-blue-100 text-blue-800
                                    @elseif($commission->status === 'wip') bg-orange-100 text-orange-800
                                    @elseif($commission->status === 'done') bg-green-100 text-green-800
                                    @elseif($commission->status === 'completed') bg-purple-100 text-purple-800 @endif">
                                <option value="pending" @if ($commission->status === 'pending') selected @endif>Pending</option>
                                <option value="ready" @if ($commission->status === 'ready') selected @endif>Ready</option>
                                <option value="wip" @if ($commission->status === 'wip') selected @endif>WIP</option>
                                <option value="done" @if ($commission->status === 'done') selected @endif>Done</option>
                                <option value="completed" @if ($commission->status === 'completed') selected @endif>Completed</option>
                            </select>
                        </form>
                    </div>

                    <!-- Additional Info -->
                    <div class="flex flex-col">
                        <label class="text-gray-500 font-medium">Delivery Status</label>
                        <form action="{{ route('admin.commission.updateDeliveryStatus', $commission) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <select name="delivery_status" onchange="this.form.submit()" class="mt-1 px-2 py-1 text-xs leading-5 font-semibold rounded-full
                                    @if ($commission->delivery->status === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($commission->delivery->status === 'in-transit') bg-blue-100 text-blue-800
                                    @elseif($commission->delivery->status === 'completed') bg-green-100 text-green-800
                                    @elseif($commission->delivery->status === 'cancelled') bg-red-100 text-red-800 @endif">
                                <option value="pending" @if ($commission->delivery->status === 'pending') selected @endif>Pending</option>
                                <option value="in-transit" @if ($commission->delivery->status === 'in-transit') selected @endif>In-Transit</option>
                                <option value="completed" @if ($commission->delivery->status === 'completed') selected @endif>Completed</option>
                                <option value="cancelled" @if ($commission->delivery->status === 'cancelled') selected @endif>Cancelled</option>
                            </select>
                        </form>
                    </div>
                    <div>
                        <label class="text-gray-500 font-medium">Dimensions</label>
                        <p class="text-gray-800">
                            {{ $commission->request->width }} x {{ $commission->request->height }}
                            @if ($commission->request->unit == 'cm')
                                centimeters
                            @else
                                inches
                            @endif
                        </p>
                    </div>

                    <!-- Pricing -->
                    <div>
                        <label class="text-gray-500 font-medium">Pricing per square inch</label>
                        @if ($commission->request->order_type == 'normal')
                            <p class="text-gray-800">₱{{ $commission->request->service->price_rate }}</p>
                        @else
                            <p class="text-gray-800">₱{{ $commission->request->service->rush_price_rate }}</p>
                        @endif
                    </div>
                    <div>
                        <label class="text-gray-500 font-medium">Calculation</label>
                        <p class="text-gray-800">Width x
                            Height  x Base Price = <span
                                class="font-semibold">Total</span></p>
                    </div>

                    <!-- Final Pricing -->
                    <div class="col-span-2 bg-gray-100 p-4 rounded-md">
                        <label class="text-gray-600 font-medium">Agreed Total Pricing</label>
                        <p class="text-2xl font-bold text-green-600">₱{{ number_format($commission->request->total_price, 2) }}</p>
                    </div>

                    <!-- Payment & Fees -->
                    <div>
                        <label class="text-gray-500 font-medium">Payment Method</label>
                        <p class="text-gray-800">Credit Card</p>
                    </div>
                    <div>
                        <label class="text-gray-500 font-medium">Commission Fee</label>
                        <p class="text-gray-800">₱{{ number_format($commission->request->total_price * 0.03, 2) }}</p>
                    </div>
                </div>
            </div>

            <div class="w-1/2">
                <h2 class="text-xl font-semibold mb-4">{{$commission->request->description}}</h2>
                <div class="space-y-2">
                    <img src="{{ $commission->request->service->images->first() ? asset('storage/' . $commission->request->service->images->first()->attachment->path) : asset('images/default.image.jpg') }}" alt="img">
                </div>
            </div>
        </div>
    </div>
    <div class="flex mt-6 mb-16 gap-4">
        <a href="#">
            <x-primary-button>
                Update
            </x-primary-button>
        </a>
        <a href="#">
            <x-secondary-button>
                Cancel
            </x-secondary-button>
        </a>
    </div>
</x-admin-layout>
