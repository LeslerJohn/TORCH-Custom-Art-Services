<x-app-layout>
    <div class="max-w-7xl mx-auto mt-8 sm:px-6 lg:px-8 pb-16 overflow-hidden shadow-sm sm:rounded-lg">
        <h1 class="text-2xl font-bold">Requests</h1>

        <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab"
                data-tabs-toggle="#default-tab-content" role="tablist">
                <li class="me-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-lg" id="all-tab" data-tabs-target="#all"
                        type="button" role="tab" aria-controls="all" aria-selected="false">
                        All
                        <span class="ml-2 bg-orange-500 text-white rounded-full px-2 py-1 text-xs">
                            {{ $requests->where('status', '!=', 'accepted')->count() + $commissions->whereIn('status', ['ready', 'wip', 'done'])->count() }}
                        </span>
                    </button>
                </li>
                <li class="me-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-lg" id="profile-tab"
                        data-tabs-target="#profile" type="button" role="tab" aria-controls="profile"
                        aria-selected="false">
                        Request
                        <span class="ml-2 bg-orange-500 text-white rounded-full px-2 py-1 text-xs">
                            {{ $requests->where('status', 'pending')->count() }}
                        </span>
                    </button>
                </li>
                <li class="me-2" role="presentation">
                    <button
                        class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                        id="dashboard-tab" data-tabs-target="#dashboard" type="button" role="tab"
                        aria-controls="dashboard" aria-selected="false">
                        Commission
                        <span class="ml-2 bg-orange-500 text-white rounded-full px-2 py-1 text-xs">
                            {{ $commissions->whereIn('status', ['ready', 'wip', 'done'])->count() }}
                        </span>
                    </button>
                </li>
            </ul>
        </div>
        <div id="default-tab-content">
            <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="all" role="tabpanel"
                aria-labelledby="all-tab">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @if (
                        $requests->where('status', '!=', 'accepted')->isEmpty() &&
                            $commissions->whereIn('status', ['ready', 'wip', 'done'])->isEmpty())
                        <p class="text-center text-gray-500">No requests or commissions found.</p>
                    @else
                        @foreach ($requests->where('status', '!=', 'accepted') as $request)
                            @php
                                $thumbnail = $request->images->first()?->attachment;
                                $service = $request->service;
                            @endphp

                            <div class="relative w-full h-[250px] rounded-lg overflow-hidden shadow-lg">
                                <a href="{{ route('client.request.show', $request) }}">
                                    <!-- Background Image -->
                                    <img src="{{ $thumbnail ? asset('storage/' . $thumbnail->path) : asset('images/default-image.jpg') }}"
                                        alt="{{ $service->category->name ?? 'service' }}"
                                        class="w-full h-full object-cover">

                                    <!-- Overlay -->
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>

                                    <div class="absolute top-4 left-4 right-4 flex justify-between items-center">
                                        <span
                                            class="text-xl text-white font-semibold">₱{{ number_format($request->total_price, 0, '.', ',') }}</span>
                                    </div>

                                    <!-- Text Content -->
                                    <div class="absolute bottom-4 left-4 text-white">
                                        <h2 class="text-lg font-bold">{{ $service->category->name ?? 'Unknown Title' }}
                                        </h2>
                                        <p class="text-sm font-medium flex items-center">
                                            {{ $service->artist->user->name ?? 'Unknown Artist' }}
                                            <svg class="w-4 h-4 text-blue-400 ml-1" fill="currentColor"
                                                viewBox="0 0 24 24">
                                                <path
                                                    d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 15l-4-4 1.41-1.41L11 13.17l5.59-5.59L18 9l-7 7z" />
                                            </svg>
                                        </p>
                                    </div>

                                    <!-- Status -->
                                    <div class="absolute top-4 left-4 right-4 flex justify-between items-center">
                                        <span class="font-semibold text-white text-xs px-2 py-1 rounded-full"
                                            style="background-color: 
                                                @if ($request->status == 'pending') #fcd34d 
                                                @elseif($request->status == 'cancelled') 
                                                    #f87171 
                                                @elseif($request->status == 'accepted') 
                                                    #a3e635 
                                                @else 
                                                    #d1d5db @endif;">
                                            {{ ucfirst($request->status ?? 'Pending') }}
                                        </span>
                                    </div>
                                </a>
                            </div>
                        @endforeach

                        @foreach ($commissions->whereIn('status', ['ready', 'wip', 'done']) as $commission)
                            @php
                                $thumbnail = $commission->request->images->first()?->attachment;
                                $service = $commission->request->service;
                            @endphp

                            <div class="relative w-full h-[250px] rounded-lg overflow-hidden shadow-lg">
                                <a href="{{ route('client.commission.show', $commission) }}">
                                    <!-- Background Image -->
                                    <img src="{{ $thumbnail ? asset('storage/' . $thumbnail->path) : asset('images/default-image.jpg') }}"
                                        alt="{{ $service->category->name ?? 'service' }}"
                                        class="w-full h-full object-cover">

                                    <!-- Overlay -->
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>

                                    <div class="absolute bottom-4 left-4 right-4 flex justify-between items-center">
                                        <div>
                                            <h2 class="text-lg text-white font-bold">
                                                {{ $service->category->name ?? 'Unknown Title' }}
                                            </h2>
                                            <p class="text-sm text-white font-medium flex items-center">
                                                {{ $service->artist->user->name ?? 'Unknown Artist' }}
                                                <svg class="w-4 h-4 text-blue-400 ml-1" fill="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path
                                                        d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 15l-4-4 1.41-1.41L11 13.17l5.59-5.59L18 9l-7 7z" />
                                                </svg>
                                            </p>
                                        </div>
                                        <span
                                            class="text-xl text-white font-semibold">₱{{ number_format($commission->request->total_price, 0, '.', ',') }}</span>
                                    </div>

                                    <!-- Status -->
                                    <div class="absolute top-4 left-4 right-4 flex justify-between items-center">
                                        <span class="font-semibold text-white text-xs px-2 py-1 rounded-full"
                                            style="background-color: 
                                                @if ($commission->status == 'pending') #fcd34d 
                                                @elseif($commission->status == 'cancelled') 
                                                    #f87171 
                                                @elseif($commission->status == 'accepted') 
                                                    #a3e635 
                                                @elseif($commission->status == 'ready') 
                                                    #38bdf8 
                                                @elseif($commission->status == 'wip') 
                                                    #fbbf24 
                                                @elseif($commission->status == 'done') 
                                                    #10b981 
                                                @elseif($commission->status == 'completed') 
                                                    #4ade80 
                                                @else 
                                                    #d1d5db @endif;">
                                            {{ ucfirst($commission->status ?? 'Pending') }}
                                        </span>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
            <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="profile" role="tabpanel"
                aria-labelledby="profile-tab">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @if ($requests->where('status', 'pending')->isEmpty())
                        <p class="text-center text-gray-500">No requests found.</p>
                    @else
                        @foreach ($requests->where('status', 'pending') as $request)
                            @php
                                $thumbnail = $request->images->first()?->attachment;
                                $service = $request->service;
                            @endphp

                            <div class="relative w-full h-[250px] rounded-lg overflow-hidden shadow-lg">
                                <a href="{{ route('client.request.show', $request) }}">
                                    <!-- Background Image -->
                                    <img src="{{ $thumbnail ? asset('storage/' . $thumbnail->path) : asset('images/default-image.jpg') }}"
                                        alt="{{ $service->category->name ?? 'service' }}"
                                        class="w-full h-full object-cover">

                                    <!-- Overlay -->
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>

                                    <div class="absolute top-4 left-4 right-4 flex justify-between items-center">
                                        <span
                                            class="text-xl text-white font-semibold">₱{{ number_format($request->total_price, 0, '.', ',') }}</span>
                                    </div>

                                    <!-- Text Content -->
                                    <div class="absolute bottom-4 left-4 text-white">
                                        <h2 class="text-lg font-bold">{{ $service->category->name ?? 'Unknown Title' }}
                                        </h2>
                                        <p class="text-sm font-medium flex items-center">
                                            {{ $service->artist->user->name ?? 'Unknown Artist' }}
                                            <svg class="w-4 h-4 text-blue-400 ml-1" fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 15l-4-4 1.41-1.41L11 13.17l5.59-5.59L18 9l-7 7z" />
                                            </svg>
                                        </p>
                                    </div>

                                    <!-- Status -->
                                    <div class="absolute top-4 left-4 right-4 flex justify-between items-center">
                                        <span class="font-semibold text-white text-xs px-2 py-1 rounded-full"
                                            style="background-color: 
                                                @if ($request->status == 'pending') #fcd34d 
                                                @elseif($request->status == 'cancelled') 
                                                    #f87171 
                                                @elseif($request->status == 'accepted') 
                                                    #a3e635 
                                                @else 
                                                    #d1d5db @endif;">
                                            {{ ucfirst($request->status ?? 'Pending') }}
                                        </span>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    @endif

                </div>

            </div>
            <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="dashboard" role="tabpanel"
                aria-labelledby="dashboard-tab">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @if ($commissions->whereIn('status', ['ready', 'wip', 'done'])->isEmpty())
                        <p class="text-center text-gray-500">No commissions found.</p>
                    @else
                        @foreach ($commissions->whereIn('status', ['ready', 'wip', 'done']) as $commission)
                            @php
                                $thumbnail = $commission->request->images->first()?->attachment;
                                $service = $commission->request->service;
                            @endphp

                            <div class="relative w-full h-[250px] rounded-lg overflow-hidden shadow-lg">
                                <a href="{{ route('client.commission.show', $commission) }}">
                                    <!-- Background Image -->
                                    <img src="{{ $thumbnail ? asset('storage/' . $thumbnail->path) : asset('images/default-image.jpg') }}"
                                        alt="{{ $service->category->name ?? 'service' }}"
                                        class="w-full h-full object-cover">

                                    <!-- Overlay -->
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>

                                    <div class="absolute bottom-4 left-4 right-4 flex justify-between items-center">
                                        <div>
                                            <h2 class="text-lg text-white font-bold">
                                                {{ $service->category->name ?? 'Unknown Title' }}
                                            </h2>
                                            <p class="text-sm text-white font-medium flex items-center">
                                                {{ $service->artist->user->name ?? 'Unknown Artist' }}
                                                <svg class="w-4 h-4 text-blue-400 ml-1" fill="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path
                                                        d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 15l-4-4 1.41-1.41L11 13.17l5.59-5.59L18 9l-7 7z" />
                                                </svg>
                                            </p>
                                        </div>
                                        <span
                                            class="text-xl text-white font-semibold">₱{{ number_format($commission->request->total_price, 0, '.', ',') }}</span>
                                    </div>

                                    <!-- Status -->
                                    <div class="absolute top-4 left-4 right-4 flex justify-between items-center">
                                        <span class="font-semibold text-white text-xs px-2 py-1 rounded-full"
                                            style="background-color: 
                                                @if ($commission->status == 'pending') #fcd34d 
                                                @elseif($commission->status == 'cancelled') 
                                                    #f87171 
                                                @elseif($commission->status == 'accepted') 
                                                    #a3e635 
                                                @elseif($commission->status == 'ready') 
                                                    #38bdf8 
                                                @elseif($commission->status == 'wip') 
                                                    #fbbf24 
                                                @elseif($commission->status == 'done') 
                                                    #10b981 
                                                @elseif($commission->status == 'completed') 
                                                    #4ade80 
                                                @else 
                                                    #d1d5db @endif;">
                                            {{ ucfirst($commission->status ?? 'Pending') }}
                                        </span>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
