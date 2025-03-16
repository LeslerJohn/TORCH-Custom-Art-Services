<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Disbursement to Landlords') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('payment.disburse') }}" id="disbursementForm">
                        @csrf
                        
                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Landlord Payment Details</h3>
                            
                            <div id="landlordsContainer">
                                <div class="landlord-entry border p-4 rounded-md mb-4">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label for="landlords[0][name]" class="block text-sm font-medium text-gray-700">Landlord Name</label>
                                            <input type="text" name="landlords[0][name]" id="landlords[0][name]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        </div>
                                        
                                        <div>
                                            <label for="landlords[0][amount]" class="block text-sm font-medium text-gray-700">Amount (PHP)</label>
                                            <input type="number" name="landlords[0][amount]" id="landlords[0][amount]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        </div>
                                        
                                        <div>
                                            <label for="landlords[0][account_number]" class="block text-sm font-medium text-gray-700">Account Number</label>
                                            <input type="text" name="landlords[0][account_number]" id="landlords[0][account_number]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        </div>
                                        
                                        <div>
                                            <label for="landlords[0][bank_code]" class="block text-sm font-medium text-gray-700">Bank Code</label>
                                            <select name="landlords[0][bank_code]" id="landlords[0][bank_code]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                                <option value="bdo">BDO</option>
                                                <option value="bpi">BPI</option>
                                                <option value="metrobank">Metrobank</option>
                                                <option value="unionbank">UnionBank</option>
                                                <option value="gcash">GCash</option>
                                            </select>
                                        </div>
                                        
                                        <div>
                                            <label for="landlords[0][email]" class="block text-sm font-medium text-gray-700">Email (Optional)</label>
                                            <input type="email" name="landlords[0][email]" id="landlords[0][email]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        </div>
                                        
                                        <div>
                                            <label for="landlords[0][phone]" class="block text-sm font-medium text-gray-700">Phone (Optional)</label>
                                            <input type="text" name="landlords[0][phone]" id="landlords[0][phone]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <button type="button" id="addLandlord" class="mt-2 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Add Another Landlord
                            </button>
                        </div>
                        
                        <div class="flex justify-end">
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary-full hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-full">
                                Process Disbursements
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addLandlordBtn = document.getElementById('addLandlord');
            const landlordsContainer = document.getElementById('landlordsContainer');
            let landlordCount = 1;

            addLandlordBtn.addEventListener('click', function() {
                const template = `
                <div class="landlord-entry border p-4 rounded-md mb-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="landlords[${landlordCount}][name]" class="block text-sm font-medium text-gray-700">Landlord Name</label>
                            <input type="text" name="landlords[${landlordCount}][name]" id="landlords[${landlordCount}][name]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                        
                        <div>
                            <label for="landlords[${landlordCount}][amount]" class="block text-sm font-medium text-gray-700">Amount (PHP)</label>
                            <input type="number" name="landlords[${landlordCount}][amount]" id="landlords[${landlordCount}][amount]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                        
                        <div>
                            <label for="landlords[${landlordCount}][account_number]" class="block text-sm font-medium text-gray-700">Account Number</label>
                            <input type="text" name="landlords[${landlordCount}][account_number]" id="landlords[${landlordCount}][account_number]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                        
                        <div>
                            <label for="landlords[${landlordCount}][bank_code]" class="block text-sm font-medium text-gray-700">Bank Code</label>
                            <select name="landlords[${landlordCount}][bank_code]" id="landlords[${landlordCount}][bank_code]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="bdo">BDO</option>
                                <option value="bpi">BPI</option>
                                <option value="metrobank">Metrobank</option>
                                <option value="unionbank">UnionBank</option>
                                <option value="gcash">GCash</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="landlords[${landlordCount}][email]" class="block text-sm font-medium text-gray-700">Email (Optional)</label>
                            <input type="email" name="landlords[${landlordCount}][email]" id="landlords[${landlordCount}][email]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                        
                        <div>
                            <label for="landlords[${landlordCount}][phone]" class="block text-sm font-medium text-gray-700">Phone (Optional)</label>
                            <input type="text" name="landlords[${landlordCount}][phone]" id="landlords[${landlordCount}][phone]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                    </div>
                    <button type="button" class="remove-landlord mt-2 inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-500 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Remove
                    </button>
                </div>
                `;
                
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = template;
                landlordsContainer.appendChild(tempDiv.firstElementChild);
                
                landlordCount++;
                
                // Add event listeners to the remove buttons
                document.querySelectorAll('.remove-landlord').forEach(button => {
                    button.addEventListener('click', function() {
                        this.closest('.landlord-entry').remove();
                    });
                });
            });
        });
    </script>
</x-app-layout>