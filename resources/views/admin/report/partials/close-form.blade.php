<section class="space-y-6">
    <x-secondary-button x-data="" 
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-close')">{{ __('Close Report') }}</x-secondary-button>

    <x-modal name="confirm-user-close" :show="$errors->userWarning->isNotEmpty()" focusable>
        <form method="post" action="" class="p-6 bg-white rounded-lg shadow-md">
            @csrf
            @method('post')

            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Closed') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('Please provide details for closing this user warning.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="warning_date" value="{{ __('Warning Date') }}" class="sr-only" />

                <div class="flex justify-center">
                    <x-text-input id="warning_date" name="warning_date" type="date" class="mt-1 block w-fit items-center border-gray-300 rounded-xl shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        value="{{ now()->format('Y-m-d') }}" placeholder="{{ __('Warning Date') }}" />
                </div>

                <x-input-error :messages="$errors->userWarning->get('warning_date')" class="mt-2 text-red-600" />
            </div>

            <div class="mt-6">
                <x-input-label for="reason" value="{{ __('Reason') }}" class="sr-only" />
                <textarea id="reason" name="reason" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    placeholder="{{ __('Reason') }}"></textarea>

                <x-input-error :messages="$errors->userWarning->get('reason')" class="mt-2 text-red-600" />
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
