<x-guest-artist-layout>
    <form method="POST" action="{{ route('register.store') }}" enctype="multipart/form-data"
        class="flex flex-col md:flex-row my-6 gap-4 justify-center items-start">
        @csrf

        <!-- Left Section: Logo and Progress Steps -->
        <div class="flex flex-col w-full md:w-[500px] pl-4 md:pl-[60px]">
            <!-- Logo and Heading -->
            <div class="flex w-full">
                <img class="w-8 mb-4 mr-4" src="{{ asset('images/torch-high-resolution-logo-transparent.png') }}"
                    alt="Torch Logo">
                <div>
                    <h1 class="text-xl md:text-2xl font-bold">Join the artist club</h1>
                    <p class="text-gray-600 text-sm md:text-base">Set up your account.</p>
                </div>
            </div>

            <!-- Progress Steps -->
            <div class="w-full my-6">
                <!-- Mobile: Progress Bar -->
                <div class="md:hidden">
                    <div class="flex justify-between items-center">
                        <!-- Progress Bar -->
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div id="progress-bar" class="bg-orange-500 h-2.5 rounded-full" style="width: 25%;"></div>
                        </div>
                    </div>

                    <!-- Step Labels -->
                    <div class="flex justify-between mt-2">
                        <span class="text-sm text-gray-600">Personal</span>
                        <span class="text-sm text-gray-600">Credentials</span>
                        <span class="text-sm text-gray-600">Tags</span>
                        <span class="text-sm text-gray-600">Payment</span>
                    </div>
                </div>

                <!-- Desktop: Vertical Progress Steps -->
                <div class="hidden md:flex md:flex-col md:items-start md:justify-start">
                    <!-- Step 1: Personal -->
                    <div class="flex items-center">
                        <div class="flex flex-col items-center">
                            <span id="step-1"
                                class="py-3 px-6 rounded-full bg-orange-500 text-2xl text-white">1</span>
                            <div id="personal-line" class="h-8 w-0.5 bg-gray-500"></div>
                        </div>
                        <p class="ml-4 text-md">Personal</p>
                    </div>

                    <!-- Step 2: Credentials -->
                    <div class="flex items-center">
                        <div class="flex flex-col items-center">
                            <span id="step-2"
                                class="py-3.5 px-6 rounded-full bg-gray-500 text-2xl text-white">2</span>
                            <div id="credential-line" class="h-8 w-0.5 bg-gray-500"></div>
                        </div>
                        <p class="ml-4 text-md">Credentials</p>
                    </div>

                    <!-- Step 3: Tags -->
                    <div class="flex items-center">
                        <div class="flex flex-col items-center">
                            <span id="step-3"
                                class="py-3.5 px-6 rounded-full bg-gray-500 text-2xl text-white">3</span>
                            <div id="tags-line" class="h-8 w-0.5 bg-gray-500"></div>
                        </div>
                        <p class="ml-4 text-md">Tags</p>
                    </div>

                    <!-- Step 4: Payment -->
                    <div class="flex items-center">
                        <div class="flex flex-col items-center">
                            <span id="step-4"
                                class="py-3.5 px-6 rounded-full bg-gray-500 text-2xl text-white">4</span>
                        </div>
                        <p class="ml-4 text-md">Payment</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Section: Form Content -->
        <div class="w-full mx-6">
            {{-- @if ($errors->any())
                <div class="text-red-600">
                    <strong>{{ __('Please fix the following errors:') }}</strong>
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif --}}

        <!-- Personal Section -->
        <div id="personal-section" class="w-full">
            <!-- Name -->
            @guest
            <div class="flex flex-col md:flex-row justify-between gap-4">
                <div class="w-full md:w-1/3">
                    <x-input-label for="first_name" :value="__('First Name')" />
                    <x-text-input id="first_name" class="block mt-1 w-full" type="text" name="first_name"
                        placeholder="John" :value="old('first_name')" required autofocus autocomplete="first_name" />
                    <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                </div>
                <div class="w-full md:w-1/3">
                    <x-input-label for="middle_name" :value="__('Middle Name')" />
                    <x-text-input id="middle_name" class="block mt-1 w-full" type="text" name="middle_name"
                        placeholder="" :value="old('middle_name')" autofocus autocomplete="middle_name" />
                    <x-input-error :messages="$errors->get('middle_name')" class="mt-2" />
                </div>
                <div class="w-full md:w-1/3">
                    <x-input-label for="last_name" :value="__('Last Name')" />
                    <x-text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name"
                        placeholder="Doe" :value="old('last_name')" required autofocus autocomplete="last_name" />
                    <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                </div>
            </div>
            @else
            <input type="hidden" name="first_name" value="{{ old('first_name', $user->name ?? '') }}">
            <input type="hidden" name="middle_name" value="{{ old('middle_name', $user->middle_name ?? '') }}">
            <input type="hidden" name="last_name" value="{{ old('last_name', $user->name ?? '') }}">
            @endguest

            <!-- Birthdate and Gender -->
            <div class="flex flex-col md:flex-row mt-4 gap-4">
                <!-- Birthdate -->
                <div class="w-full md:w-1/2 relative">
                    <x-input-label for="birthdate" :value="__('Birthdate')" />
                    <div class="absolute inset-y-0 top-6 start-0 flex items-center ps-3.5">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                        </svg>
                    </div>
                    <input id="datepicker-format" datepicker datepicker-max-date="{{ now()->format('m/d/Y') }}"
                        name="birthdate" type="text"
                        class="mt-1 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Select date" value="{{ old('birthdate') }}">
                    <x-input-error :messages="$errors->get('birthdate')" class="mt-2" />
                </div>

                <!-- Gender -->
                <div class="w-full md:w-1/2">
                    <x-input-label for="gender" :value="__('Gender')" />
                    <select id="gender" name="gender"
                        class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <option value="">{{ __('Select Gender') }}</option>
                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>
                            {{ __('Male') }}
                        </option>
                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>
                            {{ __('Female') }}
                        </option>
                        <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>
                            {{ __('Other') }}
                        </option>
                    </select>
                    <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                </div>
            </div>

            <!-- Email -->
            @guest
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                    placeholder="john@example.com" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
            @else
            <input type="hidden" name="email" value="{{ old('email', $user->email ?? '') }}">
            @endguest

            <!-- Contact Number and Username -->
            <div class="flex flex-col md:flex-row gap-4">
                @guest
                <div class="mt-4 w-full">
                    <x-input-label for="contact_number" :value="__('Contact Number')" />
                    <div class="flex">
                        <span
                            class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">+63</span>
                        <x-text-input id="contact_number" class="block mt-1 w-full rounded-l-none" type="text"
                            name="contact_number" placeholder="9123456789" :value="old('contact_number')" required
                            autocomplete="phone_number" maxlength="10" />
                    </div>
                    <x-input-error :messages="$errors->get('contact_number')" class="mt-2" />
                </div>
                @else
                <input type="hidden" name="contact_number"
                    value="{{ old('contact_number', $user->phone_number ?? '') }}">
                @endguest

                <div class="mt-4 w-full">
                    <x-input-label for="username" :value="__('Username')" />
                    <x-text-input id="username" class="block mt-1 w-full" type="text" name="username"
                        placeholder="Stel" :value="old('username')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('username')" class="mt-2" />
                </div>
            </div>

            <!-- Location and Bio -->
            <div class="mt-4">
                <x-input-label for="location" :value="__('Location')" />
                <x-text-input id="location" class="block mt-1 w-full" type="text" name="location"
                    placeholder="Canelar" :value="old('location')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('location')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="bio" :value="__('Bio')" />
                <textarea id="bio"
                    class="block mt-1 w-full border-gray-300 focus:border-orange-500 focus:ring-orange-500 rounded-md shadow-sm"
                    name="bio" placeholder="Tell us about yourself" required>{{ old('bio') }}</textarea>
                <x-input-error :messages="$errors->get('bio')" class="mt-2" />
            </div>

            <!-- Continue Button -->
            <div class="flex flex-col items-center justify-end mt-6">
                <x-primary-button id="continue-to-credentials" class="justify-center py-4 w-full text-md"
                    onclick="showCredentialSection(event)">
                    {{ __('Continue') }}
                </x-primary-button>
                <a class="underline mt-2 text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500"
                    href="{{ route('login') }}">
                    {{ __('Already registered? Sign in') }}
                </a>
            </div>
        </div>

        <!-- Credential Section -->
        <div id="credential-section" class="hidden">
            <!-- Back Button -->
            <button onclick="showPersonalSection(event)" id="back-to-personal" class="focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="m11.25 9-3 3m0 0 3 3m-3-3h7.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </button>

            <!-- Password and Confirm Password -->
            @guest
            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />

                <div class="relative">
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password"
                        placeholder="password" :value="old('password')" required autocomplete="new-password" />
                    <button type="button"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5"
                        onclick="togglePasswordVisibility('password')">
                        <svg id="password-eye" class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-width="2"
                                d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z" />
                            <path stroke="currentColor" stroke-width="2"
                                d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                    </button>
                </div>

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                <div class="relative">
                    <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                        placeholder="password" name="password_confirmation" :value="old('password_confirmation')" required
                        autocomplete="new-password" />
                    <button type="button"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5"
                        onclick="togglePasswordVisibility('password_confirmation')">
                        <svg id="password_confirmation-eye" class="w-6 h-6 text-gray-800 dark:text-white"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-width="2"
                                d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z" />
                            <path stroke="currentColor" stroke-width="2"
                                d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                    </button>
                </div>

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <script>
                function togglePasswordVisibility(id) {
                    const input = document.getElementById(id);
                    const eyeIcon = document.getElementById(id + '-eye');
                    if (input.type === 'password') {
                        input.type = 'text';
                        eyeIcon.innerHTML = `<svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.933 13.909A4.357 4.357 0 0 1 3 12c0-1 4-6 9-6m7.6 3.8A5.068 5.068 0 0 1 21 12c0 1-3 6-9 6-.314 0-.62-.014-.918-.04M5 19 19 5m-4 7a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                        </svg>
                        `;
                    } else {
                        input.type = 'password';
                        eyeIcon.innerHTML = `<svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-width="2" d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z"/>
                            <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                        </svg>`;
                    }
                }
            </script>
            @else
            <input type="hidden" name="password" value="{{ old('password', $user->password ?? '') }}">
            <input type="hidden" name="password_confirmation"
                value="{{ old('password_confirmation', $user->password ?? '') }}">
            @endguest

            <!-- Max Commissions -->
            <div class="mt-4">
                <label for="max-commissions"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Max Commissions:</label>
                <div class="relative flex items-center max-w-[11rem]">
                    <button type="button" id="decrement-commissions"
                        data-input-counter-decrement="max-commissions"
                        class="bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 border border-gray-300 rounded-s-lg p-3 h-11 focus:ring-gray-100 dark:focus:ring-gray-700 focus:ring-2 focus:outline-none">
                        <svg class="w-3 h-3 text-gray-900 dark:text-white" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 2">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="M1 1h16" />
                        </svg>
                    </button>
                    <input type="text" id="max-commissions" name="max_commissions" data-input-counter
                        data-input-counter-min="1" data-input-counter-max="50"
                        aria-describedby="commissions-helper-text"
                        class="bg-gray-50 border-x-0 border-gray-300 h-11 font-medium text-center text-gray-900 text-sm focus:ring-blue-500 focus:border-blue-500 block w-full pb-6 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="" value="{{ old('max-commissions', 10) }}" required />
                    <div
                        class="absolute bottom-1 start-1/2 -translate-x-1/2 rtl:translate-x-1/2 flex items-center text-xs text-gray-400 space-x-1 rtl:space-x-reverse">
                        <svg class="w-2.5 h-2.5 text-gray-400" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2"
                                d="M3 8v10a1 1 0 0 0 1 1h4v-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v5h4a1 1 0 0 0 1-1V8M1 10l9-9 9 9" />
                        </svg>
                        <span>Commissions</span>
                    </div>
                    <button type="button" id="increment-commissions"
                        data-input-counter-increment="max-commissions"
                        class="bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 border border-gray-300 rounded-e-lg p-3 h-11 focus:ring-gray-100 dark:focus:ring-gray-700 focus:ring-2 focus:outline-none">
                        <svg class="w-3 h-3 text-gray-900 dark:text-white" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="M9 1v16M1 9h16" />
                        </svg>
                    </button>
                </div>
                <p id="commissions-helper-text" class="mt-2 text-sm text-gray-500 dark:text-gray-400">Please
                    select the max number of commissions.</p>
            </div>

            <!-- Portfolio -->
            <div class="mt-4 border border-gray-300 p-4 rounded-md">
                <x-input-label for="portfolio" :value="__('Portfolio')" />
                <x-text-input id="portfolio" class="block mt-1 w-full" type="file" name="portfolio"
                    accept=".pdf,.docx,.doc" :value="old('portfolio')" required />
                <x-input-error :messages="$errors->get('portfolio')" class="mt-2" />
            </div>

            <!-- Portfolio Link -->
            <div class="mt-4">
                <x-input-label for="portfolio_link" :value="__('Portfolio Link (Optional)')" />
                <x-text-input id="portfolio_link" class="block mt-1 w-full" type="url" name="portfolio_link"
                    :value="old('portfolio_link')" />
                <x-input-error :messages="$errors->get('portfolio_link')" class="mt-2" />
            </div>

            <!-- Continue Button -->
            <div class="flex items-center justify-end mt-6">
                <x-primary-button id="continue-to-tags" class="justify-center py-4 w-full text-md"
                    onclick="showTagSection(event)">
                    {{ __('Continue') }}
                </x-primary-button>
            </div>
        </div>

        <!-- Tags Section -->
        <div id="tags-section" class="hidden">
            <!-- Back Button -->
            <button onclick="showCredentialSection(event)" id="back-to-credentials" class="focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="m11.25 9-3 3m0 0 3 3m-3-3h7.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </button>

            <div class="w-full">
                <label for="tags" class="block mb-2 text-lg font-medium">Select your tag</label>
                <div id="tags-container" class="flex justify-start flex-wrap gap-2">
                    @foreach ($tags as $tag)
                    <div class="tag-card border-2 border-gray-300 text-sm rounded-full py-2 px-4 cursor-pointer"
                        data-tag-id="{{ $tag->id }}">
                        {{ $tag->name }}
                    </div>
                    @endforeach
                </div>
                <input type="hidden" id="selected-tags" name="tags[]" value="">
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const tagsContainer = document.getElementById('tags-container');
                    const selectedTagsInput = document.getElementById('selected-tags');
                    let selectedTags = [];

                    tagsContainer.addEventListener('click', function(event) {
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

            <style>
                .tag-card.selected-tag {
                    background-color: #d66f15;
                    color: white;
                    border-color: #d66f15;
                }
            </style>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const tagsContainer = document.getElementById('tags-container');
                    const selectedTagsInput = document.getElementById('selected-tags');
                    let selectedTags = [];

                    tagsContainer.addEventListener('click', function(event) {
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

            <!-- Continue Button -->
            <div class="flex items-center justify-end mt-6">
                <x-primary-button id="continue-to-payment" class="justify-center py-4 w-full text-md"
                    onclick="showPaymentSection(event)">
                    {{ __('Continue') }}
                </x-primary-button>
            </div>
        </div>

        <!-- Payment Section -->
        <div id="payment-section" class="hidden">
            <!-- Back Button -->
            <button onclick="showTagSection(event)" id="back-to-tags" class="focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="m11.25 9-3 3m0 0 3 3m-3-3h7.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </button>

            <!-- Payment Method -->
            <div class="mt-4">
                <x-input-label for="payment_method" :value="__('Payment Method')" />
                <div id="payment-method-container" class="flex gap-4 mt-2">
                    <div class="payment-method-card border-2 border-gray-300 text-sm rounded-md py-2 px-4 cursor-pointer"
                        data-method="GCash" onclick="selectPaymentMethod('GCash')">
                        {{ __('GCash') }}
                    </div>
                    <div class="payment-method-card border-2 border-gray-300 text-sm rounded-md py-2 px-4 cursor-pointer"
                        data-method="PayMaya" onclick="selectPaymentMethod('PayMaya')">
                        {{ __('PayMaya') }}
                    </div>
                </div>
                <input type="hidden" id="payment_method" name="payment_method"
                    value="{{ old('payment_method', 'GCash') }}">
                <x-input-error :messages="$errors->get('payment_method')" class="mt-2" />
            </div>

            <script>
                function selectPaymentMethod(method) {
                    const paymentMethodInput = document.getElementById('payment_method');
                    paymentMethodInput.value = method;

                    document.querySelectorAll('.payment-method-card').forEach(card => {
                        card.classList.toggle('bg-orange-500', card.dataset.method === method);
                        card.classList.toggle('border-orange-500', card.dataset.method === method);
                        card.classList.toggle('text-white', card.dataset.method === method);
                        card.classList.toggle('bg-white', card.dataset.method !== method);
                        card.classList.toggle('border-gray-300', card.dataset.method !== method);
                    });
                }
            </script>

            <!-- Payment Name and Number -->
            <div class="mt-4">
                <x-input-label for="payment_name" :value="__('Name')" />
                <x-text-input id="payment_name" class="block mt-1 w-full" type="text" name="payment_name"
                    placeholder="John Doe" :value="old('payment_name')" required />
                <x-input-error :messages="$errors->get('payment_name')" class="mt-2" />
            </div>

            <div class="mt-4 w-full">
                <x-input-label for="payment_number" :value="__('Number')" />
                <div class="flex">
                    <span
                        class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">+63</span>
                    <x-text-input id="payment_number" class="block mt-1 w-full rounded-l-none" type="text"
                        name="payment_number" placeholder="9123456789" :value="old('payment_number')" required
                        maxlength="10" />
                </div>
                <x-input-error :messages="$errors->get('payment_number')" class="mt-2" />
            </div>

            <!-- Terms and Privacy Policy -->
            <div class="block mt-4">
                <label for="policy" class="inline-flex items-center">
                    <input id="policy" type="checkbox"
                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                        name="policy" required>
                    <span class="ms-2 text-sm text-gray-600">I agree to the <a href="{{ route('privacy') }}"
                            class="text-blue-400 underline">Terms and Privacy Policy</a></span>
                </label>
            </div>

            <!-- Submit Button -->
            <x-primary-button id="submit-btn" type="submit"
                class="justify-center py-4 w-full text-md text-white rounded-lg font-medium flex items-center">
                <svg id="submit-spinner" aria-hidden="true"
                    class="hidden w-5 h-5 me-3 text-gray-200 animate-spin fill-yellow-400" viewBox="0 0 100 101"
                    fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                        fill="currentColor" />
                    <path
                        d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                        fill="currentFill" />
                </svg>
                <span id="submit-text">{{ __('Submit Application') }}</span>
            </x-primary-button>
        </div>
        </div>
    </form>

    <script>
        let currentStep = 0; // Tracks the current step (0 = Personal, 1 = Credentials, etc.)
        const totalSteps = 4; // Total number of steps

        // Function to show a specific section and update progress
        function showSection(sectionId) {
            // Hide all sections
            document.getElementById('personal-section').classList.add('hidden');
            document.getElementById('credential-section').classList.add('hidden');
            document.getElementById('tags-section').classList.add('hidden');
            document.getElementById('payment-section').classList.add('hidden');

            // Show the selected section
            document.getElementById(sectionId).classList.remove('hidden');

            // Update current step based on the section
            switch (sectionId) {
                case 'personal-section':
                    currentStep = 0;
                    break;
                case 'credential-section':
                    currentStep = 1;
                    break;
                case 'tags-section':
                    currentStep = 2;
                    break;
                case 'payment-section':
                    currentStep = 3;
                    break;
            }

            // Update progress bar and steps
            updateProgress();
        }

        // Function to update progress bar and steps
        function updateProgress() {
            // Update progress bar width
            const progressBar = document.getElementById('progress-bar');
            const progressWidth = ((currentStep + 1) / totalSteps) * 100;
            progressBar.style.width = `${progressWidth}%`;

            // Update step circles
            const stepCircles = [
                document.getElementById('step-1'),
                document.getElementById('step-2'),
                document.getElementById('step-3'),
                document.getElementById('step-4')
            ];
            stepCircles.forEach((circle, index) => {
                if (index <= currentStep) {
                    circle.classList.remove('bg-gray-500');
                    circle.classList.add('bg-orange-500');
                } else {
                    circle.classList.remove('bg-orange-500');
                    circle.classList.add('bg-gray-500');
                }
            });

            // Update progress lines
            const progressLines = [
                document.getElementById('personal-line'),
                document.getElementById('credential-line'),
                document.getElementById('tags-line')
            ];
            progressLines.forEach((line, index) => {
                if (index < currentStep) {
                    line.classList.remove('bg-gray-500');
                    line.classList.add('bg-orange-500');
                } else {
                    line.classList.remove('bg-orange-500');
                    line.classList.add('bg-gray-500');
                }
            });
        }

        // Event listeners for navigation buttons
        document.getElementById('continue-to-credentials').addEventListener('click', (event) => {
            event.preventDefault();
            showSection('credential-section');
        });

        document.getElementById('continue-to-tags').addEventListener('click', (event) => {
            event.preventDefault();
            showSection('tags-section');
        });

        document.getElementById('continue-to-payment').addEventListener('click', (event) => {
            event.preventDefault();
            showSection('payment-section');
        });

        document.getElementById('back-to-personal').addEventListener('click', (event) => {
            event.preventDefault();
            showSection('personal-section');
        });

        document.getElementById('back-to-credentials').addEventListener('click', (event) => {
            event.preventDefault();
            showSection('credential-section');
        });

        document.getElementById('back-to-tags').addEventListener('click', (event) => {
            event.preventDefault();
            showSection('tags-section');
        });

        // Initialize progress
        updateProgress();

        document.querySelector('form').addEventListener('submit', function(event) {
            let registerButton = document.getElementById('submit-btn');
            let registerText = document.getElementById('submit-text');
            let spinner = document.getElementById('submit-spinner');

            // Disable the button to prevent multiple clicks
            registerButton.disabled = true;
            registerButton.classList.add('cursor-not-allowed', 'opacity-75');

            // Update text and show spinner
            registerText.textContent = "submit...";
            spinner.classList.remove('hidden');

            // Allow form submission
            this.submit();
        });
    </script>
</x-guest-artist-layout>