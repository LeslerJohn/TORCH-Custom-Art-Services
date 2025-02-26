<x-admin-layout>
    <div>
        <div class="flex gap-4 items-center mb-6">
            <a href="{{ url()->previous() }}" class="text-blue-600 hover:text-blue-800 flex items-center transition duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
            stroke="currentColor" class="w-6 h-6 mr-2">
            <path stroke-linecap="round" stroke-linejoin="round"
            d="M15 19l-7-7 7-7" />
            </svg>
            Back
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Commission ID #123123</h1>
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
                        <p class="text-gray-800 font-semibold">Jane Smith</p>
                    </div>
                    <div>
                        <label class="text-gray-500 font-medium">Artist Name</label>
                        <p class="text-gray-800 font-semibold">John Doe</p>
                    </div>
            
                    <!-- Artwork Info -->
                    <div>
                        <label class="text-gray-500 font-medium">Medium</label>
                        <p class="text-gray-800">Oil on Canvas</p>
                    </div>
                    <div>
                        <label class="text-gray-500 font-medium">Deadline</label>
                        <p class="text-red-500 font-semibold">12/31/2023</p>
                    </div>
            
                    <!-- Progress & Status -->
                    <div>
                        <label class="text-gray-500 font-medium">Progress</label>
                        <div class="relative w-full bg-gray-200 rounded-full h-2">
                            <div class="absolute top-0 left-0 bg-blue-500 h-2 rounded-full" style="width: 50%;"></div>
                        </div>
                        <p class="text-gray-800 text-sm mt-1">50% Complete</p>
                    </div>
                    <div>
                        <label class="text-gray-500 font-medium">Status</label>
                        <p class="text-yellow-500 font-semibold">In Progress</p>
                    </div>
            
                    <!-- Additional Info -->
                    <div>
                        <label class="text-gray-500 font-medium">Usage</label>
                        <p class="text-gray-800">Personal Collection</p>
                    </div>
                    <div>
                        <label class="text-gray-500 font-medium">Dimensions</label>
                        <p class="text-gray-800">24 x 36 inches</p>
                    </div>
            
                    <!-- Pricing -->
                    <div>
                        <label class="text-gray-500 font-medium">Pricing per cm</label>
                        <p class="text-gray-800">$10</p>
                    </div>
                    <div>
                        <label class="text-gray-500 font-medium">Calculation</label>
                        <p class="text-gray-800">24 x 36 x $10 = <span class="font-semibold">$8640</span></p>
                    </div>
            
                    <!-- Final Pricing -->
                    <div class="col-span-2 bg-gray-100 p-4 rounded-md">
                        <label class="text-gray-600 font-medium">Agreed Total Pricing</label>
                        <p class="text-2xl font-bold text-green-600">$9000</p>
                    </div>
            
                    <!-- Payment & Fees -->
                    <div>
                        <label class="text-gray-500 font-medium">Payment Method</label>
                        <p class="text-gray-800">Credit Card</p>
                    </div>
                    <div>
                        <label class="text-gray-500 font-medium">Commission Fee</label>
                        <p class="text-gray-800">$500</p>
                    </div>
            
                    <!-- Publicity & Timeframe -->
                    <div>
                        <label class="text-gray-500 font-medium">Publicity</label>
                        <p class="text-gray-800">Allowed</p>
                    </div>
                    <div>
                        <label class="text-gray-500 font-medium">Timeframe</label>
                        <p class="text-gray-800">6 months</p>
                    </div>
                </div>
            </div>
            
            <div class="w-1/2">
                <h2 class="text-xl font-semibold mb-4">Custom | Flower</h2>
                <div class="space-y-2">
                <img src="{{asset('images/default.image.jpg')}}" alt="img">
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
