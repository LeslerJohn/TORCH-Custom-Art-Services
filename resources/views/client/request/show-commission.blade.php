<x-app-layout>
    <!-- Load required styles and scripts -->
    <style>
        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.6;
            }
        }

        .animate-pulse-slow {
            animation: pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        .progress-animation {
            width: 0;
            transition: width 1.5s ease-out;
        }

        .status-bubble {
            transition: all 0.3s ease;
        }

        .status-bubble:hover {
            transform: scale(1.1);
        }

        .status-active {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.5);
        }

        .status-completed {
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.5);
        }
    </style>

    <div class="max-w-5xl mt-8 mx-auto bg-white rounded-xl shadow-lg overflow-hidden">
        <!-- Top Status Banner -->
        <div class="relative">
            <div class="absolute top-0 left-0 w-full h-1 bg-gray-200">
                <div id="progress-bar"
                    class="progress-animation h-full
                    {{ $commission->status == 'completed'
                        ? 'bg-green-500 w-full'
                        : ($commission->status == 'done'
                            ? 'bg-blue-500 w-3/4'
                            : ($commission->status == 'wip'
                                ? 'bg-yellow-500 w-1/2'
                                : ($commission->status == 'ready'
                                    ? 'bg-blue-500 w-1/4'
                                    : ($commission->status == 'cancelled'
                                        ? 'bg-red-500 w-full'
                                        : ($commission->status == 'hold'
                                            ? 'bg-orange-500 w-1/2'
                                            : ($commission->status == 'returned'
                                                ? 'bg-purple-500 w-full'
                                                : 'bg-gray-500 w-0')))))) }}">
                </div>
            </div>

            <div
                class="p-6 pt-8 bg-gradient-to-r 
                {{ $commission->status == 'completed'
                    ? 'from-green-50 to-green-100'
                    : ($commission->status == 'done'
                        ? 'from-blue-50 to-blue-100'
                        : ($commission->status == 'wip'
                            ? 'from-yellow-50 to-yellow-100'
                            : ($commission->status == 'ready'
                                ? 'from-blue-50 to-blue-100'
                                : ($commission->status == 'cancelled'
                                    ? 'from-red-50 to-red-100'
                                    : ($commission->status == 'hold'
                                        ? 'from-orange-50 to-orange-100'
                                        : ($commission->status == 'returned'
                                            ? 'from-purple-50 to-purple-100'
                                            : 'from-gray-50 to-gray-100')))))) }}">
                <h1 class="text-2xl font-bold mb-2 text-gray-800">
                    @if ($commission->status == 'done' && $commission->delivery->status == 'pending')
                    Preparing to ship your order
                    @elseif ($commission->status == 'done' && $commission->delivery->status == 'in-transit')
                    Your order is on its way
                    @elseif ($commission->status == 'wip')
                    Your commission is in progress
                    @elseif ($commission->status == 'ready')
                    Commission ready to start
                    @elseif ($commission->status == 'completed')
                    Commission completed
                    @elseif ($commission->status == 'cancelled')
                    Commission cancelled
                    @elseif ($commission->status == 'hold')
                    Commission on hold due to refund request
                    @elseif ($commission->status == 'returned')
                    Commission refunded
                    @else
                    Commission status pending
                    @endif
                </h1>
                <p class="text-sm text-gray-600">
                    @if ($commission->delivery && $commission->delivery->expected_delivery)
                    Expected delivery:
                    {{ \Carbon\Carbon::parse($commission->delivery->expected_delivery)->subDays(5)->format('j') }} -
                    {{ \Carbon\Carbon::parse($commission->delivery->expected_delivery)->format('j F, Y') }}
                    @endif
                </p>
            </div>
        </div>

        <!-- Order Progress Timeline -->
        <div class="py-4 px-6 border-b border-gray-100">
            <div class="flex items-center justify-between mb-2">
                <h2 class="text-lg font-semibold text-gray-700">Order Progress</h2>
                <span
                    class="px-3 py-1 rounded-full text-sm font-medium
            {{ $commission->status == 'completed'
                ? 'bg-green-100 text-green-800'
                : ($commission->status == 'done'
                    ? 'bg-blue-100 text-blue-800'
                    : ($commission->status == 'wip'
                        ? 'bg-yellow-100 text-yellow-800'
                        : ($commission->status == 'ready'
                            ? 'bg-blue-100 text-blue-800'
                            : ($commission->status == 'cancelled'
                                ? 'bg-red-100 text-red-800'
                                : ($commission->status == 'hold'
                                    ? 'bg-orange-100 text-orange-800'
                                    : ($commission->status == 'returned'
                                        ? 'bg-purple-100 text-purple-800'
                                        : 'bg-gray-100 text-gray-800')))))) }}">
                    {{ ucfirst($commission->status ?? 'in_progress') }}
                </span>
            </div>

            <div class="flex items-center justify-between relative mt-10">
                <!-- Progress Line -->
                <div class="absolute top-4 left-4 right-4 h-2 bg-gray-200 z-0 rounded-full overflow-hidden">
                    <div class="h-2 rounded-full progress-line"
                        style="--progress-width: {{ $commission->status == 'completed'
                            ? '100%'
                            : ($commission->status == 'done'
                                ? '65%'
                                : ($commission->status == 'wip'
                                    ? '33%'
                                    : ($commission->status == 'ready'
                                        ? '10%'
                                        : '0%'))) }}">
                    </div>
                </div>

                <!-- Ready -->
                <div class="flex flex-col items-center relative z-10">
                    <div
                        class="w-10 h-10 flex items-center justify-center rounded-full 
                {{ $commission->status == 'ready' ||
                $commission->status == 'wip' ||
                $commission->status == 'done' ||
                $commission->status == 'completed'
                    ? 'bg-blue-500 shadow-lg shadow-blue-200'
                    : 'bg-gray-300' }} icon-animation hover:scale-105 transition-transform duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                            fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" />
                        </svg>
                    </div>
                    <span
                        class="text-sm font-medium mt-2 text-animation
                {{ $commission->status == 'ready' ||
                $commission->status == 'wip' ||
                $commission->status == 'done' ||
                $commission->status == 'completed'
                    ? 'text-blue-500'
                    : 'text-gray-400' }}">Ready</span>
                </div>

                <!-- In Progress -->
                <div class="flex flex-col items-center relative z-10">
                    <div
                        class="w-10 h-10 flex items-center justify-center rounded-full 
                {{ $commission->status == 'wip' || $commission->status == 'done' || $commission->status == 'completed'
                    ? 'bg-blue-500 shadow-lg shadow-blue-200'
                    : ($commission->status == 'ready'
                        ? 'bg-white border-2 border-blue-500 animate-pulse'
                        : 'bg-gray-300') }} icon-animation-delay-1 hover:scale-105 transition-transform duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                            fill="none"
                            stroke="{{ $commission->status == 'wip' || $commission->status == 'done' || $commission->status == 'completed' ? '#ffffff' : ($commission->status == 'ready' ? '#3b82f6' : '#9ca3af') }}"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path
                                d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" />
                        </svg>
                    </div>
                    <span
                        class="text-sm font-medium mt-2 text-animation-delay-1
                {{ $commission->status == 'wip' || $commission->status == 'done' || $commission->status == 'completed'
                    ? 'text-blue-500'
                    : ($commission->status == 'ready'
                        ? 'text-blue-500'
                        : 'text-gray-400') }}">In
                        Progress</span>
                </div>

                <!-- Ready to Ship -->
                <div class="flex flex-col items-center relative z-10">
                    <div
                        class="w-10 h-10 flex items-center justify-center rounded-full 
                {{ $commission->status == 'done' || $commission->status == 'completed'
                    ? 'bg-blue-500 shadow-lg shadow-blue-200'
                    : ($commission->status == 'wip'
                        ? 'bg-white border-2 border-blue-500 animate-pulse'
                        : 'bg-gray-300') }} icon-animation-delay-2 hover:scale-105 transition-transform duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                            fill="none"
                            stroke="{{ $commission->status == 'done' || $commission->status == 'completed' ? '#ffffff' : ($commission->status == 'wip' ? '#3b82f6' : '#9ca3af') }}"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path
                                d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                            <path
                                d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z" />
                        </svg>
                    </div>
                    <span
                        class="text-sm font-medium mt-2 text-animation-delay-2
                {{ $commission->status == 'done' || $commission->status == 'completed'
                    ? 'text-blue-500'
                    : ($commission->status == 'wip'
                        ? 'text-blue-500'
                        : 'text-gray-400') }}">Ready
                        to Ship</span>
                </div>

                <!-- Completed -->
                <div class="flex flex-col items-center relative z-10">
                    <div
                        class="w-10 h-10 flex items-center justify-center rounded-full 
                {{ $commission->status == 'completed'
                    ? 'bg-green-500 shadow-lg shadow-green-200 animate-bounce-subtle'
                    : ($commission->status == 'done'
                        ? 'bg-white border-2 border-blue-500 animate-pulse'
                        : 'bg-gray-300') }} icon-animation-delay-3 hover:scale-105 transition-transform duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                            fill="none"
                            stroke="{{ $commission->status == 'completed' ? '#ffffff' : ($commission->status == 'done' ? '#3b82f6' : '#9ca3af') }}"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path
                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" />
                        </svg>
                    </div>
                    <span
                        class="text-sm font-medium mt-2 text-animation-delay-3
                {{ $commission->status == 'completed'
                    ? 'text-green-500'
                    : ($commission->status == 'done'
                        ? 'text-blue-500'
                        : 'text-gray-400') }}">Completed</span>
                </div>
            </div>
        </div>

        <style>
            /* Progress Line Animation */
            @keyframes progress-line-animation {
                0% {
                    width: 0%;
                }

                100% {
                    width: var(--progress-width);
                }
            }

            /* Animated stripes for progress line */
            @keyframes progress-stripes {
                0% {
                    background-position: 0 0;
                }

                100% {
                    background-position: 50px 0;
                }
            }

            /* Pulse animation for active state */
            @keyframes progress-pulse {
                0% {
                    box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.4);
                }

                70% {
                    box-shadow: 0 0 0 5px rgba(59, 130, 246, 0);
                }

                100% {
                    box-shadow: 0 0 0 0 rgba(59, 130, 246, 0);
                }
            }

            .progress-line {
                position: relative;
                width: var(--progress-width);
                animation:
                    progress-line-animation 1.5s ease-out forwards,
                    progress-pulse 2s infinite;
                background: linear-gradient(45deg,
                        rgba(59, 130, 246, 1) 25%,
                        rgba(96, 165, 250, 1) 25%,
                        rgba(96, 165, 250, 1) 50%,
                        rgba(59, 130, 246, 1) 50%,
                        rgba(59, 130, 246, 1) 75%,
                        rgba(96, 165, 250, 1) 75%,
                        rgba(96, 165, 250, 1));
                background-size: 25px 25px;
                animation:
                    progress-line-animation 1.5s ease-out forwards,
                    progress-stripes 1s linear infinite,
                    progress-pulse 2s infinite;
            }

            /* Add shine effect */
            .progress-line::after {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 50%;
                height: 100%;
                background: linear-gradient(90deg,
                        rgba(255, 255, 255, 0) 0%,
                        rgba(255, 255, 255, 0.4) 50%,
                        rgba(255, 255, 255, 0) 100%);
                animation: shine 2s infinite;
            }

            @keyframes shine {
                0% {
                    left: -100%;
                }

                100% {
                    left: 200%;
                }
            }

            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(10px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            @keyframes bounce-subtle {

                0%,
                100% {
                    transform: translateY(0);
                }

                50% {
                    transform: translateY(-5px);
                }
            }

            .animate-bounce-subtle {
                animation: bounce-subtle 2s infinite;
            }

            .animate-pulse {
                animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
            }

            @keyframes pulse {

                0%,
                100% {
                    opacity: 1;
                }

                50% {
                    opacity: 0.7;
                }
            }

            .hover\:scale-105:hover {
                transform: scale(1.05);
            }

            /* Icon Animation */
            @keyframes icon-pulse {
                0% {
                    transform: scale(0);
                    opacity: 0;
                }

                60% {
                    transform: scale(1.1);
                    opacity: 1;
                }

                100% {
                    transform: scale(1);
                    opacity: 1;
                }
            }

            /* Text Animation */
            @keyframes text-fade-in {
                0% {
                    opacity: 0;
                    transform: translateY(5px);
                }

                100% {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .icon-animation {
                animation: icon-pulse 0.6s ease-in-out forwards;
                opacity: 0;
                /* Start invisible */
            }

            .icon-animation-delay-1 {
                animation: icon-pulse 0.6s ease-in-out 0.2s forwards;
                opacity: 0;
                /* Start invisible */
            }

            .icon-animation-delay-2 {
                animation: icon-pulse 0.6s ease-in-out 0.4s forwards;
                opacity: 0;
                /* Start invisible */
            }

            .icon-animation-delay-3 {
                animation: icon-pulse 0.6s ease-in-out 0.6s forwards;
                opacity: 0;
                /* Start invisible */
            }

            .text-animation {
                animation: text-fade-in 0.5s ease-in-out 0.3s forwards;
                opacity: 0;
                /* Start invisible */
            }

            .text-animation-delay-1 {
                animation: text-fade-in 0.5s ease-in-out 0.5s forwards;
                opacity: 0;
                /* Start invisible */
            }

            .text-animation-delay-2 {
                animation: text-fade-in 0.5s ease-in-out 0.7s forwards;
                opacity: 0;
                /* Start invisible */
            }

            .text-animation-delay-3 {
                animation: text-fade-in 0.5s ease-in-out 0.9s forwards;
                opacity: 0;
                /* Start invisible */
            }
        </style>

        <!-- Commission Details -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6">
            <div class="bg-white rounded-lg shadow-sm p-5 border border-gray-100">
                <h2 class="text-xl font-semibold mb-4 text-gray-800">Commission Details</h2>
                <div class="space-y-3">
                    <div class="flex justify-between items-center border-b border-gray-100 pb-3">
                        <span class="text-gray-500">Category</span>
                        <span class="font-semibold">{{ $commission->request->service->category->name }}</span>
                    </div>
                    <div class="flex justify-between items-center border-b border-gray-100 pb-3">
                        <span class="text-gray-500">Price</span>
                        <span
                            class="font-semibold text-red-500">₱{{ number_format($commission->request->total_price, 2) }}</span>
                    </div>
                    <div class="flex justify-between items-center border-b border-gray-100 pb-3">
                        <span class="text-gray-500">Dimension</span>
                        <span class="font-semibold">{{ $commission->request->width }} x
                            {{ $commission->request->height }} {{ $commission->request->unit }}</span>
                    </div>
                    <div class="flex justify-between items-center border-b border-gray-100 pb-3">
                        <span class="text-gray-500">Quantity</span>
                        <span class="font-semibold">{{ $commission->request->quantity }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-500">Order Type</span>
                        <span class="font-semibold">{{ ucfirst($commission->request->order_type) }}</span>
                    </div>
                </div>
            </div>

            <!-- Delivery Information -->
            <div class="bg-white rounded-lg shadow-sm p-5 border border-gray-100">
                <h2 class="text-xl font-semibold mb-4 text-gray-800">Delivery Details</h2>
                <div class="space-y-3">
                    <div class="flex justify-between items-center border-b border-gray-100 pb-3">
                        <span class="text-gray-500">Status</span>
                        <span
                            class="font-semibold px-2 py-1 rounded-full text-xs 
                            {{ $commission->delivery->status == 'pending'
                                ? 'bg-yellow-100 text-yellow-800'
                                : ($commission->delivery->status == 'in-transit'
                                    ? 'bg-blue-100 text-blue-800'
                                    : ($commission->delivery->status == 'delivered'
                                        ? 'bg-green-100 text-green-800'
                                        : 'bg-gray-100 text-gray-800')) }}">
                            {{ ucfirst($commission->delivery->status) }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center border-b border-gray-100 pb-3">
                        <span class="text-gray-500">Contact Number</span>
                        <span class="font-semibold">+63 {{ Auth::user()->phone_number }}</span>
                    </div>
                    <div class="flex justify-between items-center border-b border-gray-100 pb-3">
                        <span class="text-gray-500">Address</span>
                        <span class="font-semibold text-right">{{ $commission->delivery->address->barangay }},
                            {{ $commission->delivery->address->street }}, House No.
                            {{ $commission->delivery->address->house_number }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-500">Expected Delivery</span>
                        <span
                            class="font-semibold">{{ \Carbon\Carbon::parse($commission->delivery->expected_delivery)->subDays(5)->format('j') }}
                            -
                            {{ \Carbon\Carbon::parse($commission->delivery->expected_delivery)->format('j F, Y') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Extension Information -->
        @if ($commission->extension && $commission->extension->status == 'approved')
        <div class="mx-6 my-4 p-4 bg-yellow-50 border border-yellow-200 rounded-lg shadow-sm">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-yellow-800">Extension Approved</h3>
                    <div class="mt-1 text-sm text-yellow-700">
                        <p>Your commission has been granted an extension of 7 days. Please note the updated delivery
                            date.</p>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Drafts -->
        @if (count($commission->drafts) > 0)
        <div class="p-6 border-t border-gray-100">
            <h2 class="text-xl font-semibold mb-4 text-gray-800">Drafts</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                @foreach ($commission->drafts as $draft)
                <div
                    class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-300">
                    <img src="{{ asset('storage/' . $draft->attachment->path) }}" alt="Draft Image"
                        class="w-full h-48 object-cover">
                    <div class="p-3">
                        <p class="text-sm text-gray-600">{{ $draft->description }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        @if ($commission->delivery->status === 'completed')
        <div class="bg-gray-50 p-6 mt-8 mb-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Proof of Delivery</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach ($commission->delivery->proofs as $proof)
                <div class="relative group">
                    <img src="{{ asset('storage/' . $proof->attachment->path) }}" alt="Proof of Delivery"
                        class="w-full h-32 object-cover rounded-md shadow-md">
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

        <!-- Action Buttons -->
        <div class="p-6 border-t border-gray-100">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="flex items-center mb-4 md:mb-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500 mr-2" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                            clip-rule="evenodd" />
                    </svg>
                    <p class="text-gray-600">Having issues? <a href="mailto:torchtech2024@gmail.com"
                            class="text-blue-500 hover:text-blue-700 transition-colors">Contact Support</a></p>
                </div>

                <div class="flex space-x-3">
                    @if ($commission->status == 'done' && $commission->delivery->status == 'pending')
                    <p class="text-blue-500 font-medium">Your commission is ready for delivery.</p>
                    @elseif ($commission->delivery->status == 'delivered')
                    <form action="{{ route('client.commission.receive', $commission) }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg shadow-sm transition-colors">
                            Received
                        </button>
                    </form>

                    @if (!$commission->refund)
                    <button data-modal-target="return-refund-modal" data-modal-toggle="return-refund-modal"
                        class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg shadow-sm transition-colors">
                        Return/Refund
                    </button>
                    @else
                    <p class="text-red-500 text-sm md:text-base">Refund request already submitted</p>
                    @endif
                    @elseif ($commission->status == 'completed')
                    @if (!$commission->reviews->where('commission_id', $commission->id)->count())
                    <button data-modal-target="crud-modal" data-modal-toggle="crud-modal"
                        class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg shadow-sm transition-colors">
                        Leave a Review
                    </button>
                    @else
                    <p class="text-green-500 font-medium">Thanks for your review!</p>
                    @endif
                    @elseif ($commission->status == 'hold')
                    <p class="text-red-500 text-sm md:text-base">Refund request is being processed</p>
                    @elseif ($commission->status == 'returned')
                    <p class="text-red-500 text-sm md:text-base">Refunded with 10% service fee deducted</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Review Modal -->
    <div id="crud-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow-lg">
                <div class="flex items-center justify-between p-4 border-b rounded-t">
                    <h3 class="text-lg font-semibold text-gray-900">Leave a Review</h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                        data-modal-toggle="crud-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <form action="{{ route('client.review.commission', $commission) }}" method="POST" class="p-4">
                    @csrf
                    <div class="grid gap-4 mb-4 grid-cols-2">
                        <div class="mb-4" x-data="{ rating: 0 }">
                            <input type="hidden" name="rating" x-model="rating">
                            <div class="flex items-center">
                                <template x-for="star in 5">
                                    <svg @click="rating = star"
                                        :class="rating >= star ? 'text-yellow-300' : 'text-gray-300'"
                                        class="w-8 h-8 cursor-pointer transition duration-200" fill="currentColor"
                                        viewBox="0 0 22 20" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z">
                                        </path>
                                    </svg>
                                </template>
                            </div>
                            <p class="mt-2 text-sm text-gray-600">Selected Rating: <span x-text="rating"></span>/5</p>
                        </div>
                        <div class="col-span-2">
                            <label for="comment" class="block mb-2 text-sm font-medium text-gray-900">Your
                                Review</label>
                            <textarea name="comment" id="comment" rows="4"
                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Share your experience..."></textarea>
                        </div>
                    </div>
                    <button type="submit"
                        class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center transition-colors">
                        Submit Review
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Return/Refund Modal -->
    <div id="return-refund-modal" tabindex="-1"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow-lg">
                <button type="button"
                    class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                    data-modal-hide="return-refund-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-6 text-center">
                    <svg class="mx-auto mb-4 w-12 h-12 text-yellow-400" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-800">Return/Refund Request</h3>
                    <p class="mb-4 text-sm text-gray-600">Are you sure you want to request a return/refund? Please note
                        that a 15% service fee will be deducted from your refund amount.</p>

                    <form action="{{ route('client.return.commission', $commission) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="reason"
                                class="block mb-2 text-sm font-medium text-gray-900 text-left">Reason for
                                return/refund:</label>
                            <textarea id="reason" name="reason" rows="3"
                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Please explain why you're requesting a refund..."></textarea>
                        </div>
                        <div class="mb-4">
                            <label for="evidence"
                                class="block mb-2 text-sm font-medium text-gray-900 text-left">Upload Evidence (Images
                                Only):</label>
                            <input type="file" id="evidence" name="evidence" accept="image/*"
                                class="block w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div class="flex justify-center space-x-4">
                            <button type="button"
                                class="py-2 px-4 text-gray-500 bg-white hover:bg-gray-100 rounded-lg border border-gray-200 text-sm font-medium focus:ring-4 focus:outline-none focus:ring-gray-200"
                                data-modal-hide="return-refund-modal">
                                Cancel
                            </button>
                            <button type="submit"
                                class="py-2 px-4 text-white bg-yellow-600 hover:bg-yellow-700 focus:ring-4 focus:outline-none focus:ring-yellow-300 font-medium rounded-lg text-sm">
                                Submit Request
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript to initialize the modals and handle interactions -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize modals
            const modalButtons = document.querySelectorAll('[data-modal-toggle], [data-modal-target]');
            const modalCloseButtons = document.querySelectorAll('[data-modal-hide]');

            // Modal open functionality
            modalButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const targetId = this.getAttribute('data-modal-target') || this.getAttribute(
                        'data-modal-toggle');
                    const modal = document.getElementById(targetId);

                    if (modal) {
                        modal.classList.remove('hidden');
                        modal.classList.add('flex');
                    }
                });
            });

            // Modal close functionality
            modalCloseButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const targetId = this.getAttribute('data-modal-hide');
                    const modal = document.getElementById(targetId);

                    if (modal) {
                        modal.classList.add('hidden');
                        modal.classList.remove('flex');
                    }
                });
            });

            // Initialize progress bar animation
            setTimeout(() => {
                const progressBar = document.getElementById('progress-bar');
                if (progressBar) {
                    progressBar.style.width = progressBar.classList.contains('w-0') ? '0%' :
                        (progressBar.classList.contains('w-1/4') ? '25%' :
                            (progressBar.classList.contains('w-1/2') ? '50%' :
                                (progressBar.classList.contains('w-3/4') ? '75%' : '100%')));
                }
            }, 300);
        });
    </script>
</x-app-layout>