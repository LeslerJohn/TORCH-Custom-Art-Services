<x-app-layout>
    <div class="mt-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 bg-gray-200">
        {{-- <a href="{{ route('dashboard') }}">
            <x-secondary-button class="justify-center py-1 w-20 text-md hover:border-blue-500">
                Back
            </x-secondary-button>
        </a> --}}
        <div class="flex gap-6 py-4 w-full">
            <div id="default-carousel" class="relative w-1/2 h-full" data-carousel="slide">
                <!-- Carousel wrapper -->
                <div class="relative h-56 overflow-hidden rounded-lg md:h-96">
                    @foreach ($service->images as $index => $image)
                        <div class="{{ $index === 0 ? '' : 'hidden' }} duration-700 ease-in-out" data-carousel-item>
                            <img src="{{ $image->attachment ? asset('storage/' . $image->attachment->path) : asset('images/default.image.jpg') }}"
                                class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
                                alt="...">
                        </div>
                    @endforeach
                </div>
                <!-- Slider indicators -->
                <div class="absolute z-30 flex -translate-x-1/2 bottom-5 left-1/2 space-x-3 rtl:space-x-reverse">
                    @foreach ($service->images as $index => $image)
                        <button type="button" class="w-3 h-3 rounded-full"
                            aria-current="{{ $index === 0 ? 'true' : 'false' }}" aria-label="Slide {{ $index + 1 }}"
                            data-carousel-slide-to="{{ $index }}"></button>
                    @endforeach
                </div>
                <!-- Slider controls -->
                <button type="button"
                    class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                    data-carousel-prev>
                    <span
                        class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                        <svg class="w-4 h-4 text-black dark:text-gray-800 rtl:rotate-180" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 1 1 5l4 4" />
                        </svg>
                        <span class="sr-only">Previous</span>
                    </span>
                </button>
                <button type="button"
                    class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                    data-carousel-next>
                    <span
                        class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                        <svg class="w-4 h-4 text-black dark:text-gray-800 rtl:rotate-180" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 9 4-4-4-4" />
                        </svg>
                        <span class="sr-only">Next</span>
                    </span>
                </button>
            </div>

            <div class="flex w-1/2 flex-col">
                    <h1 class="text-3xl font-bold font-bold-300">{{ $service->category->name }}</h1>
                    <p class="text-2xl text-red-600">₱<strong>{{ number_format($service->price_rate, 0, '.', ',') }} per square inch.</strong></p>
                    <p class="text-lg text-gray-500">Completion time: {{$service->normal_timeframe}} days</p>
                
                    <div class="flex items-center gap-2 mt-2">
                        <img src="{{ asset('images/profile.default.jpg') }}" alt="Artist"
                            class="w-10 h-10 rounded-full border border-white">
                        <div>
                            <p class="text-sm font-medium flex items-center">
                                {{ $service->artist->user->name ?? 'John Doe' }}
                                <svg class="w-4 h-4 text-blue-400 ml-1" fill="currentColor"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 15l-4-4 1.41-1.41L11 13.17l5.59-5.59L18 9l-7 7z" />
                                </svg>
                            </p>
                            <p class="text-sm text-gray-400">{{ '@' . $service->artist->username }}</p>
                        </div>
                    </div>
                    <div class="mt-0.5 p-2 bg-white rounded-md">
                        <p>Thanks for considering me for your commission! Please only start a request if you find the service details and TORCH's Terms of Service acceptable.</p>
                    </div>
                <hr class="w-full my-4 h-2 border-gray-500">

                <div>
                    <h2 class="text-xl font-semibold">Rush Order</h2>
                    <p class="text-lg text-red-500">₱{{ number_format($service->rush_price_rate, 0, '.', ',') }} per square inch.</p>
                    <p class="text-lg text-gray-500">Completion time: {{$service->rush_timeframe}} days</p>
                    <div class="flex flex-wrap gap-2 mt-2">
                        @foreach ($service->tags as $tag)
                            <span
                                class="bg-green-200 text-sm text-gray-700 px-4 py-1 rounded-full">{{ $tag->name }}</span>
                        @endforeach
                    </div>
                </div>

                <div>
                    <h2 class="text-xl font-semibold mt-4">Contact</h2>
                    <p class="mt-2"><strong>Email:</strong> {{ $service->artist->user->email ?? 'test@email.com' }}
                    </p>
                    <p class="mt-1"><strong>Phone:</strong> {{ $service->artist->phone_number }}</p>
                </div>

                <div class="flex flex-col gap-4 p-4 bg-white rounded-md mt-4 border border-gray-300 shadow-sm">
                    <div>
                        <h2 class="text-lg font-semibold mb-2">Includes</h2>
                        <ul class="list-disc pl-5 text-gray-700">
                            <li>Handcrafted illustrations using traditional mediums.</li>
                            <li>Ideal for detailed compositions, including intricate backgrounds and scenes.</li>
                        </ul>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold mb-2">Pricing Framework</h2>
                        <ul class="list-disc pl-5 text-gray-700">
                            <li>Pricing is based on the artist’s base price per square inch.</li>
                            <li>The total cost is calculated as: <span class="font-semibold">Length × Width × Base Price</span></li>
                            <li>Rush orders will have an additional fee.</li>
                        </ul>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold mb-2">Details</h2>
                        <ul class="list-disc pl-5 text-gray-700">
                            <li>Sizes vary based on composition; custom dimensions available upon request.</li>
                            <li>Full scenes included, incorporating depth and artistic storytelling.</li>
                        </ul>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold mb-2">Important</h2>
                        <ul class="list-disc pl-5 text-gray-700">
                            <li>Base prices may vary depending on detail level, materials, and artist's experience.</li>
                            <li>No cancellation once the commission has started.</li>
                        </ul>
                    </div>
                </div>

                <div class="mt-4 flex flex-col gap-4 justify-center">
                    <div class="flex items-center">
                        <input id="terms" type="checkbox" class="mr-2">
                        <label for="terms" class="text-sm text-gray-700">I agree to the <a href="#" class="text-blue-600 underline">Terms of Service</a></label>
                    </div>
                    <div class="flex justify-center">
                        <button id="start-request-btn" data-modal-target="authentication-modal" data-modal-toggle="authentication-modal"
                            class="block w-full max-w-md text-white text-xl bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-4 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 disabled:opacity-50"
                            type="button" disabled>
                            Start your request
                        </button>
                    </div>

                    <script>
                        document.getElementById('terms').addEventListener('change', function() {
                            document.getElementById('start-request-btn').disabled = !this.checked;
                        });
                    </script>
                </div>

                <!-- Main modal -->
                <div id="authentication-modal" tabindex="-1" aria-hidden="true"
                    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-full">
                    <div class="relative p-4 w-full max-w-7xl max-h-full">
                        <!-- Modal content -->
                        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                            <!-- Modal header -->
                            <div
                                class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                    Checkout
                                </h3>
                                <button type="button"
                                    class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                    data-modal-hide="authentication-modal">
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                    </svg>
                                    <span class="sr-only">Close modal</span>
                                </button>
                            </div>
                            <!-- Modal body -->
                            <div class="flex gap-2 w-full justify-center p-4 md:p-5">
                                <div class="w-1/2">
                                    <div class="flex items-center gap-2 mt-2">
                                        <img src="{{ asset('images/profile.default.jpg') }}" alt="Artist"
                                            class="w-10 h-10 rounded-full border border-white">
                                        <div>
                                            <p class="text-sm font-medium flex items-center">
                                                {{ $service->artist->user->name ?? 'John Doe' }}
                                                <svg class="w-4 h-4 text-blue-400 ml-1" fill="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path
                                                        d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 15l-4-4 1.41-1.41L11 13.17l5.59-5.59L18 9l-7 7z" />
                                                </svg>
                                            </p>
                                            <p class="text-sm text-gray-400">{{ '@' . $service->artist->username }}</p>
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <div class="p-4 bg-gray-100 w-full max-w-md rounded-md shadow mb-4">
                                            <p><strong>Price Rate:</strong> ₱{{ number_format($service->price_rate, 0, '.', ',') }} per square inch</p>
                                            <p>Completion time: {{$service->normal_timeframe}} days</p>
                                        </div>
                                        <div class="p-4 bg-gray-100 w-full max-w-md rounded-md shadow">
                                            <p><strong>Rush Price Rate:</strong> ₱{{ number_format($service->rush_price_rate, 0, '.', ',') }} per square inch</p>
                                            <p>Completion time: {{$service->rush_timeframe}} days</p>
                                        </div>
                                        <div class="flex flex-wrap gap-2 mt-2">
                                            @foreach ($service->tags as $tag)
                                                <span class="bg-green-200 text-sm text-gray-700 px-4 py-1 rounded-full">{{ $tag->name }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="flex items-center mt-4 w-full max-w-sm border border-black rounded-md p-2">
                                        <p class="text-sm mx-4">Accepts</p>
                                        <img src="{{asset('images/paymongo.png')}}" alt="Paymongo" class="h-4">
                                    </div>
                                    <div class="mt-4 flex flex-col gap-2">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M13 7h6l2 4m-8-4v8m0-8V6a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v9h2m8 0H9m4 0h2m4 0h2v-4m0 0h-5m3.5 5.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Zm-10 0a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Z"/>
                                            </svg>
                                            <p class="text-sm">Shipping within Zamboanga is Free.</p>                                            
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8.5 11.5 11 14l4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                            </svg>                                              
                                            <p class="text-sm">7-day money back guarantee.</p>                                            
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M10 3v4a1 1 0 0 1-1 1H5m4 10v-2m3 2v-6m3 6v-3m4-11v16a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V7.914a1 1 0 0 1 .293-.707l3.914-3.914A1 1 0 0 1 9.914 3H18a1 1 0 0 1 1 1Z"/>
                                            </svg>                                              
                                            <p class="text-sm">Quality assured.</p>                                            
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M6 6l12 12M6 18L18 6"/>
                                            </svg>                                              
                                            <p class="text-sm">No cancellation once accepted.</p>                                            
                                        </div>
                                    </div>
                                </div>
                                <form class="space-y-4 w-1/2" action="{{route('client.request.store', $service)}}" method="POST" enctype="multipart/form-data" x-data="orderForm()">
                                    @csrf
                                    <h1 class="text-xl font-bold">Request an Artwork</h1>
                                
                                    <!-- Description -->
                                    <div>
                                        <x-input-label for="description" :value="__('Artwork Description')" />
                                        <textarea id="description" name="description" class="block w-full border-gray-300 rounded-md shadow-sm"
                                            placeholder="Describe the details of your artwork..." required></textarea>
                                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                                    </div>
                                
                                    <!-- Dimensions -->
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <x-input-label for="width" :value="__('Width')" />
                                            <div class="flex">
                                                <x-text-input id="width" class="block w-full" type="number" name="width" x-model="width" min="1" required />
                                                <select class="ml-2 border-gray-300 rounded-md" x-model="unit" name="unit">
                                                    <option value="cm">cm</option>
                                                    <option value="in">inches</option>
                                                </select>
                                            </div>
                                            <small class="text-gray-500">Enter the width of your artwork.</small>
                                        </div>
                                
                                        <div>
                                            <x-input-label for="height" :value="__('Height')" />
                                            <div class="flex">
                                                <x-text-input id="height" class="block w-full" type="number" name="height" x-model="height" min="1" required />
                                                <select class="ml-2 border-gray-300 rounded-md" x-model="unit" name="unit">
                                                    <option value="cm">cm</option>
                                                    <option value="in">inches</option>
                                                </select>
                                            </div>
                                            <small class="text-gray-500">Enter the height of your artwork.</small>
                                        </div>
                                    </div>
                                
                                    <!-- Deadline -->
                                    <div>
                                        <x-input-label for="deadline" :value="__('Deadline')" />
                                        <x-text-input id="deadline" class="block w-full" type="date" name="deadline" x-model="deadline" required />
                                        <small class="text-gray-500">Rush orders may increase the price.</small>
                                    </div>
                                
                                    <!-- References (Multiple Image Upload) -->
                                    <div x-data="{ files: [] }">
                                        <x-input-label for="references" :value="__('Reference Images')" />
                                        <input id="references" type="file" name="references[]" accept="image/*" multiple class="block w-full border-gray-300 rounded-md shadow-sm" @change="files = Array.from($event.target.files)">
                                        <small class="text-gray-500">Upload images that help illustrate your request (max 5 images).</small>
                                        <x-input-error :messages="$errors->get('references')" class="mt-2" />
                                        
                                        <!-- Display selected images -->
                                        <div class="mt-4 grid grid-cols-2 gap-4">
                                            <template x-for="file in files" :key="file.name">
                                                <div class="relative">
                                                    <img :src="URL.createObjectURL(file)" class="w-full h-32 object-cover rounded-md">
                                                    <button type="button" class="absolute top-1 right-1 bg-red-500 text-white rounded-full p-1" @click="files = files.filter(f => f !== file)">
                                                        &times;
                                                    </button>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                
                                    <!-- Price Calculator -->
                                    <div class="p-4 bg-gray-100 rounded-md shadow">
                                        <h2 class="text-lg font-semibold">Price Calculator</h2>
                                        <p class="text-gray-600">Formula: (Width x Height) × Base Price</p>
                                        <p class="text-xl font-bold text-indigo-600" x-text="'₱' + totalPrice.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })"></p>
                                        <input type="hidden" name="total_price" x-model="totalPrice">
                                    </div>
                                
                                    <!-- Submit Button -->
                                    <button type="submit"
                                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-md">
                                        Submit Request
                                    </button>
                                </form>
                                <!-- Alpine.js for Live Calculation -->
                                <script>
                                function orderForm() {
                                    return {
                                        width: 0,
                                        height: 0,
                                        unit: 'cm',
                                        base_price: {{ $service->price_rate }},
                                        rush_price: {{ $service->rush_price_rate }},
                                        normal_timeframe: {{ $service->normal_timeframe }},
                                        rush_timeframe: {{ $service->rush_timeframe }},
                                        deadline: '',
                                        get totalPrice() {
                                            let widthInInches = this.unit === 'cm' ? this.width / 2.54 : this.width;
                                            let heightInInches = this.unit === 'cm' ? this.height / 2.54 : this.height;
                                            let area = widthInInches * heightInInches;
                                            let baseTotal = area * this.base_price;
                                            let rushTotal = area * this.rush_price;
                                            let selectedDate = new Date(this.deadline);
                                            let currentDate = new Date();
                                            let timeDiff = (selectedDate - currentDate) / (1000 * 60 * 60 * 24);
                                            if (timeDiff < this.rush_timeframe) {
                                                return 'Request cannot go through. Deadline is too soon.';
                                            } else if (timeDiff >= this.rush_timeframe && timeDiff < this.normal_timeframe) {
                                                return rushTotal;
                                            } else {
                                                return baseTotal;
                                            }
                                        }
                                    }
                                }
                                
                                </script>                                
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
