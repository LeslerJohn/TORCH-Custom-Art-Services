<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="flex flex-col items-center justify-center my-6">
            <img class="w-8 mb-4" src="{{ asset('images/torch-high-resolution-logo-transparent.png')}}" alt="Torch Logo">
            <h1 class="text-3xl font-bold font-sans">Welcome to Torch</h1>
            <p class="text-gray-600">Log in to start your session.</p>
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" placeholder="celo@example.com" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            placeholder="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-center mt-6">
            {{-- @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif --}}

            <x-primary-button class="w-full py-4 text-md justify-center">
                {{ __('Log in') }}
            </x-primary-button>
        </div>

        <div class="flex items-center justify-center mt-6">
            <span class="flex-grow bg-gray-300 rounded h-0.5"></span>
            <p class="mx-4">Or</p>
            <span class="flex-grow bg-gray-300 rounded h-0.5"></span>
        </div>

        <div class="flex flex-col items-center justify-center mt-6">
            <x-secondary-button class="w-full py-4 text-sm justify-center">
                <img src="{{ asset('images/google.png')}}" alt="Google Logo" class="w-6 h-6 me-2">
                {{ __('Continue with Google') }}
            </x-secondary-button>

            <div class="mt-2 mb-6 text-sm">
                Don't have account?
                <a class="underline mt-2 text-sm text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-white-800 mt-1" href="{{ route('register') }}">
                    {{ __('Sign Up') }}
                </a>
            </div>
        </div>
    </form>
</x-guest-layout>
