<section class="bg-white p-6 shadow-md rounded-lg space-y-6">
    <header>
        <h2 class="text-xl font-semibold text-gray-900">
            {{ __('Delete Account') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <!-- Delete Account Button -->
    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">
        {{ __('Delete Account') }}
    </x-danger-button>

    <!-- Confirmation Modal -->
    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            @csrf
            @method('delete')

            <!-- Modal Heading -->
            <h2 class="text-lg font-semibold text-gray-900 col-span-2">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <!-- Warning Message -->
            <p class="mt-1 text-sm text-gray-600 col-span-2">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <!-- Password Input -->
            <div class="col-span-2">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-full"
                    placeholder="{{ __('Enter your password') }}"
                    required />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2 text-red-600" />
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end gap-4 col-span-2">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button>
                    {{ __('Delete Account') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>