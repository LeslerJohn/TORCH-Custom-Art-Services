<x-admin-layout>
    <div>
        <div class="flex gap-4 items-center mb-6">
            <a href="{{ route('admin.order.index') }}"
                class="text-blue-600 hover:text-blue-800 flex items-center transition duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                Back
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Order ID {{ $order->id }}</h1>
        </div>
        <div class="flex bg-white shadow-md rounded-lg p-6 mb-6 gap-4">
            <div class="w-1/2">
                <!-- Header -->
                <h2 class="text-2xl font-bold text-gray-900 mb-6 border-b pb-3">Order Details</h2>

                <!-- Details Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Client & Artist -->
                    <div>
                        <label class="text-gray-500 font-medium">Client Name</label>
                        <p class="text-gray-800 font-semibold">{{ $order->client->user->name }}</p>
                    </div>
                    <div>
                        <label class="text-gray-500 font-medium">Artist Name</label>
                        <p class="text-gray-800 font-semibold">{{ $order->items->first()->artwork->artist->user->name }}
                        </p>
                    </div>

                    <!-- Artwork Info -->
                    <div>
                        <label class="text-gray-500 font-medium">Category</label>
                        <p class="text-gray-800">{{ $order->items->first()->artwork->category->name }}</p>
                    </div>

                    <!-- Progress & Status -->
                    <div>
                        <label class="text-gray-500 font-medium">Quantity</label>
                        <p class="text-gray-800 text-sm mt-1">{{ $order->items()->count() }}</p>
                    </div>

                    <div class="flex flex-col">
                        <label class="text-gray-500 font-medium">Status</label>
                        <form action="{{ route('admin.order.updateStatus', $order) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <select name="status" onchange="this.form.submit()"
                                class="mt-1 px-2 py-1 text-xs leading-5 font-semibold rounded-full
                                    @if ($order->status === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($order->status === 'accepted') bg-blue-100 text-blue-800
                                    @elseif($order->status === 'in-transit') bg-orange-100 text-orange-800
                                    @elseif($order->status === 'completed') bg-green-100 text-green-800
                                    @elseif($order->status === 'cancelled') bg-red-100 text-red-800
                                    @elseif($order->status === 'returned') bg-purple-100 text-purple-800
                                    @elseif($order->status === 'hold') bg-gray-100 text-gray-800 @endif">
                                <option value="pending" @if ($order->status === 'pending') selected @endif>Pending
                                </option>
                                <option value="accepted" @if ($order->status === 'accepted') selected @endif>Accepted
                                </option>
                                <option value="in-transit" @if ($order->status === 'in-transit') selected @endif>In-Transit
                                </option>
                                <option value="completed" @if ($order->status === 'completed') selected @endif>Completed
                                </option>
                                <option value="cancelled" @if ($order->status === 'cancelled') selected @endif>Cancelled
                                </option>
                                <option value="returned" @if ($order->status === 'returned') selected @endif>Returned
                                </option>
                                <option value="hold" @if ($order->status === 'hold') selected @endif>Hold</option>
                            </select>
                        </form>
                    </div>

                    <!-- Additional Info -->
                    <div class="flex flex-col">
                        <label class="text-gray-500 font-medium">Delivery Status</label>
                        <form action="{{ route('admin.order.updateDeliveryStatus', $order) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <select name="delivery_status" onchange="this.form.submit()"
                                class="mt-1 px-2 py-1 text-xs leading-5 font-semibold rounded-full
                                    @if ($order->delivery->status === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($order->delivery->status === 'in-transit') bg-blue-100 text-blue-800
                                    @elseif($order->delivery->status === 'completed') bg-green-100 text-green-800
                                    @elseif($order->delivery->status === 'cancelled') bg-red-100 text-red-800
                                    @elseif($order->delivery->status === 'hold') bg-gray-100 text-gray-800
                                    @elseif($order->delivery->status === 'returned') bg-purple-100 text-purple-800
                                    @elseif($order->delivery->status === 'delivered') bg-teal-100 text-teal-800 @endif">
                                <option value="pending" @if ($order->delivery->status === 'pending') selected @endif>Pending
                                </option>
                                <option value="in-transit" @if ($order->delivery->status === 'in-transit') selected @endif>
                                    In-Transit</option>
                                <option value="completed" @if ($order->delivery->status === 'completed') selected @endif>Completed
                                </option>
                                <option value="cancelled" @if ($order->delivery->status === 'cancelled') selected @endif>Cancelled
                                </option>
                                <option value="hold" @if ($order->delivery->status === 'hold') selected @endif>Hold</option>
                                <option value="returned" @if ($order->delivery->status === 'returned') selected @endif>Returned
                                </option>
                                <option value="delivered" @if ($order->delivery->status === 'delivered') selected @endif>Delivered
                                </option>
                            </select>
                        </form>
                    </div>

                    <!-- Final Pricing -->
                    <div class="col-span-2 bg-gray-100 p-4 rounded-md">
                        <label class="text-gray-600 font-medium">Order Total</label>
                        <p class="text-2xl font-bold text-green-600">
                            ₱{{ number_format($order->total, 2) }}</p>
                    </div>

                    <!-- Payment & Fees -->
                    <div>
                        <label class="text-gray-500 font-medium">Payment Method</label>
                        <p class="text-gray-800">E-Wallet</p>
                    </div>
                    <div>
                        <label class="text-gray-500 font-medium">Order Fee</label>
                        <p class="text-gray-800">₱{{ number_format($order->total * 0.03, 2) }}</p>
                    </div>
                </div>
            </div>

            <!-- Ordered Items -->
            <div class="space-y-6">
                @foreach ($order->items as $item)
                    <h1 class="text-2xl font-bold">Order Items</h1>
                    <div
                        class="bg-gray-50 rounded-xl w-full max-w-4xl overflow-hidden transition-all duration-200 hover:shadow-md">
                        <div class="flex flex-col md:flex-row">
                            <!-- Artwork Image -->
                            @php
                                $thumbnail = $item->artwork->images->first()?->attachment;
                            @endphp
                            <div class="md:w-1/3 lg:w-1/4">
                                <div class="relative aspect-[4/3]">
                                    <img src="{{ $thumbnail ? asset('storage/' . $thumbnail->path) : asset('images/default-image.jpg') }}"
                                        alt="{{ $item->artwork->title }}" class="w-full h-full object-cover">
                                </div>
                            </div>

                            <!-- Artwork Details -->
                            <div class="flex-1 p-4 md:p-6 flex flex-col justify-between">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800 mb-2">
                                        {{ $item->artwork->title }}
                                    </h3>

                                    <div class="grid grid-cols-2 gap-x-4 gap-y-2 mb-4">
                                        <div>
                                            <p class="text-xs text-gray-500">Category</p>
                                            <p class="font-medium">{{ $item->artwork->category->name }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500">Size</p>
                                            <p class="font-medium">{{ $item->artwork->width }} ×
                                                {{ $item->artwork->height }} {{ $item->artwork->unit }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between mt-2">
                                    <div class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" class="text-gray-400 mr-1">
                                            <path d="M12 2a10 10 0 1 0 0 20 10 10 0 0 0 0-20z" />
                                            <path d="M12 12h5" />
                                            <path d="M12 6v6" />
                                        </svg>
                                        <span class="text-sm text-gray-500 w-full">Item #{{ $loop->iteration }}</span>
                                    </div>
                                    <span
                                        class="text-lg font-bold text-blue-600 w-full text-right">₱{{ number_format($item->price, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                @if ($order->delivery->status === 'completed')
                    <div class="bg-gray-50 p-6 mt-8 mb-6">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4">Proof of Delivery</h2>
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            @foreach ($order->delivery->proofs as $proof)
                                <div class="relative group">
                                    <img src="{{ asset('storage/' . $proof->attachment->path) }}"
                                        alt="Proof of Delivery" class="w-full h-32 object-cover rounded-md shadow-md">
                                    <div
                                        class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-md">
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
    </div>
    <div class="flex mt-6 mb-16">
        @if ($order->refund)
            <div class="w-full bg-gray-50 p-6 rounded-md shadow-sm flex gap-6">
                <div class="w-2/3">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Refund Request</h3>
                    <div class="mb-4">
                        <label class="text-gray-500 font-medium">Reason</label>
                        <p class="text-gray-800">{{ $order->refund->reason }}</p>
                    </div>
                    <div class="mb-4">
                        <label class="text-gray-500 font-medium">Refund Amount</label>
                        <p class="text-gray-800 font-semibold">₱{{ number_format($order->refund->amount, 2) }}</p>
                    </div>
                    <div class="mb-4">
                        <label class="text-gray-500 font-medium">Requested On</label>
                        <p class="text-gray-800 font-semibold">
                            {{ \Carbon\Carbon::parse($order->refund->created_at)->format('F j, Y g:i A') }}
                        </p>
                    </div>
                    <div class="mb-4">
                        <label class="text-gray-500 font-medium">Payment Method</label>
                        <p class="text-gray-800">{{ $order->refund->refund_method }}</p>
                    </div>
                    <div class="mb-4">
                        <label class="text-gray-500 font-medium">Payment ID</label>
                        <p class="text-gray-800">{{ $order->refund->payment_id }}</p>
                    </div>
                    <div class="mb-4">
                        <label class="text-gray-500 font-medium">Transaction ID</label>
                        <p class="text-gray-800">{{ $order->refund->payment->transaction_id }}</p>
                    </div>

                    <div class="mb-4">
                        <label class="text-gray-500 font-medium">Refund Status</label>
                        <p class="text-gray-800 font-semibold">
                            @if ($order->refund->status === 'pending')
                                <span class="text-yellow-600">Pending</span>
                            @elseif ($order->refund->status === 'approved')
                                <span class="text-green-600">Approved</span>
                            @elseif ($order->refund->status === 'rejected')
                                <span class="text-red-600">Rejected</span>
                            @endif
                        </p>
                    </div>

                    <div>
                        <div class="flex space-x-4">
                            @if ($order->refund->status === 'pending')
                                <form action="{{ route('admin.order.approveRefund', $order) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                        class="px-4 py-2 bg-green-500 text-white text-sm font-medium rounded-md hover:bg-green-600 transition duration-300">
                                        Approve
                                    </button>
                                </form>
                                {{-- <form action="{{ route('admin.order.rejectRefund', $order) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit"
                                        class="px-4 py-2 bg-red-500 text-white text-sm font-medium rounded-md hover:bg-red-600 transition duration-300">
                                        Reject
                                    </button> --}}
                                </form>
                            @elseif ($order->refund->status === 'approved')
                                <p class="text-green-600 font-semibold">Refund Approved</p>
                            @elseif ($order->refund->status === 'rejected')
                                <p class="text-red-600 font-semibold">Refund Rejected</p>
                            @endif
                        </div>
                    </div>
                </div>
                @if ($order->refund->attachment)
                    <div class="w-full">
                        <label class="text-gray-500 font-medium">Evidence</label>
                        <img src="{{ asset('storage/' . $order->refund->attachment->path) }}"
                            alt="Refund Request Image" class="mt-2 rounded-md shadow-md w-96 h-96 object-cover">
                    </div>
                @endif
            </div>
        @endif
    </div>
</x-admin-layout>
