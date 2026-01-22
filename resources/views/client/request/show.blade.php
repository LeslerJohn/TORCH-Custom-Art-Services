<x-app-layout>
    <div class="max-w-5xl mt-10 mx-auto bg-white p-6 rounded-lg mb-8 shadow-lg relative overflow-hidden">
        <!-- Status Badge - Moved to top and increased z-index -->
        <div class="absolute top-4 right-4 z-20 animate-bounce-subtle">
            <span class="px-4 py-2 rounded-full text-white font-medium flex items-center gap-2
                {{ $request->status == 'accepted' ? 'bg-green-500' : ($request->status == 'pending' ? 'bg-yellow-500' : 'bg-red-500') }}">
                @if($request->status == 'accepted')
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                @elseif($request->status == 'pending')
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 animate-spin" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                </svg>
                @else
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
                @endif
                {{ ucfirst($request->status ?? 'pending') }}
            </span>
        </div>

        <!-- Status Message Banner with Animation -->
        <div class="mb-6 p-4 rounded-lg border-l-4 transition-all duration-500 transform hover:scale-102 
            {{ $request->status == 'accepted' ? 'bg-green-50 border-green-500' : 
               ($request->status == 'pending' ? 'bg-yellow-50 border-yellow-500' : 'bg-red-50 border-red-500') }}">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    @if($request->status == 'accepted')
                    <svg class="h-5 w-5 text-green-500" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    @elseif($request->status == 'pending')
                    <svg class="h-5 w-5 text-yellow-500 animate-spin-slow" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                    </svg>
                    @else
                    <svg class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                    @endif
                </div>
                <div class="ml-3">
                    <h3 class="text-lg font-medium 
                        {{ $request->status == 'accepted' ? 'text-green-800' : 
                           ($request->status == 'pending' ? 'text-yellow-800' : 'text-red-800') }}">
                        @if ($request->status == 'accepted')
                        Your request has been accepted!
                        @elseif ($request->status == 'pending')
                        The artist is reviewing your request.
                        @else
                        Your request has been rejected.
                        @endif
                    </h3>
                </div>
            </div>
        </div>

        <!-- Request Details Card -->
        <div class="bg-gray-50 p-5 rounded-lg mb-6 shadow-sm transform transition-all duration-300 hover:shadow-md">
            <div class="flex flex-wrap justify-between items-start">
                <div class="mb-4 md:mb-0">
                    <h1 class="text-2xl font-bold mb-2">{{ $request->service->category->name }}</h1>
                    <div class="flex items-center">
                        <span class="text-red-500 text-xl font-semibold">₱{{ number_format($request->total_price, 2) }}</span>
                        <span class="ml-2 px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">{{ ucfirst($request->order_type) }}</span>
                    </div>
                </div>
                <div class="bg-white p-3 rounded-lg shadow-sm border border-gray-100">
                    <p class="text-sm text-gray-500">Estimated Arrival</p>
                    <p class="font-medium">{{ \Carbon\Carbon::parse($request->deadline)->addDays(5)->format('j') }} - {{ \Carbon\Carbon::parse($request->deadline)->addDays(10)->format('j F, Y') }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-1">Description</h3>
                    <p>{{ $request->description }}</p>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-1">Dimension</h3>
                        <p>{{ $request->width }} x {{ $request->height }} {{ $request->unit == 'in' ? 'inches' : 'centimeters' }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-1">Quantity</h3>
                        <p>{{ $request->quantity }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reference Images -->
        <div class="mb-8">
            <h2 class="text-xl font-semibold mb-3 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                </svg>
                Reference Images
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4" id="image-gallery">
                @foreach ($request->images as $index => $image)
                <div class="border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 transform hover:scale-105 opacity-0"
                    style="animation: fadeIn 0.5s ease-out forwards; animation-delay: {{ $index * 0.2 }}s;">
                    <img src="{{ asset('storage/' . $image->attachment->path) }}" alt="Reference Image"
                        class="w-full h-auto">
                </div>
                @endforeach
            </div>
        </div>

        <!-- Support Center -->
        <div class="mb-6 bg-blue-50 p-4 rounded-lg border border-blue-100 flex items-center gap-3 transition-all duration-300 hover:bg-blue-100">
            <div class="flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <h2 class="text-lg font-semibold text-blue-800">Support Center</h2>
                <p class="text-blue-600">Having issues with your request?
                    <a href="mailto:torchtech2024@gmail.com" class="font-medium underline hover:text-blue-800">Contact Support</a>
                </p>
            </div>
        </div>

        <!-- Buttons -->
        <div class="flex justify-end gap-4 mt-8">
            @if ($request->status == 'pending')
            <button type="button" data-modal-target="cancel-request-modal" data-modal-toggle="cancel-request-modal"
                class="px-4 py-2 bg-red-500 text-white rounded-lg shadow hover:bg-red-600 transition-colors transform hover:scale-105 duration-300 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
                Cancel Request
            </button>

            <!-- Cancel Request Modal -->
            <div id="cancel-request-modal" tabindex="-1"
                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full max-w-md max-h-full">
                    <div class="relative bg-white rounded-lg py-6 shadow-lg dark:bg-gray-700 transform transition-all duration-300 scale-95 opacity-0" id="modal-content">
                        <button type="button"
                            class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="cancel-request-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                        <div class="p-6 text-center">
                            <svg class="mx-auto mb-4 text-red-500 w-12 h-12" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            <h3 class="mb-5 text-lg font-medium text-gray-800">Are you sure you want to cancel this request?</h3>
                            <form action="{{ route('client.request.destroy', $request) }}" method="POST" class="space-x-4">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center transition-all duration-300 hover:scale-105">
                                    Yes, Cancel Request
                                </button>
                                <button type="button" data-modal-hide="cancel-request-modal"
                                    class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 transition-all duration-300">
                                    No, Keep Request
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Add the necessary CSS/JS for animations -->
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

        .hover\:scale-102:hover {
            transform: scale(1.02);
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Modal animation
            const modal = document.getElementById('cancel-request-modal');
            const modalContent = document.getElementById('modal-content');

            if (modal) {
                const toggleButtons = document.querySelectorAll('[data-modal-toggle="cancel-request-modal"]');
                const hideButtons = document.querySelectorAll('[data-modal-hide="cancel-request-modal"]');

                toggleButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        modal.classList.toggle('hidden');
                        modal.classList.toggle('flex');

                        if (!modal.classList.contains('hidden')) {
                            setTimeout(() => {
                                modalContent.style.opacity = '1';
                                modalContent.style.transform = 'scale(1)';
                            }, 10);
                        } else {
                            modalContent.style.opacity = '0';
                            modalContent.style.transform = 'scale(0.95)';
                        }
                    });
                });

                hideButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        modalContent.style.opacity = '0';
                        modalContent.style.transform = 'scale(0.95)';

                        setTimeout(() => {
                            modal.classList.add('hidden');
                            modal.classList.remove('flex');
                        }, 300);
                    });
                });
            }

            // Progress bar animation
            const progressFill = document.getElementById('progress-fill');
            if (progressFill) {
                setTimeout(() => {
                    const computedStyle = window.getComputedStyle(progressFill);
                    const width = computedStyle.getPropertyValue('width');
                    progressFill.style.width = '0';

                    setTimeout(() => {
                        progressFill.style.width = width;
                    }, 300);
                }, 300);
            }
        });
    </script>
</x-app-layout>