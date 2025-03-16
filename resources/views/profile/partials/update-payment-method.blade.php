<section class="bg-white p-6 shadow-md rounded-lg mt-6">
    <header>Edit Payment Method</header>
    <form method="POST" action="{{ route('profile.update-payment-method') }}">
        @csrf
        @method('PUT')

        <div>
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
                value="{{ old('payment_method', $user->artist->payment->payment_method) }}">
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

            // Set initial selected payment method
            document.addEventListener('DOMContentLoaded', function () {
                const initialMethod = "{{ old('payment_method', $user->artist->payment->payment_method) }}";
                if (initialMethod) {
                selectPaymentMethod(initialMethod);
                }
            });
            </script>

            <!-- Payment Name and Number -->
            <div class="mt-4">
            <x-input-label for="payment_name" :value="__('Name')" />
            <x-text-input id="payment_name" class="block mt-1 w-full" type="text" name="payment_name"
                placeholder="John Doe" :value="old('payment_name', $user->artist->payment->account_name)" required />
            <x-input-error :messages="$errors->get('payment_name')" class="mt-2" />
            </div>

            <div class="mt-4 w-full">
            <x-input-label for="payment_number" :value="__('Number')" />
            <div class="flex">
                <span
                class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">+63</span>
                <x-text-input id="payment_number" class="block mt-1 w-full rounded-l-none" type="text"
                name="payment_number" placeholder="9123456789" :value="old('payment_number', $user->artist->payment->account_number)" required
                maxlength="10" />
            </div>
            <x-input-error :messages="$errors->get('payment_number')" class="mt-2" />
            </div>
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Save') }}
            </x-primary-button>
        </div>
    </form>
</section>