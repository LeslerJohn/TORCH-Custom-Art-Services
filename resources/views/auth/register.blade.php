<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="">
        @csrf

        <div class="flex flex-col items-center justify-center my-6">
            <img class="w-8 mb-4" src="{{ asset('images/torch-high-resolution-logo-transparent.png')}}" alt="Torch Logo">
            <h1 class="text-2xl font-bold">Create account</h1>
            <p class="text-gray-600">Sign up to get you started.</p>
        </div>

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" placeholder="John Doe" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" placeholder="john@example.com" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            placeholder="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            placeholder="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Policy -->
        <div class="block mt-4">
            <label for="policy" class="inline-flex items-center">
                <input id="policy" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="policy">
                <span class="ms-2 text-sm text-gray-600">{{ __('I agree to the Terms and Privacy Policy') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-6">
            {{-- <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a> --}}

            <x-primary-button class="justify-center py-4 w-full text-md">
                {{ __('Register') }}
            </x-primary-button>
        </div>

        <div class="flex items-center justify-center mt-6">
            <span class="flex-grow bg-gray-400 rounded h-0.5"></span>
            <p class="mx-4">Or</p>
            <span class="flex-grow bg-gray-400 rounded h-0.5"></span>
        </div>

        <div class="flex flex-col items-center justify-center mt-6">
            <a href="{{route('register.artist')}}" class="w-full">
                <x-secondary-button class="w-full py-4 text-md justify-center">
                    {{ __('Sign up as an Artist') }}
                </x-secondary-button>
            </a>

            <div class="mt-2">
                Already have account?
                <a class="underline mt-2 text-sm text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-white-800 mt-1" href="{{ route('login') }}">
                    {{ __('Sign in') }}
                </a>
            </div>
        </div>
    </form>
</x-guest-layout>
