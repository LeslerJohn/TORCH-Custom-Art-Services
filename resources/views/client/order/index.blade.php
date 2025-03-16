<x-app-layout>
    <div class="max-w-7xl mx-auto mt-8 sm:px-6 lg:px-8 pb-16 overflow-hidden shadow-sm sm:rounded-lg">
        <h1 class="text-2xl font-bold">Orders</h1>

        <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
            <ul class="flex flex-nowrap overflow-x-auto -mb-px text-sm font-medium text-center" id="default-tab"
                data-tabs-toggle="#default-tab-content" role="tablist">
                <!-- All Tab -->
                <li class="flex-shrink-0" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-lg whitespace-nowrap" id="profile-tab" data-tabs-target="#profile"
                        type="button" role="tab" aria-controls="profile" aria-selected="false">
                        All
                        <span class="ml-2 bg-orange-500 text-white rounded-full px-2 py-1 text-xs">
                            {{ $orders->count() }}
                        </span>
                    </button>
                </li>
                <!-- Pending Tab -->
                <li class="flex-shrink-0" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-lg whitespace-nowrap hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                        id="dashboard-tab" data-tabs-target="#dashboard" type="button" role="tab"
                        aria-controls="dashboard" aria-selected="false">
                        Pending
                        <span class="ml-2 bg-orange-500 text-white rounded-full px-2 py-1 text-xs">
                            {{ $orders->where('delivery.status', 'pending')->count() }}
                        </span>
                    </button>
                </li>
                <!-- To Receive Tab -->
                <li class="flex-shrink-0" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-lg whitespace-nowrap hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                        id="settings-tab" data-tabs-target="#settings" type="button" role="tab"
                        aria-controls="settings" aria-selected="false">
                        To Receive
                        <span class="ml-2 bg-orange-500 text-white rounded-full px-2 py-1 text-xs">
                            {{ $orders->where('delivery.status', 'in-transit')->count() }}
                        </span>
                    </button>
                </li>
                <!-- Completed Tab -->
                <li class="flex-shrink-0" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-lg whitespace-nowrap hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                        id="contacts-tab" data-tabs-target="#contacts" type="button" role="tab"
                        aria-controls="contacts" aria-selected="false">
                        Completed
                        <span class="ml-2 bg-orange-500 text-white rounded-full px-2 py-1 text-xs">
                            {{ $orders->where('delivery.status', 'completed')->count() }}
                        </span>
                    </button>
                </li>
                <!-- Cancelled Tab -->
                <li class="flex-shrink-0" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-lg whitespace-nowrap hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                        id="cancelled-tab" data-tabs-target="#cancelled" type="button" role="tab"
                        aria-controls="cancelled" aria-selected="false">
                        Cancelled
                        <span class="ml-2 bg-orange-500 text-white rounded-full px-2 py-1 text-xs">
                            {{ $orders->where('delivery.status', 'cancelled')->count() }}
                        </span>
                    </button>
                </li>
            </ul>
        </div>
        <style>
            /* Hide scrollbar for Chrome, Safari, and Opera */
            #default-tab::-webkit-scrollbar {
                display: none;
            }

            /* Hide scrollbar for IE, Edge, and Firefox */
            #default-tab {
                -ms-overflow-style: none;
                /* IE and Edge */
                scrollbar-width: none;
                /* Firefox */
            }
        </style>
        <div id="default-tab-content">
            <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="profile" role="tabpanel"
                aria-labelledby="profile-tab">

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($orders as $order)
                    @php
                    $firstItem = $order->items->first();
                    $artwork = $firstItem ? $firstItem->artwork : null;
                    $thumbnail = $artwork ? $artwork->images->first()?->attachment : null;
                    @endphp

                    <div class="relative w-full h-[250px] rounded-lg overflow-hidden shadow-lg">
                        <a href="{{ route('client.order.show', $order) }}">
                            <!-- Background Image -->
                            <img src="{{ $thumbnail ? asset('storage/' . $thumbnail->path) : asset('images/default-image.jpg') }}"
                                alt="{{ $artwork->title ?? 'Artwork' }}" class="w-full h-full object-cover">

                            <!-- Overlay -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>

                            <div class="absolute top-4 left-4 right-4 flex justify-between items-center">
                                <span class="font-semibold text-xs px-2 py-1 rounded-full"
                                    style="background-color: 
                                                @if ($order->delivery->status == 'pending') #fcd34d 
                                                @elseif($order->delivery->status == 'in-transit') 
                                                    #93c5fd 
                                                @elseif($order->delivery->status == 'completed') 
                                                    #6ee7b7 
                                                @else 
                                                    #d1d5db @endif;
                                                color: 
                                                @if ($order->delivery->status == 'pending') #d97706 
                                                @elseif($order->delivery->status == 'in-transit') 
                                                    #2563eb 
                                                @elseif($order->delivery->status == 'completed') 
                                                    #059669 
                                                @else 
                                                    #4b5563 @endif;">
                                    {{ ucfirst($order->delivery->status ?? 'Pending') }}
                                </span>
                            </div>
                            <!-- Text Content -->
                            <div class="absolute bottom-4 left-4 text-white">
                                <div class="flex items-center gap-2">
                                    <p class="text-sm">{{ $artwork->category->name ?? 'Uncategorized' }} |</p>
                                    <h2 class="text-lg font-bold">{{ $artwork->title ?? 'Unknown Title' }}</h2>
                                </div>

                                <p class="text-sm text-white font-medium flex items-center">
                                    {{ $artwork->artist->user->name ?? 'Unknown Artist' }}
                                    <svg class="w-4 h-4 text-blue-400 ml-1" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 15l-4-4 1.41-1.41L11 13.17l5.59-5.59L18 9l-7 7z" />
                                    </svg>
                                </p>
                            </div>

                            <!-- Price & Delivery Status -->
                            <div class="absolute bottom-4 right-4 text-white">
                                <p class="text-sm mt-1">
                                    @php
                                    $totalPrice = $order->items->sum('price');
                                    @endphp
                                    <span
                                        class="text-xl text-white font-semibold">₱{{ number_format($totalPrice, 0, '.', ',') }}</span>
                                </p>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>

            </div>
            <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="dashboard" role="tabpanel"
                aria-labelledby="dashboard-tab">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($orders as $order)
                    @php
                    $firstItem = $order->items->first();
                    $artwork = $firstItem ? $firstItem->artwork : null;
                    $thumbnail = $artwork ? $artwork->images->first()?->attachment : null;
                    @endphp

                    @if ($order->delivery->status == 'pending')
                    <div class="relative w-full h-[250px] rounded-lg overflow-hidden shadow-lg">
                        <a href="{{ route('client.order.show', $order) }}">
                            <!-- Background Image -->
                            <img src="{{ $thumbnail ? asset('storage/' . $thumbnail->path) : asset('images/default-image.jpg') }}"
                                alt="{{ $artwork->title ?? 'Artwork' }}" class="w-full h-full object-cover">

                            <!-- Overlay -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>

                            <div class="absolute top-4 left-4 right-4 flex justify-between items-center">
                                <span class="font-semibold text-xs px-2 py-1 rounded-full"
                                    style="background-color: 
                                                    @if ($order->delivery->status == 'pending') #fcd34d 
                                                    @elseif($order->delivery->status == 'in-transit') 
                                                        #93c5fd 
                                                    @elseif($order->delivery->status == 'completed') 
                                                        #6ee7b7 
                                                    @else 
                                                        #d1d5db @endif;
                                                    color: 
                                                    @if ($order->delivery->status == 'pending') #d97706 
                                                    @elseif($order->delivery->status == 'in-transit') 
                                                        #2563eb 
                                                    @elseif($order->delivery->status == 'completed') 
                                                        #059669 
                                                    @else 
                                                        #4b5563 @endif;">
                                    {{ ucfirst($order->delivery->status ?? 'Pending') }}
                                </span>
                            </div>
                            <!-- Text Content -->
                            <div class="absolute bottom-4 left-4 text-white">
                                <div class="flex items-center gap-2">
                                    <p class="text-sm">{{ $artwork->category->name ?? 'Uncategorized' }} |</p>
                                    <h2 class="text-lg font-bold">{{ $artwork->title ?? 'Unknown Title' }}</h2>
                                </div>

                                <p class="text-sm text-white font-medium flex items-center">
                                    {{ $artwork->artist->user->name ?? 'Unknown Artist' }}
                                    <svg class="w-4 h-4 text-blue-400 ml-1" fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 15l-4-4 1.41-1.41L11 13.17l5.59-5.59L18 9l-7 7z" />
                                    </svg>
                                </p>
                            </div>

                            <!-- Price & Delivery Status -->
                            <div class="absolute bottom-4 right-4 text-white">
                                <p class="text-sm mt-1">
                                    @php
                                    $totalPrice = $order->items->sum('price');
                                    @endphp
                                    <span
                                        class="text-xl text-white font-semibold">₱{{ number_format($totalPrice, 0, '.', ',') }}</span>
                                </p>
                            </div>
                        </a>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>
            <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="settings" role="tabpanel"
                aria-labelledby="settings-tab">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($orders as $order)
                    @php
                    $firstItem = $order->items->first();
                    $artwork = $firstItem ? $firstItem->artwork : null;
                    $thumbnail = $artwork ? $artwork->images->first()?->attachment : null;
                    @endphp

                    @if ($order->delivery->status == 'in-transit')
                    <div class="relative w-full h-[250px] rounded-lg overflow-hidden shadow-lg">
                        <a href="{{ route('client.order.show', $order) }}">
                            <!-- Background Image -->
                            <img src="{{ $thumbnail ? asset('storage/' . $thumbnail->path) : asset('images/default-image.jpg') }}"
                                alt="{{ $artwork->title ?? 'Artwork' }}" class="w-full h-full object-cover">

                            <!-- Overlay -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>

                            <div class="absolute top-4 left-4 right-4 flex justify-between items-center">
                                <span class="font-semibold text-xs px-2 py-1 rounded-full"
                                    style="background-color: 
                                                    @if ($order->delivery->status == 'pending') #fcd34d 
                                                    @elseif($order->delivery->status == 'in-transit') 
                                                        #93c5fd 
                                                    @elseif($order->delivery->status == 'completed') 
                                                        #6ee7b7 
                                                    @else 
                                                        #d1d5db @endif;
                                                    color: 
                                                    @if ($order->delivery->status == 'pending') #d97706 
                                                    @elseif($order->delivery->status == 'in-transit') 
                                                        #2563eb 
                                                    @elseif($order->delivery->status == 'completed') 
                                                        #059669 
                                                    @else 
                                                        #4b5563 @endif;">
                                    {{ ucfirst($order->delivery->status ?? 'Pending') }}
                                </span>
                            </div>
                            <!-- Text Content -->
                            <div class="absolute bottom-4 left-4 text-white">
                                <div class="flex items-center gap-2">
                                    <p class="text-sm">{{ $artwork->category->name ?? 'Uncategorized' }} |</p>
                                    <h2 class="text-lg font-bold">{{ $artwork->title ?? 'Unknown Title' }}
                                    </h2>
                                </div>

                                <p class="text-sm text-white font-medium flex items-center">
                                    {{ $artwork->artist->user->name ?? 'Unknown Artist' }}
                                    <svg class="w-4 h-4 text-blue-400 ml-1" fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 15l-4-4 1.41-1.41L11 13.17l5.59-5.59L18 9l-7 7z" />
                                    </svg>
                                </p>
                            </div>

                            <!-- Price & Delivery Status -->
                            <div class="absolute bottom-4 right-4 text-white">
                                <p class="text-sm mt-1">
                                    @php
                                    $totalPrice = $order->items->sum('price');
                                    @endphp
                                    <span
                                        class="text-xl text-white font-semibold">₱{{ number_format($totalPrice, 0, '.', ',') }}</span>
                                </p>
                            </div>
                        </a>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>
            <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="contacts" role="tabpanel"
                aria-labelledby="contacts-tab">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($orders as $order)
                    @php
                    $firstItem = $order->items->first();
                    $artwork = $firstItem ? $firstItem->artwork : null;
                    $thumbnail = $artwork ? $artwork->images->first()?->attachment : null;
                    @endphp

                    @if ($order->delivery->status == 'completed')
                    <div class="relative w-full h-[250px] rounded-lg overflow-hidden shadow-lg">
                        <a href="{{ route('client.order.show', $order) }}">
                            <!-- Background Image -->
                            <img src="{{ $thumbnail ? asset('storage/' . $thumbnail->path) : asset('images/default-image.jpg') }}"
                                alt="{{ $artwork->title ?? 'Artwork' }}" class="w-full h-full object-cover">

                            <!-- Overlay -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>

                            <div class="absolute top-4 left-4 right-4 flex justify-between items-center">
                                <span class="font-semibold text-xs px-2 py-1 rounded-full"
                                    style="background-color: 
                                                    @if ($order->delivery->status == 'pending') #fcd34d 
                                                    @elseif($order->delivery->status == 'in-transit') 
                                                        #93c5fd 
                                                    @elseif($order->delivery->status == 'completed') 
                                                        #6ee7b7 
                                                    @else 
                                                        #d1d5db @endif;
                                                    color: 
                                                    @if ($order->delivery->status == 'pending') #d97706 
                                                    @elseif($order->delivery->status == 'in-transit') 
                                                        #2563eb 
                                                    @elseif($order->delivery->status == 'completed') 
                                                        #059669 
                                                    @else 
                                                        #4b5563 @endif;">
                                    {{ ucfirst($order->delivery->status ?? 'Pending') }}
                                </span>
                            </div>
                            <!-- Text Content -->
                            <div class="absolute bottom-4 left-4 text-white">
                                <div class="flex items-center gap-2">
                                    <p class="text-sm">{{ $artwork->category->name ?? 'Uncategorized' }} |</p>
                                    <h2 class="text-lg font-bold">{{ $artwork->title ?? 'Unknown Title' }}
                                    </h2>
                                </div>

                                <p class="text-sm text-white font-medium flex items-center">
                                    {{ $artwork->artist->user->name ?? 'Unknown Artist' }}
                                    <svg class="w-4 h-4 text-blue-400 ml-1" fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 15l-4-4 1.41-1.41L11 13.17l5.59-5.59L18 9l-7 7z" />
                                    </svg>
                                </p>
                            </div>

                            <!-- Price & Delivery Status -->
                            <div class="absolute bottom-4 right-4 text-white">
                                <p class="text-sm mt-1">
                                    @php
                                    $totalPrice = $order->items->sum('price');
                                    @endphp
                                    <span
                                        class="text-xl text-white font-semibold">₱{{ number_format($totalPrice, 0, '.', ',') }}</span>
                                </p>
                            </div>
                        </a>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>
            <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="cancelled" role="tabpanel"
                aria-labelledby="cancelled-tab">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($orders as $order)
                    @php
                    $firstItem = $order->items->first();
                    $artwork = $firstItem ? $firstItem->artwork : null;
                    $thumbnail = $artwork ? $artwork->images->first()?->attachment : null;
                    @endphp

                    @if ($order->delivery->status == 'cancelled')
                    <div class="relative w-full h-[250px] rounded-lg overflow-hidden shadow-lg">
                        <a href="{{ route('client.order.show', $order) }}">
                            <!-- Background Image -->
                            <img src="{{ $thumbnail ? asset('storage/' . $thumbnail->path) : asset('images/default-image.jpg') }}"
                                alt="{{ $artwork->title ?? 'Artwork' }}" class="w-full h-full object-cover">

                            <!-- Overlay -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>

                            <div class="absolute top-4 left-4 right-4 flex justify-between items-center">
                                <span class="font-semibold text-xs px-2 py-1 rounded-full"
                                    style="background-color: 
                                                    @if ($order->delivery->status == 'pending') #fcd34d 
                                                    @elseif($order->delivery->status == 'in-transit') 
                                                        #93c5fd 
                                                    @elseif($order->delivery->status == 'completed') 
                                                        #6ee7b7 
                                                    @else 
                                                        #d1d5db @endif;
                                                    color: 
                                                    @if ($order->delivery->status == 'pending') #d97706 
                                                    @elseif($order->delivery->status == 'in-transit') 
                                                        #2563eb 
                                                    @elseif($order->delivery->status == 'completed') 
                                                        #059669 
                                                    @else 
                                                        #4b5563 @endif;">
                                    {{ ucfirst($order->delivery->status ?? 'Pending') }}
                                </span>
                            </div>
                            <!-- Text Content -->
                            <div class="absolute bottom-4 left-4 text-white">
                                <div class="flex items-center gap-2">
                                    <p class="text-sm">{{ $artwork->category->name ?? 'Uncategorized' }} |</p>
                                    <h2 class="text-lg font-bold">{{ $artwork->title ?? 'Unknown Title' }}
                                    </h2>
                                </div>

                                <p class="text-sm text-white font-medium flex items-center">
                                    {{ $artwork->artist->user->name ?? 'Unknown Artist' }}
                                    <svg class="w-4 h-4 text-blue-400 ml-1" fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 15l-4-4 1.41-1.41L11 13.17l5.59-5.59L18 9l-7 7z" />
                                    </svg>
                                </p>
                            </div>

                            <!-- Price & Delivery Status -->
                            <div class="absolute bottom-4 right-4 text-white">
                                <p class="text-sm mt-1">
                                    @php
                                    $totalPrice = $order->items->sum('price');
                                    @endphp
                                    <span
                                        class="text-xl text-white font-semibold">₱{{ number_format($totalPrice, 0, '.', ',') }}</span>
                                </p>
                            </div>
                        </a>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>
        </div>

    </div>
</x-app-layout>