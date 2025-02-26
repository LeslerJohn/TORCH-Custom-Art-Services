<section class="space-y-6">
    <x-secondary-button x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-suspend')">{{ __('Suspend User') }}</x-secondary-button>

    <x-modal name="confirm-user-suspend" :show="$errors->userSuspend->isNotEmpty()" focusable>
        <form method="post" action="" class="p-6 bg-white rounded-lg shadow-md">
            @csrf
            @method('post')

            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Suspend User') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('Please provide details for suspending this user.') }}
            </p>
            <div class="mt-6 grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div>
                    <x-input-label for="suspend_date" value="{{ __('Suspend Date') }}" />
                    <x-text-input id="suspend_date" name="suspend_date" type="date"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        placeholder="{{ __('Suspend Date') }}" value="{{ now()->format('Y-m-d') }}" readonly />
                    <x-input-error :messages="$errors->userSuspend->get('suspend_date')" class="mt-2 text-red-600" />
                </div>
                <div>
                    <x-input-label for="lift_date" value="{{ __('Lift Date') }}" />
                    <x-text-input id="lift_date" name="lift_date" type="date"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        placeholder="{{ __('Lift Date') }}" />
                    <x-input-error :messages="$errors->userSuspend->get('lift_date')" class="mt-2 text-red-600" />
                </div>
            </div>
            <div class="mt-6">
                <x-input-label for="reason" value="{{ __('Reason') }}" class="sr-only" />
                <textarea id="reason" name="reason"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    placeholder="{{ __('Reason') }}"></textarea>
                <x-input-error :messages="$errors->userSuspend->get('reason')" class="mt-2 text-red-600" />
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
