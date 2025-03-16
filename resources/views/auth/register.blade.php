<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="">
        @csrf

        <div class="flex flex-col items-center justify-center my-6">
            <img class="w-8 mb-4" src="{{ asset('images/torch-high-resolution-logo-transparent.png') }}" alt="Torch Logo">
            <h1 class="text-2xl font-bold">Create account</h1>
            <p class="text-gray-600">Sign up to get you started.</p>
        </div>

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" placeholder="John Doe"
                :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                placeholder="john@example.com" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <div class="relative">
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password"
                placeholder="password" required autocomplete="new-password" />
            <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5"
                onclick="togglePasswordVisibility('password')">
                <svg id="password-eye" class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-width="2"
                    d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z" />
                <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
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
                placeholder="password" name="password_confirmation" required autocomplete="new-password" />
            <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5"
                onclick="togglePasswordVisibility('password_confirmation')">
                <svg id="password_confirmation-eye" class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-width="2"
                    d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z" />
                <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
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

        <!-- Policy -->
        <div class="block mt-4">
            <label for="policy" class="inline-flex items-center">
                <input id="policy" type="checkbox" required
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="policy">
                <span class="ms-2 text-sm">I agree to the <a href="{{ route('privacy') }}"
                        class="text-blue-400 underline">Terms and Privacy Policy</a></span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-6">
            {{-- <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
            {{ __('Already registered?') }}
            </a> --}}

            <x-primary-button id="register-btn" type="submit"
                class="justify-center py-4 w-full text-md text-white rounded-lg font-medium flex items-center">
                <svg id="register-spinner" aria-hidden="true"
                    class="hidden w-5 h-5 me-3 text-gray-200 animate-spin fill-yellow-400" viewBox="0 0 100 101"
                    fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                        fill="currentColor" />
                    <path
                        d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                        fill="currentFill" />
                </svg>
                <span id="register-text">{{ __('Register') }}</span>
            </x-primary-button>
        </div>

        <div class="flex items-center justify-center mt-6">
            <span class="flex-grow bg-gray-400 rounded h-0.5"></span>
            <p class="mx-4">Or</p>
            <span class="flex-grow bg-gray-400 rounded h-0.5"></span>
        </div>

        <div class="flex flex-col items-center justify-center mt-6">
            <a href="{{ route('register.artist') }}" class="w-full">
                <x-secondary-button class="w-full py-4 text-md justify-center">
                    {{ __('Sign up as an Artist') }}
                </x-secondary-button>
            </a>

            <div class="mt-2">
                Already have account?
                <a class="underline mt-2 text-sm text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-white-800 mt-1"
                    href="{{ route('login') }}">
                    {{ __('Sign in') }}
                </a>
            </div>
        </div>
    </form>

    <script>
        document.querySelector('form').addEventListener('submit', function(event) {
            let registerButton = document.getElementById('register-btn');
            let registerText = document.getElementById('register-text');
            let spinner = document.getElementById('register-spinner');

            // Disable the button to prevent multiple clicks
            registerButton.disabled = true;
            registerButton.classList.add('cursor-not-allowed', 'opacity-75');

            // Update text and show spinner
            registerText.textContent = "Registering...";
            spinner.classList.remove('hidden');

            // Allow form submission
            this.submit();
        });

        // Re-enable button if Laravel returns errors
        window.addEventListener('DOMContentLoaded', (event) => {
            if (document.querySelector('.mt-2.text-red-600')) { // Laravel validation errors
                let registerButton = document.getElementById('register-btn');
                let registerText = document.getElementById('register-text');
                let spinner = document.getElementById('register-spinner');

                registerButton.disabled = false;
                registerButton.classList.remove('cursor-not-allowed', 'opacity-75');
                registerText.textContent = "Register";
                spinner.classList.add('hidden');
            }
        });
    </script>

</x-guest-layout>
