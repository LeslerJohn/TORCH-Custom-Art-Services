<section class="bg-white p-4 sm:p-6 shadow-md rounded-lg mt-6">
    <header class="mb-4 sm:mb-6">
        <h2 class="text-lg sm:text-xl font-semibold text-gray-900">
            {{ __('Edit Address') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            {{ __('Update your address information.') }}
        </p>
    </header>

    <form method="post" action="{{ route('address.update') }}" class="grid grid-cols-2 sm:grid-cols-1 gap-4 sm:gap-6">
        @csrf
        @method('put')

        <!-- Barangay -->
        <div class="col-span-2">
            <x-input-label for="barangay" :value="__('Barangay')" />
            <x-text-input id="barangay" name="barangay" type="text" class="mt-1 block w-full" value="{{ old('barangay', $user->address->barangay ?? '') }}" />
            <x-input-error :messages="$errors->updateAddress->get('barangay')" class="mt-2 text-red-600" />
        </div>

        <!-- Street -->
        <div class="col-span-1">
            <x-input-label for="street" :value="__('Street')" />
            <x-text-input id="street" name="street" type="text" class="mt-1 block w-full" value="{{ old('street', $user->address->street ?? '') }}" />
            <x-input-error :messages="$errors->updateAddress->get('street')" class="mt-2 text-red-600" />
        </div>

        <!-- House Number -->
        <div>
            <x-input-label for="house_no" :value="__('House Number')" />
            <x-text-input id="house_no" name="house_no" type="text" class="mt-1 block w-full" value="{{ old('house_no', $user->address->house_number ?? '') }}" />
            <x-input-error :messages="$errors->updateAddress->get('house_no')" class="mt-2 text-red-600" />
        </div>

        <!-- Save Button -->
        <div class="col-span-2 flex justify-end mt-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'address-updated')
            <p
                x-data="{ show: true }"
                x-show="show"
                x-transition
                x-init="setTimeout(() => show = false, 2000)"
                class="text-sm text-green-600 ml-4">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>