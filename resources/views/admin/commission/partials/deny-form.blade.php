<section class="space-y-6">
    <x-Danger-button x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deny')">{{ __('Deny ') }}</x-Danger-button>

    <x-modal name="confirm-user-deny" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="" class="p-6 bg-white rounded-lg shadow-md">
            @csrf
            @method('delete')
            <p class="mt-1 text-sm text-gray-600">
            {{ __('You are about to deny this user\'s request. Include a reason why.') }}
            </p>
            <div class="mt-6">
                <x-input-label for="reason" value="{{ __('Reason') }}" class="sr-only" />
                <textarea id="reason" name="reason"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    placeholder="{{ __('Reason') }}"></textarea>
                <x-input-error :messages="$errors->userDeletion->get('reason')" class="mt-2 text-red-600" />
            </div>
            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')" class="bg-gray-200 hover:bg-gray-300 text-gray-700">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-primary-button class="ms-3 text-white">
                    {{ __('Confirm') }}
                </x-primary-button>
            </div>
        </form>
    </x-modal>
</section>
