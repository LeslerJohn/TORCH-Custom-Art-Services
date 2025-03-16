<section class="space-y-6">
    <x-secondary-button x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-approve')">{{ __('Approve ') }}</x-secondary-button>

    <x-modal name="confirm-user-approve" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="" class="p-6 bg-white rounded-lg shadow-md">
            @csrf
            @method('delete')
            <p class="mt-1 text-sm text-gray-600 pb-2">
                {{ __('You are about to Approve this user\'s request.') }}
            </p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-gray-50 p-4 rounded-lg shadow-sm">
                <div>
                    <label class="text-gray-600 font-medium">Reason</label>
                    <p class="text-gray-900 font-semibold">Client requested cancellation</p>
                </div>
                <div>
                    <label class="text-gray-600 font-medium">Description</label>
                    <p class="text-gray-900 font-semibold">Client decided to cancel the commission due to personaal
                        reason</p>
                </div>
                <div>
                    <label class="text-gray-600 font-medium">Request Date</label>
                    <p class="text-gray-900 font-semibold">12/01/2023</p>
                </div>
                <div>
                    <label class="text-gray-600 font-medium">Refund Date</label>
                    <p class="text-gray-900 font-semibold">{{ now()->format('m/d/Y') }}</p>
                </div>
                <div>
                    <label class="text-gray-600 font-medium">Cancellation Fee</label>
                    <p class="text-red-600 font-semibold">$200</p>
                </div>
                <div>
                    <label class="text-gray-600 font-medium">Refund Fee</label>
                    <p class="text-red-600 font-semibold">$200</p>
                </div>
                <div>
                    <label class="text-gray-600 font-medium">Refund Amount</label>
                    <p class="text-red-600 font-semibold">$5000</p>
                </div>
                <div>
                    <label class="text-gray-600 font-medium">Total Payout</label>
                    <p class="text-red-600 font-semibold">$4600</p>
                </div>
            </div>
            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')" class="bg-gray-200 hover:bg-gray-300 text-gray-700">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-primary-button class="ms-3 text-white">
                    {{ __('PAYMENT API HERE') }}
                </x-primary-button>
            </div>
        </form>
    </x-modal>
</section>
