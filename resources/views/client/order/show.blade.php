<x-app-layout>
    <div class="max-w-5xl mt-10 mx-auto bg-white p-6 rounded-lg shadow-lg relative">
        <!-- Status on Top Right -->
        <div class="absolute top-6 right-6">
            <span class="px-4 py-2 rounded-full text-white 
                {{ $order->delivery->status == 'completed' ? 'bg-green-500' : ($order->delivery->status == 'in-transit' ? 'bg-yellow-500' : 'bg-red-500') }}">
                {{ ucfirst($order->delivery->status ?? 'Pending') }}
            </span>
        </div>

        <!-- Expected Delivery & Shipping Info -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold">Order #{{ $order->id }}</h1>
            <p class="text-gray-600">Expected Delivery Date: 
                <strong class="text-blue-500">{{ optional($order->delivery)->expected_delivery ? \Carbon\Carbon::parse($order->delivery->expected_delivery)->format('F j, Y') : 'TBD' }}</strong>
            </p>
            <p class="text-gray-600">Shipping to: 
                <strong>{{ $order->delivery->address->house_number }}, 
                {{ $order->delivery->address->street }}, 
                {{ $order->delivery->address->barangay }}</strong>
            </p>
        </div>

        <!-- Shipping Progress -->
        <div class="mb-6">
            <h2 class="text-xl font-semibold mb-2">Shipping Progress</h2>
            <div class="w-full bg-gray-200 rounded-full h-2.5 mb-4">
                <div class="bg-blue-500 h-2.5 rounded-full" style="width: 
                    {{ $order->delivery->status == 'completed' ? '100%' : ($order->delivery->status == 'in-transit' ? '50%' : '10%') }}">
                </div>
            </div>
            <div class="flex justify-between text-sm text-gray-600">
                <span>Pending</span>
                <span>In-Transit</span>
                <span>Completed</span>
            </div>
        </div>

        <!-- Artist and Ordered Items -->
        <div class="mb-6">
            <h2 class="text-xl font-semibold mb-2">Your Order from {{ $order->items->first()->artwork->artist->user->name }}</h2>
            <div class="space-y-4">
                @foreach ($order->items as $item)
                    <div class="flex items-center gap-4 bg-gray-50 p-4 rounded-lg shadow">
                        <!-- Artwork Image -->
                        @php
                            $thumbnail = $item->artwork->images->first()?->attachment;
                        @endphp
                        <img src="{{ $thumbnail ? asset('storage/' . $thumbnail->path) : asset('images/default-image.jpg') }}" 
                            alt="{{ $item->artwork->title }}" class="w-24 h-24 object-cover rounded-md">
    
                        <!-- Artwork Details -->
                        <div>
                            <h3 class="text-lg font-semibold">{{ $item->artwork->title }}</h3>
                            <p><strong>Category:</strong> {{ $item->artwork->category->name }}</p>
                            <p><strong>Medium:</strong> {{ $item->artwork->medium }}</p>
                            <p><strong>Price:</strong> ₱{{ number_format($item->price, 2) }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    
        <!-- Support Center & Order Details -->
        <div class="mb-6">
            <h2 class="text-xl font-semibold mb-2">Support Center</h2>
            <p class="text-gray-600">Having issues with your order? 
                <a href="#" class="text-blue-500 underline">Contact Support</a>
            </p>
        </div>
    
        <div class="mb-6">
            <h2 class="text-xl font-semibold mb-2">Order Details</h2>
            <p><strong>Order ID:</strong> #{{ $order->id }}</p>
            <p><strong>Total Price:</strong> ₱{{ number_format($order->total, 2) }}</p>
        </div>
    
        <!-- Buttons -->
        <div class="flex justify-end gap-4">
            @if ($order->delivery->status == 'pending')
                <form action="{{ route('client.order.destroy', $order) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-lg shadow">Cancel Order</button>
                </form>
            @endif
        </div>
    </div>
</x-app-layout>