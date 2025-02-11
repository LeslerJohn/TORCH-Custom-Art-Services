<x-guest-artist-layout>
    <form method="POST" action="{{ route('register.store') }}" enctype="multipart/form-data" class="flex my-6 gap-4 justify-center items-start">
        @csrf

        <div class="flex flex-col w-[500px] pl-[60px]">
            <div class="flex w-full">
                <img class="w-8 mb-4 mr-4" src="{{ asset('images/torch-high-resolution-logo-transparent.png') }}"
                    alt="Torch Logo">
                <div>
                    <h1 class="text-2xl font-bold">Join the artist club</h1>
                    <p class="text-gray-600">Set up your account.</p>
                </div>
            </div>

            <div class="flex flex-col w-full items-start justify-start my-6">
                <div class="flex">
                    <div class="flex flex-col items-center">
                        <span class="py-3 px-6 rounded-full bg-orange-500 text-2xl text-white">1</span>
                        <div id="personal-line" class="h-8 w-0.5 bg-gray-500"></div>
                    </div>
                    <p class="mt-4 ml-2 text-md">Personal</p>
                </div>
                <div class="flex">
                    <div class="flex flex-col items-center">
                        <span id="credential-circle" class="py-3.5 px-6 rounded-full bg-gray-500 text-2xl text-white">2</span>
                        <div id="credential-line" class="h-8 w-0.5 bg-gray-500"></div>
                    </div>
                    <p class="mt-4 ml-2 text-md">Credentials</p>
                </div>
                <div class="flex">
                    <div class="flex flex-col items-center">
                        <span id="tags-circle" class="py-3.5 px-6 rounded-full bg-gray-500 text-2xl text-white">3</span>
                        <div id="tags-line" class="h-8 w-0.5 bg-gray-500"></div>
                    </div>
                    <p class="mt-4 ml-2 text-md">Tags</p>
                </div>
                <div class="flex">
                    <div class="flex flex-col items-center">
                        <span id="payment-circle" class="py-3.5 px-6 rounded-full bg-gray-500 text-2xl text-white">4</span>
                    </div>
                    <p class="mt-4 ml-2 text-md">Payment</p>
                </div>
            </div>
        </div>

        <div class="w-full mx-6">
            @if ($errors->any())
                <div class="text-red-600">
                    <strong>{{ __('Please fix the following errors:') }}</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div id="personal-section">
                <!-- Name -->
                <div class="flex justify-between">
                    <div>
                        <x-input-label for="first_name" :value="__('First Name')" />
                        <x-text-input id="first_name" class="block mt-1 w-full" type="text" name="first_name"
                            placeholder="John" :value="old('first_name')" required autofocus autocomplete="first_name" />
                        <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="middle_name" :value="__('Middle Name')" />
                        <x-text-input id="middle_name" class="block mt-1 w-full" type="text" name="middle_name"
                            placeholder="" :value="old('middle_name')" autofocus autocomplete="middle_name" />
                        <x-input-error :messages="$errors->get('middle_name')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="last_name" :value="__('Last Name')" />
                        <x-text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name"
                            placeholder="Doe" :value="old('last_name')" required autofocus autocomplete="last_name" />
                        <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                    </div>
                </div>


                <div class="flex mt-4">
                    <!-- Birthdate -->
                    {{-- <div class="w-1/2 pr-2">
                        <x-input-label for="birthdate" :value="__('Birthdate')" />
                        <x-text-input id="birthdate" class="block mt-1 w-full" type="date" name="birthdate"
                            :value="old('birthdate')" required />
                        <x-input-error :messages="$errors->get('birthdate')" class="mt-2" />
                    </div> --}}
                    <div class="w-1/2 pr-2">
                        <x-input-label for="birthdate" :value="__('Birthdate')" />
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                            </svg>
                        </div>
                        <input datepicker id="default-datepicker" name="birthdate" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date">
                    </div>
    
                    <!-- Gender -->
                    <div class="w-1/2 pl-2">
                        <x-input-label for="gender" :value="__('Gender')" />
                        <select id="gender" name="gender"
                            class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="">{{ __('Select Gender') }}</option>
                            <option value="male">{{ __('Male') }}</option>
                            <option value="female">{{ __('Female') }}</option>
                            <option value="other">{{ __('Other') }}</option>
                        </select>
                        <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                    </div>
                </div>

                <!-- Email Address -->
                <div class="mt-4">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                        placeholder="john@example.com" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="flex gap-6">
                    <div class="mt-4 w-full">
                        <x-input-label for="contact_number" :value="__('Contact Number')" />
                        <div class="flex">
                            <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">+63</span>
                            <x-text-input id="contact_number" class="block mt-1 w-full rounded-l-none" type="text" name="contact_number"
                                placeholder="9123456789" :value="old('contact_number')" required autocomplete="username" />
                        </div>
                        <x-input-error :messages="$errors->get('contact_number')" class="mt-2" />
                    </div>

                    <div class="mt-4 w-full">
                        <x-input-label for="username" :value="__('Username')" />
                        <x-text-input id="username" class="block mt-1 w-full" type="text" name="username"
                            placeholder="Stel" :value="old('username')" required autocomplete="username" />
                        <x-input-error :messages="$errors->get('username')" class="mt-2" />
                    </div>
                </div>

                <div class="mt-4">
                    <x-input-label for="location" :value="__('Location')" />
                    <x-text-input id="location" class="block mt-1 w-full" type="text" name="location"
                        placeholder="Canelar" :value="old('location')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('location')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="bio" :value="__('Bio')" />
                    <textarea id="bio" class="block mt-1 w-full border-gray-300 focus:border-orange-500 focus:ring-orange-500 rounded-md shadow-sm" name="bio" placeholder="Tell us about yourself" required>{{ old('bio') }}</textarea>
                    <x-input-error :messages="$errors->get('bio')" class="mt-2" />
                </div>

                <div class="flex flex-col items-center justify-end mt-6">
                    <x-primary-button class="justify-center py-4 w-full text-md" onclick="showCredentialSection(event)">
                        {{ __('Continue') }}
                    </x-primary-button>
                    <a class="underline mt-2 text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500" href="{{ route('login') }}">
                        {{ __('Already registered? Sign in') }}
                    </a>
                </div>
            </div>

            <div id="credential-section" class="hidden">
                <button onclick="showPersonalSection(event)" class="focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 9-3 3m0 0 3 3m-3-3h7.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </button>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" />

                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password"
                        placeholder="password" required autocomplete="new-password" />

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                    <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                        placeholder="password" name="password_confirmation" required autocomplete="new-password" />

                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="mt-4 border border-gray-300 p-4 rounded-md">
                    <x-input-label for="portfolio" :value="__('Portfolio')" />
                    <x-text-input id="portfolio" class="block mt-1 w-full" type="file" name="portfolio" required />
                    <x-input-error :messages="$errors->get('portfolio')" class="mt-2" />
                </div>
    
                <div class="mt-4">
                    <x-input-label for="portfolio_link" :value="__('Portfolio Link (Optional)')" />
                    <x-text-input id="portfolio_link" class="block mt-1 w-full" type="url" name="portfolio_link"
                        :value="old('portfolio_link')" />
                    <x-input-error :messages="$errors->get('portfolio_link')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-6">
                    {{-- <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a> --}}
    
                    <x-primary-button class="justify-center py-4 w-full text-md" onclick="showTagSection(event)">
                        {{ __('Continue') }}
                    </x-primary-button>
                </div>
            </div>

            <div id="tags-section" class="hidden">
                <!-- Name -->
                <button onclick="showCredentialSection(event)" class="focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 9-3 3m0 0 3 3m-3-3h7.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </button>
                
                
            <div class="w-full">
                <label for="tags" class="block mb-2 text-lg font-medium">Select your tag</label>
                <div id="tags-container" class="grid grid-cols-2 gap-4">
                    @foreach ($tags as $tag)
                        <div class="tag-card border-2 border-gray-300 text-lg rounded-lg p-4 cursor-pointer" data-tag-id="{{ $tag->id }}">
                            {{ $tag->name }}
                        </div>
                    @endforeach
                </div>
                <input type="hidden" id="selected-tags" name="tags[]" value="">
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const tagsContainer = document.getElementById('tags-container');
                    const selectedTagsInput = document.getElementById('selected-tags');
                    let selectedTags = [];

                    tagsContainer.addEventListener('click', function (event) {
                        const tagCard = event.target.closest('.tag-card');
                        if (tagCard) {
                            const tagId = tagCard.getAttribute('data-tag-id');
                            if (selectedTags.includes(tagId)) {
                                selectedTags = selectedTags.filter(id => id !== tagId);
                                tagCard.classList.remove('selected-tag');
                            } else {
                                selectedTags.push(tagId);
                                tagCard.classList.add('selected-tag');
                            }
                            selectedTagsInput.value = selectedTags.join(',');
                        }
                    });
                });
            </script>
            

                <div class="flex items-center justify-end mt-6">
                    {{-- <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a> --}}
    
                    <x-primary-button class="justify-center py-4 w-full text-md" onclick="showPaymentSection(event)">
                        {{ __('Continue') }}
                    </x-primary-button>
                </div>
            </div>

            <div id="payment-section" class="hidden">
                <button onclick="showTagSection(event)" class="focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 9-3 3m0 0 3 3m-3-3h7.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </button>

                <p>Payment</p>
                
            <div class="block mt-4">
                <label for="policy" class="inline-flex items-center">
                    <input id="policy" type="checkbox"
                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                        name="policy">
                    <span class="ms-2 text-sm text-gray-600">{{ __('I agree to the Terms and Privacy Policy') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-6">
                <x-primary-button class="justify-center py-4 w-full text-md">
                    {{ __('Submit Application') }}
                </x-primary-button>
            </div>
            </div>
        </div>
    </form>

    <script>
        function showPersonalSection(event) {
            event.preventDefault();
            document.getElementById('credential-section').classList.add('hidden');
            document.getElementById('tags-section').classList.add('hidden');
            document.getElementById('payment-section').classList.add('hidden');
            document.getElementById('personal-section').classList.remove('hidden');
            document.getElementById('personal-line').classList.remove('bg-orange-500');
            document.getElementById('credential-circle').classList.remove('bg-orange-500');
        }

        function showCredentialSection(event) {
            event.preventDefault();
            document.getElementById('personal-section').classList.add('hidden');
            document.getElementById('tags-section').classList.add('hidden');
            document.getElementById('payment-section').classList.add('hidden');
            document.getElementById('credential-section').classList.remove('hidden');
            document.getElementById('personal-line').classList.add('bg-orange-500');
            document.getElementById('credential-circle').classList.add('bg-orange-500');
            document.getElementById('tags-circle').classList.remove('bg-orange-500');
            document.getElementById('payment-circle').classList.remove('bg-orange-500');
            document.getElementById('credential-line').classList.remove('bg-orange-500');
        }

        function showTagSection(event) {
            event.preventDefault();
            document.getElementById('personal-section').classList.add('hidden');
            document.getElementById('credential-section').classList.add('hidden');
            document.getElementById('payment-section').classList.add('hidden');
            document.getElementById('tags-section').classList.remove('hidden');
            document.getElementById('credential-line').classList.add('bg-orange-500');
            document.getElementById('tags-circle').classList.add('bg-orange-500');
            document.getElementById('tags-line').classList.remove('bg-orange-500');
            document.getElementById('payment-circle').classList.remove('bg-orange-500');
        }

        function showPaymentSection(event) {
            event.preventDefault();
            document.getElementById('personal-section').classList.add('hidden');
            document.getElementById('credential-section').classList.add('hidden');
            document.getElementById('tags-section').classList.add('hidden');
            document.getElementById('payment-section').classList.remove('hidden');
            document.getElementById('tags-line').classList.add('bg-orange-500');
            document.getElementById('payment-circle').classList.add('bg-orange-500');
        }
    </script>

    <style>
        .selected-tag {
            border-color: #3b82f6 !important;
        }
    </style>
</x-guest-artist-layout>
