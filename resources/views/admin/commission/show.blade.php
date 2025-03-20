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
                                <button type="submit"
                                    class="mt-2 px-3 py-1 bg-blue-100 text-blue-500 text-xs rounded-full"
                                    data-tooltip-target="tooltip-animation">Extend Deadline</button>
                            </form>
                            <div id="tooltip-animation" role="tooltip"
                                class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-black transition-opacity duration-300 bg-gray-300 rounded-lg shadow-xs opacity-0 tooltip">
                                <p class="text-sm">Automatically add 7 days extension.</p>
                                <div class="tooltip-arrow" data-popper-arrow></div>
                            </div>
                        @endif
                    </div>

                    <!-- Progress & Status -->
                    <div>
                        <label class="text-gray-500 font-medium">Quantity</label>
                        <p class="text-gray-800 text-sm mt-1">{{ $commission->request->quantity }}</p>
                    </div>

                    <div class="flex flex-col">
                        <label class="text-gray-500 font-medium">Status</label>
                        <form action="{{ route('admin.commission.updateStatus', $commission) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <select name="status" onchange="this.form.submit()"
                                class="mt-1 px-2 py-1 text-xs leading-5 font-semibold rounded-full
                                    @if ($commission->status === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($commission->status === 'ready') bg-blue-100 text-blue-800
                                    @elseif($commission->status === 'wip') bg-orange-100 text-orange-800
                                    @elseif($commission->status === 'done') bg-green-100 text-green-800
                                    @elseif($commission->status === 'completed') bg-purple-100 text-purple-800
                                    @elseif($commission->status === 'hold') bg-gray-100 text-gray-800
                                    @elseif($commission->status === 'returned') bg-red-100 text-red-800 @endif">
                                <option value="pending" @if ($commission->status === 'pending') selected @endif>Pending
                                </option>
                                <option value="ready" @if ($commission->status === 'ready') selected @endif>Ready</option>
                                <option value="wip" @if ($commission->status === 'wip') selected @endif>WIP</option>
                                <option value="done" @if ($commission->status === 'done') selected @endif>Done</option>
                                <option value="completed" @if ($commission->status === 'completed') selected @endif>Completed
                                </option>
                                <option value="hold" @if ($commission->status === 'hold') selected @endif>Hold</option>
                                <option value="returned" @if ($commission->status === 'returned') selected @endif>Returned
                                </option>
                            </select>
                        </form>
                    </div>

                    <!-- Additional Info -->
                    <div class="flex flex-col">
                        <label class="text-gray-500 font-medium">Delivery Status</label>
                        <form action="{{ route('admin.commission.updateDeliveryStatus', $commission) }}"
                            method="POST">
                            @csrf
                            @method('PUT')
                            <select name="delivery_status" onchange="this.form.submit()"
                                class="mt-1 px-2 py-1 text-xs leading-5 font-semibold rounded-full
                                    @if ($commission->delivery->status === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($commission->delivery->status === 'in-transit') bg-blue-100 text-blue-800
                                    @elseif($commission->delivery->status === 'completed') bg-green-100 text-green-800
                                    @elseif($commission->delivery->status === 'cancelled') bg-red-100 text-red-800
                                    @elseif($commission->delivery->status === 'hold') bg-gray-100 text-gray-800
                                    @elseif($commission->delivery->status === 'returned') bg-purple-100 text-purple-800
                                    @elseif($commission->delivery->status === 'delivered') bg-teal-100 text-teal-800 @endif">
                                <option value="pending" @if ($commission->delivery->status === 'pending') selected @endif>Pending
                                </option>
                                <option value="in-transit" @if ($commission->delivery->status === 'in-transit') selected @endif>
                                    In-Transit</option>
                                <option value="completed" @if ($commission->delivery->status === 'completed') selected @endif>Completed
                                </option>
                                <option value="cancelled" @if ($commission->delivery->status === 'cancelled') selected @endif>Cancelled
                                </option>
                                <option value="hold" @if ($commission->delivery->status === 'hold') selected @endif>Hold</option>
                                <option value="returned" @if ($commission->delivery->status === 'returned') selected @endif>Returned
                                </option>
                                <option value="delivered" @if ($commission->delivery->status === 'delivered') selected @endif>Delivered
                                </option>
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
                            Height x Base Price = <span class="font-semibold">Total</span></p>
                    </div>

                    <!-- Final Pricing -->
                    <div class="col-span-2 bg-gray-100 p-4 rounded-md">
                        <label class="text-gray-600 font-medium">Agreed Total Pricing</label>
                        <p class="text-2xl font-bold text-green-600">
                            ₱{{ number_format($commission->request->total_price * $commission->request->quantity, 2) }}
                        </p>
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

                    @if ($commission->extension)
                        <div class="bg-gray-50 p-4 rounded-md shadow-sm">
                            <h3 class="text-lg font-semibold text-gray-800 mb-2">Extension Request</h3>
                            <div class="mb-4">
                                <label class="text-gray-500 font-medium">Reason</label>
                                <p class="text-gray-800">{{ $commission->extension->reason }}</p>
                            </div>
                            @if ($commission->extension->attachment)
                                <div class="mb-4">
                                    <label class="text-gray-500 font-medium">Evidence</label>
                                    <img src="{{ asset('storage/' . $commission->extension->attachment->path) }}"
                                        alt="Extension Request Image"
                                        class="mt-2 rounded-md shadow-md w-48 h-48 object-cover">
                                </div>
                            @endif
                            <div class="flex space-x-4">
                                @if ($commission->extension->status === 'pending' && $commission->status === 'wip')
                                    <form action="{{ route('admin.commission.extendDeadline', $commission) }}"
                                        method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="number" name="count" value="7" hidden>
                                        <button type="submit"
                                            class="px-4 py-2 bg-blue-500 text-white text-sm font-medium rounded-md hover:bg-blue-600 transition duration-300">
                                            Approve
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.commission.rejectExtension', $commission) }}"
                                        method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit"
                                            class="px-4 py-2 bg-red-500 text-white text-sm font-medium rounded-md hover:bg-red-600 transition duration-300">
                                            Reject
                                        </button>
                                    </form>
                                @elseif ($commission->extension->status === 'approved')
                                    <p class="text-green-600 font-semibold">Extension Approved</p>
                                @elseif ($commission->extension->status === 'rejected')
                                    <p class="text-red-600 font-semibold">Extension Rejected</p>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="w-1/2">
                <h2 class="text-xl font-semibold mb-4">{{ $commission->request->description }}</h2>
                <div class="space-y-2">
                    <img src="{{ $commission->request->service->images->first() ? asset('storage/' . $commission->request->service->images->first()->attachment->path) : asset('images/default.image.jpg') }}"
                        alt="img" class="w-full h-96 object-cover rounded-md shadow-md">
                </div>

                @if ($commission->delivery->status === 'completed' || $commission->delivery->status === 'delivered' || $commission->delivery->status === 'returned' || $commission->delivery->status === 'hold')
                        <div class="bg-gray-50 p-6 mt-8 mb-6">
                            <h2 class="text-lg font-semibold text-gray-800 mb-4">Proof of Delivery</h2>
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                @foreach ($commission->delivery->proofs as $proof)
                                    <div class="relative group">
                                        <img src="{{ asset('storage/' . $proof->attachment->path) }}"
                                            alt="Proof of Delivery"
                                            class="w-full h-32 object-cover rounded-md shadow-md">
                                        <div
                                            class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-md">
                                            <a href="{{ asset('storage/' . $proof->attachment->path) }}"
                                                target="_blank" class="text-white text-sm font-semibold underline">
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
    </div>
    <div class="flex mt-6 mb-16">
        @if ($commission->refund)
            <div class="w-full bg-gray-50 p-6 rounded-md shadow-sm flex gap-6">
                <div class="w-2/3">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Refund Request</h3>
                    <div class="mb-4">
                        <label class="text-gray-500 font-medium">Reason</label>
                        <p class="text-gray-800">{{ $commission->refund->reason }}</p>
                    </div>
                    <div class="mb-4">
                        <label class="text-gray-500 font-medium">Refund Amount</label>
                        <p class="text-gray-800 font-semibold">₱{{ number_format($commission->refund->amount, 2) }}
                        </p>
                    </div>
                    <div class="mb-4">
                        <label class="text-gray-500 font-medium">Requested On</label>
                        <p class="text-gray-800 font-semibold">
                            {{ \Carbon\Carbon::parse($commission->refund->created_at)->format('F j, Y g:i A') }}
                        </p>
                    </div>
                    <div class="mb-4">
                        <label class="text-gray-500 font-medium">Payment Method</label>
                        <p class="text-gray-800">{{ $commission->refund->refund_method }}</p>
                    </div>
                    <div class="mb-4">
                        <label class="text-gray-500 font-medium">Payment ID</label>
                        <p class="text-gray-800">{{ $commission->refund->payment_id }}</p>
                    </div>
                    <div class="mb-4">
                        <label class="text-gray-500 font-medium">Transaction ID</label>
                        <p class="text-gray-800">{{ $commission->refund->payment->transaction_id }}</p>
                    </div>

                    <div class="mb-4">
                        <label class="text-gray-500 font-medium">Refund Status</label>
                        <p class="text-gray-800 font-semibold">
                            @if ($commission->refund->status === 'pending')
                                <span class="text-yellow-600">Pending</span>
                            @elseif ($commission->refund->status === 'approved')
                                <span class="text-green-600">Approved</span>
                            @elseif ($commission->refund->status === 'rejected')
                                <span class="text-red-600">Rejected</span>
                            @endif
                        </p>
                    </div>

                    <div>
                        <div class="flex space-x-4">
                            @if ($commission->refund->status === 'pending')
                                <!-- Approve Refund Confirmation Modal -->
                                <div x-data="{ showApproveModal: false }">
                                    <button @click="showApproveModal = true"
                                        class="px-4 py-2 bg-green-500 text-white text-sm font-medium rounded-md hover:bg-green-600 transition duration-300">
                                        Approve
                                    </button>
                                    <div x-show="showApproveModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                                        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
                                            <h2 class="text-lg font-semibold mb-4">Confirm Approval</h2>
                                            <p class="text-gray-700 mb-6">Are you sure you want to approve this refund?</p>
                                            <div class="flex justify-end space-x-4">
                                                <button @click="showApproveModal = false"
                                                    class="px-4 py-2 bg-gray-300 text-gray-800 text-sm font-medium rounded-md hover:bg-gray-400 transition duration-300">
                                                    Cancel
                                                </button>
                                                <form action="{{ route('admin.commission.approveRefund', $commission) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit"
                                                        class="px-4 py-2 bg-green-500 text-white text-sm font-medium rounded-md hover:bg-green-600 transition duration-300">
                                                        Confirm
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Reject Refund Confirmation Modal -->
                                <div x-data="{ showRejectModal: false }">
                                    <button @click="showRejectModal = true"
                                        class="px-4 py-2 bg-red-500 text-white text-sm font-medium rounded-md hover:bg-red-600 transition duration-300">
                                        Reject
                                    </button>
                                    <div x-show="showRejectModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                                        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
                                            <h2 class="text-lg font-semibold mb-4">Confirm Rejection</h2>
                                            <p class="text-gray-700 mb-6">Are you sure you want to reject this refund?</p>
                                            <div class="flex justify-end space-x-4">
                                                <button @click="showRejectModal = false"
                                                    class="px-4 py-2 bg-gray-300 text-gray-800 text-sm font-medium rounded-md hover:bg-gray-400 transition duration-300">
                                                    Cancel
                                                </button>
                                                <form action="{{ route('admin.commission.rejectRefund', $commission) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit"
                                                        class="px-4 py-2 bg-red-500 text-white text-sm font-medium rounded-md hover:bg-red-600 transition duration-300">
                                                        Confirm
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </form>
                            @elseif ($commission->refund->status === 'approved')
                                <p class="text-green-600 font-semibold">Refund Approved</p>
                            @elseif ($commission->refund->status === 'rejected')
                                <p class="text-red-600 font-semibold">Refund Rejected</p>
                            @endif
                        </div>
                    </div>
                </div>
                @if ($commission->refund->attachment)
                    <div class="w-full">
                        <label class="text-gray-500 font-medium">Evidence</label>
                        <img src="{{ asset('storage/' . $commission->refund->attachment->path) }}"
                            alt="Refund Request Image" class="mt-2 rounded-md shadow-md w-96 h-96 object-cover">
                    </div>
                @endif
            </div>
        @endif
    </div>
</x-admin-layout>
