<x-app-layout>
    <div class="max-w-7xl mx-auto mt-8 sm:px-6 lg:px-8 pb-16 overflow-hidden shadow-sm sm:rounded-lg">
        <h1 class="text-2xl font-bold">Orders</h1>

        <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab"
                data-tabs-toggle="#default-tab-content" role="tablist">
                <li class="me-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-lg" id="profile-tab" data-tabs-target="#profile"
                        type="button" role="tab" aria-controls="profile" aria-selected="false">All</button>
                </li>
                <li class="me-2" role="presentation">
                    <button
                        class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                        id="dashboard-tab" data-tabs-target="#dashboard" type="button" role="tab"
                        aria-controls="dashboard" aria-selected="false">Pending</button>
                </li>
                <li class="me-2" role="presentation">
                    <button
                        class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                        id="settings-tab" data-tabs-target="#settings" type="button" role="tab"
                        aria-controls="settings" aria-selected="false">To Recieve</button>
                </li>
                <li role="presentation">
                    <button
                        class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                        id="contacts-tab" data-tabs-target="#contacts" type="button" role="tab"
                        aria-controls="contacts" aria-selected="false">Completed</button>
                </li>
            </ul>
        </div>
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
                                <p class="text-sm font-medium flex items-center">
                                    {{ $artwork->artist->user->name ?? 'Unknown Artist' }}
                                    <svg class="w-4 h-4 text-blue-400 ml-1" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 15l-4-4 1.41-1.41L11 13.17l5.59-5.59L18 9l-7 7z" />
                                    </svg>
                                </p>
                                <span
                                    class="text-xl font-semibold">₱{{ number_format($order->total, 0, '.', ',') }}</span>
                            </div>
                            <!-- Text Content -->
                            <div class="absolute bottom-4 left-4 text-white">
                                <h2 class="text-lg font-bold">{{ $artwork->title ?? 'Unknown Title' }}</h2>
                                <p class="text-sm">| {{ $artwork->category->name ?? 'Uncategorized' }}</p>
                            </div>

                            <!-- Price & Delivery Status -->
                            <div class="absolute bottom-4 right-4 text-white">
                                <p class="text-sm mt-1"><span
                                        class="font-bold">{{ ucfirst($order->delivery->status ?? 'Pending') }}</span>
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
                                <p class="text-sm font-medium flex items-center">
                                    {{ $artwork->artist->user->name ?? 'Unknown Artist' }}
                                    <svg class="w-4 h-4 text-blue-400 ml-1" fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 15l-4-4 1.41-1.41L11 13.17l5.59-5.59L18 9l-7 7z" />
                                    </svg>
                                </p>
                                <span
                                    class="text-xl font-semibold">₱{{ number_format($order->total, 0, '.', ',') }}</span>
                            </div>
                            <!-- Text Content -->
                            <div class="absolute bottom-4 left-4 text-white">
                                <h2 class="text-lg font-bold">{{ $artwork->title ?? 'Unknown Title' }}</h2>
                                <p class="text-sm">| {{ $artwork->category->name ?? 'Uncategorized' }}</p>
                            </div>

                            <!-- Price & Delivery Status -->
                            <div class="absolute bottom-4 right-4 text-white">
                                <p class="text-sm mt-1"><span
                                        class="font-bold">{{ ucfirst($order->delivery->status ?? 'Pending') }}</span>
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
                                <p class="text-sm font-medium flex items-center">
                                    {{ $artwork->artist->user->name ?? 'Unknown Artist' }}
                                    <svg class="w-4 h-4 text-blue-400 ml-1" fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 15l-4-4 1.41-1.41L11 13.17l5.59-5.59L18 9l-7 7z" />
                                    </svg>
                                </p>
                                <span
                                    class="text-xl font-semibold">₱{{ number_format($order->total, 0, '.', ',') }}</span>
                            </div>
                            <!-- Text Content -->
                            <div class="absolute bottom-4 left-4 text-white">
                                <h2 class="text-lg font-bold">{{ $artwork->title ?? 'Unknown Title' }}</h2>
                                <p class="text-sm">| {{ $artwork->category->name ?? 'Uncategorized' }}</p>
                            </div>

                            <!-- Price & Delivery Status -->
                            <div class="absolute bottom-4 right-4 text-white">
                                <p class="text-sm mt-1"><span
                                        class="font-bold">{{ ucfirst($order->delivery->status ?? 'Pending') }}</span>
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
                                <p class="text-sm font-medium flex items-center">
                                    {{ $artwork->artist->user->name ?? 'Unknown Artist' }}
                                    <svg class="w-4 h-4 text-blue-400 ml-1" fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 15l-4-4 1.41-1.41L11 13.17l5.59-5.59L18 9l-7 7z" />
                                    </svg>
                                </p>
                                <span
                                    class="text-xl font-semibold">₱{{ number_format($order->total, 0, '.', ',') }}</span>
                            </div>
                            <!-- Text Content -->
                            <div class="absolute bottom-4 left-4 text-white">
                                <h2 class="text-lg font-bold">{{ $artwork->title ?? 'Unknown Title' }}</h2>
                                <p class="text-sm">| {{ $artwork->category->name ?? 'Uncategorized' }}</p>
                            </div>

                            <!-- Price & Delivery Status -->
                            <div class="absolute bottom-4 right-4 text-white">
                                <p class="text-sm mt-1"><span
                                        class="font-bold">{{ ucfirst($order->delivery->status ?? 'Pending') }}</span>
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