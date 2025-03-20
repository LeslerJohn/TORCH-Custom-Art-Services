<x-admin-layout>
    <div class="col-span-7">
        <div class="mb-2 flex justify-between">
            <h1 class="text-xl font-bold">{{ __('Payouts') }}</h1>
            <form method="POST" action="{{ route('admin.payout.processAll') }}">
                @csrf
                <x-button type="submit" class="bg-green-500 hover:bg-green-600" :disabled="$payouts->where('status', 'ready')->isEmpty()">
                    {{ __('Process All Ready Payouts') }}
                </x-button>
            </form>
        </div>
        <div class="relative p-2 overflow-x-auto shadow-md sm:rounded-lg bg-white dark:bg-gray-900">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 mt-2">
                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Artist Name
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Payout Type
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Amount
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach ($payouts as $payout)
                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-800">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-gray-200">
                                    {{ $payout->artist->user->name }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-gray-200">
                                    {{ ucfirst($payout->payout_type) }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-gray-200">
                                    ₱{{ number_format($payout->net_amount, 2) }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    @if($payout->status === 'ready') bg-blue-100 text-blue-800
                                    @elseif($payout->status === 'completed') bg-green-100 text-green-800
                                    @elseif($payout->status === 'failed') bg-red-100 text-red-800
                                    @else bg-yellow-100 text-yellow-800 @endif">
                                    {{ ucfirst($payout->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                @if ($payout->status === 'ready')
                                    <form method="POST" action="{{ route('admin.payout.process', $payout) }}">
                                        @csrf
                                        @method('PATCH')
                                        <x-primary-button type="submit" class="bg-green-500 hover:bg-green-600">
                                            {{ __('Payout') }}
                                        </x-primary-button>
                                    </form>
                                @else
                                    <span class="text-gray-500">{{ __('Not Available') }}</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
