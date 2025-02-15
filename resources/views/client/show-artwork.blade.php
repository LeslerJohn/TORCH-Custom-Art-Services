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
                    @foreach ($artwork->images as $index => $image)
                        <div class="{{ $index === 0 ? '' : 'hidden' }} duration-700 ease-in-out" data-carousel-item>
                            <img src="{{ $image->attachment ? asset('storage/' . $image->attachment->path) : asset('images/default.image.jpg') }}"
                                class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
                                alt="...">
                        </div>
                    @endforeach
                </div>
                <!-- Slider indicators -->
                <div class="absolute z-30 flex -translate-x-1/2 bottom-5 left-1/2 space-x-3 rtl:space-x-reverse">
                    @foreach ($artwork->images as $index => $image)
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
                <div class="flex items-center justify-between">
                    <h1 class="text-3xl font-bold font-bold-300">{{ $artwork->title }}</h1>
                    <p class="text-2xl text-red-600">₱ <strong>{{ number_format($artwork->price, 0, '.', ',') }}</strong></p>
                </div>
                <p class="text-md text-black-500">{{ $artwork->artist->user->name ?? 'Unknown' }}</p>
                <p class="text-md text-black-500">{{ $artwork->created_at->diffForHumans() }}</p>

                <hr class="w-full my-4 h-2 border-gray-500">

                <div>
                    <h2 class="text-xl font-semibold">About</h2>
                    <p class="mt-2"><strong>{{ $artwork->category->name }}</strong> - {{ $artwork->medium }}</p>
                    <p class="mt-1"><strong>Size:</strong> {{ $artwork->dimension }} Centimeter</p>
                    <div class="flex flex-wrap gap-2 mt-2">
                        @foreach ($artwork->tags as $tag)
                            <span
                                class="bg-green-200 text-sm text-gray-700 px-4 py-1 rounded-full">{{ $tag->name }}</span>
                        @endforeach
                    </div>
                    <p class="mt-4">{{ $artwork->description }}</p>
                </div>

                <div>
                    <h2 class="text-xl font-semibold mt-4">Contact</h2>
                    <p class="mt-2"><strong>Email:</strong> {{ $artwork->artist->user->email ?? 'test@email.com' }}
                    </p>
                    <p class="mt-1"><strong>Phone:</strong> {{ $artwork->artist->phone_number }}</p>
                </div>

                <div class="mt-4 flex gap-4 justify-end">
                    <form action="{{ route('client.cart.store', $artwork) }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="flex items-center gap-2 justify-center bg-gray-200 border border-black text-gray-800 px-4 py-2 rounded hover:bg-gray-300">
                            Add to cart
                            <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4h1.5L8 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm.75-3H7.5M11 7H6.312M17 4v6m-3-3h6" />
                            </svg>
                        </button>
                    </form>
                    <button data-modal-target="authentication-modal" data-modal-toggle="authentication-modal"
                    class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                    type="button">
                    Buy Now
                </button>
                </div>

                <!-- Main modal -->
                <div id="authentication-modal" tabindex="-1" aria-hidden="true"
                    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-full">
                    <div class="relative p-4 w-full max-w-3xl max-h-full">
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
                            <div class="flex gap-2 justify-center p-4 md:p-5">
                                <div class="w-1/2">
                                    <p class="mb-3 text-xl text-red-600 font-bold"><strong>Total: </strong>₱{{number_format($artwork->price, 0, '.', ',')}}</p>
                                    <div class="flex gap-4 items-center">
                                        <img src="{{ $artwork->images->first()?->attachment ? asset('storage/' . $artwork->images->first()->attachment->path) : asset('images/default.image.jpg') }}"
                                        alt="{{ $artwork->title }}"
                                        class="w-16 h-16 object-cover rounded-lg">
                                        <div>
                                            <h1 class="text-lg font-bold">{{ $artwork->title }}</h1>
                                            <p class="text-sm text-gray-500">{{ $artwork->artist->user->name ?? 'Unknown' }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center mt-4 w-full border border-black rounded-md p-2">
                                        <p class="text-sm mr-4">Accepts</p>
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
                                    </div>
                                </div>
                                <form class="space-y-4 w-1/2" action="{{ route('client.order.store', $artwork) }}" method="POST">
                                    @csrf
                                    <h1 class="text-xl font-bold">Address</h1>
                                    <div>
                                        <x-input-label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="contact_number" :value="__('Contact Number')" />
                                        <div class="flex">
                                            <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">+63</span>
                                            <x-text-input id="contact_number" class="block w-full rounded-l-none" type="text" name="contact_number"
                                                placeholder="9123456789" :value="old('contact_number')" required autocomplete="username" />
                                        </div>
                                        <x-input-error :messages="$errors->get('contact_number')" class="mt-2" />
                                    </div>
                                    <div>
                                        <x-input-label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="barangay" :value="__('Barangay')" />
                                        <x-text-input id="barangay" class="block mt-1 w-full" type="text" name="barangay"
                                            placeholder="Canelar" :value="old('barangay')" required autocomplete="barangay" />
                                        <x-input-error :messages="$errors->get('barangay')" class="mt-2" />
                                    </div>
                                    <div>
                                        <x-input-label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="street" :value="__('Street/Drive')" />
                                        <x-text-input id="street" class="block mt-1 w-full" type="text" name="street"
                                            placeholder="Gregorio" :value="old('street')" required autocomplete="street" />
                                        <x-input-error :messages="$errors->get('street')" class="mt-2" />
                                    </div>
                                    <div>
                                        <x-input-label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="house_number" :value="__('House Number')" />
                                        <x-text-input id="house_number" class="block mt-1 w-full" type="text" name="house_number"
                                            placeholder="C-1276" :value="old('house_number')" required autocomplete="house_number" />
                                        <x-input-error :messages="$errors->get('house_number')" class="mt-2" />
                                    </div>
                                    <button type="submit"
                                        class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Place Order</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
