<x-app-layout>
    <div class="max-w-7xl mx-auto mt-8 sm:px-6 lg:px-8 pb-16 overflow-hidden shadow-sm sm:rounded-lg">
        <h1 class="text-2xl font-bold">Requests</h1>

        <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab"
                data-tabs-toggle="#default-tab-content" role="tablist">
                <li class="me-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-lg" id="profile-tab" data-tabs-target="#profile"
                        type="button" role="tab" aria-controls="profile" aria-selected="false">Request</button>
                </li>
                <li class="me-2" role="presentation">
                    <button
                        class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                        id="dashboard-tab" data-tabs-target="#dashboard" type="button" role="tab"
                        aria-controls="dashboard" aria-selected="false">Commission</button>
                </li>
                {{-- <li class="me-2" role="presentation">
                    <button
                        class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                        id="settings-tab" data-tabs-target="#settings" type="button" role="tab"
                        aria-controls="settings" aria-selected="false">Pending</button>
                </li>
                <li role="presentation">
                    <button
                        class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                        id="contacts-tab" data-tabs-target="#contacts" type="button" role="tab"
                        aria-controls="contacts" aria-selected="false">Completed</button>
                </li> --}}
            </ul>
        </div>
        <div id="default-tab-content">
            <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="profile" role="tabpanel"
                aria-labelledby="profile-tab">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @if ($requests->isEmpty())
                        <p class="text-center text-gray-500">No requests found.</p>
                    @else
                        @foreach ($requests as $request)
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
                                        <h2 class="text-lg font-bold">{{ $service->category->name ?? 'Unknown Title' }}</h2>
                                        <p class="text-sm font-medium flex items-center">
                                            {{ $service->artist->user->name ?? 'Unknown Artist' }}
                                            <svg class="w-4 h-4 text-blue-400 ml-1" fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 15l-4-4 1.41-1.41L11 13.17l5.59-5.59L18 9l-7 7z" />
                                            </svg>
                                        </p>
                                    </div>

                                    <!-- Status -->
                                    <div class="absolute bottom-4 right-4 text-white">
                                        <p class="text-sm mt-1"><span
                                                class="font-bold">{{ ucfirst($request->status ?? 'Pending') }}</span></p>
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
                    @if ($commissions->isEmpty())
                        <p class="text-center text-gray-500">No commissions found.</p>
                    @else
                        @foreach ($commissions as $commission)
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

                                    <div class="absolute top-4 left-4 right-4 flex justify-between items-center">
                                        <p class="text-sm font-medium flex items-center">
                                            {{ $service->artist->user->name ?? 'Unknown Artist' }}
                                            <svg class="w-4 h-4 text-blue-400 ml-1" fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 15l-4-4 1.41-1.41L11 13.17l5.59-5.59L18 9l-7 7z" />
                                            </svg>
                                        </p>
                                        <span
                                            class="text-xl font-semibold">₱{{ number_format($commission->request->total_price, 0, '.', ',') }}</span>
                                    </div>

                                    <!-- Text Content -->
                                    <div class="absolute bottom-4 left-4 text-white">
                                        <h2 class="text-lg font-bold">{{ $service->category->name ?? 'Unknown Title' }}
                                        </h2>
                                    </div>

                                    <!-- Status -->
                                    <div class="absolute bottom-4 right-4 text-white">
                                        <p class="text-sm mt-1"><span
                                                class="font-bold">{{ ucfirst($commission->status ?? 'Pending') }}</span>
                                        </p>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
            <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="settings" role="tabpanel"
                aria-labelledby="settings-tab">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-6">

                </div>
            </div>
            <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="contacts" role="tabpanel"
                aria-labelledby="contacts-tab">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-6">

                </div>
            </div>
        </div>

    </div>
</x-app-layout>
