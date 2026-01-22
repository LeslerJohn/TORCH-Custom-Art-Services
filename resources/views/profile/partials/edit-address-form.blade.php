<section class="bg-white p-4 sm:p-6 shadow-md rounded-lg mt-6">
    <header class="mb-6">
        <h2 class="text-lg sm:text-xl font-semibold text-gray-900">
            {{ $user->address ? __('Edit Address') : __('Add Address') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            {{ $user->address ? __('Update your address information.') : __('Enter your address information.') }}
        </p>
    </header>

    <form method="post" action="{{ $user->address ? route('address.update', $user) : route('address.store', $user) }}" class="grid grid-cols-1 gap-4 sm:gap-6">
        @csrf
        @if ($user->address)
        @method('PUT')
        @endif

        <!-- Barangay -->
        <div class="col-span-1 sm:col-span-2">
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
        <div class="col-span-1">
            <x-input-label for="house_number" :value="__('House Number')" />
            <x-text-input id="house_number" name="house_number" type="text" class="mt-1 block w-full" value="{{ old('house_number', $user->address->house_number ?? '') }}" />
            <x-input-error :messages="$errors->updateAddress->get('house_number')" class="mt-2 text-red-600" />
        </div>

        <!-- Save Button -->
        <div class="col-span-1 sm:col-span-2 flex justify-end mt-4">
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

    <!-- Success/Error Messages -->
    @if (session()->has('success') || session()->has('error'))
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" class="mt-4">
        @if (session()->has('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">Success!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
        @endif

        @if (session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">Error!</strong>
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
        @endif
    </div>
    @endif
</section>