<x-admin-layout>
    <div class="col-span-7">
        <div class="mb-2 flex justify-between">
            <div>
                <x-action-buttons :href="route('admin.order.index')" :active="request('table') === null">
                    {{ __('Orders') }}
                </x-action-buttons>
                <x-action-buttons :href="route('admin.order.index', ['table' => 'refund'])" :active="request('table') === 'refund'">
                    {{ __('Refunds') }}
                </x-action-buttons>
                <x-action-buttons :href="route('admin.order.index', ['table' => 'cancellation'])" :active="request('table') === 'cancellation'">
                    {{ __('Cancellations') }}
                </x-action-buttons>
            </div>

        </div>
        @php
            $table = request('table', null);
        @endphp
        @if ($table === null)
            <div class="relative p-2 overflow-x-auto shadow-md sm:rounded-lg bg-white dark:bg-gray-900">
                <div
                    class="flex items-center justify-between flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 pb-2 border-b-2">
                    <div class="flex space-x-2">
                        <x-button-header :href="route('admin.order.index', ['status' => 'all'])" :active="request('status') === 'all'">
                            All
                        </x-button-header>
                        <x-button-header :href="route('admin.order.index', ['status' => 'pending'])" :active="request('status') === 'pending'">
                            Pending
                        </x-button-header>
                        <x-button-header :href="route('admin.order.index', ['status' => 'accepted'])" :active="request('status') === 'accepted'">
                            Accepted
                        </x-button-header>
                        <x-button-header :href="route('admin.order.index', ['status' => 'in-transit'])" :active="request('status') === 'in-transit'">
                            In Transit
                        </x-button-header>
                        <x-button-header :href="route('admin.order.index', ['status' => 'completed'])" :active="request('status') === 'completed'">
                            Completed
                        </x-button-header>
                        <x-button-header :href="route('admin.order.index', ['status' => 'cancelled'])" :active="request('status') === 'cancelled'">
                            Cancelled
                        </x-button-header>
                        <x-button-header :href="route('admin.order.index', ['status' => 'returned'])" :active="request('status') === 'returned'">
                            Returned
                        </x-button-header>
                        <x-button-header :href="route('admin.order.index', ['status' => 'hold'])" :active="request('status') === 'hold'">
                            Hold
                        </x-button-header>
                    </div>
                    <!-- Search Form -->
                    <form method="GET" action="{{ route('admin.order.index') }}" class="relative">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                        </div>
                        <input type="text" name="search" id="table-search-users"
                            class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Search for users" value="{{ request('search') }}">
                    </form>
                </div>
                <!-- Table -->
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 mt-2">
                    <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Client Name
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Artist Name
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Category
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Delivery Date
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Total
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Delivery Status
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                        <!-- Example row -->
                        @foreach ($orders as $order)
                            {{-- @if (request('status') === 'all' || request('status') === $order->status) --}}
                                <tr class="hover:bg-gray-100 dark:hover:bg-gray-800">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                @if ($order->client->user->profileImage)
                                                    <img class="h-10 w-10 rounded-full"
                                                        src="{{ asset('storage/' . $order->client->user->profileImage->path) }}"
                                                        alt="img">
                                                @else
                                                    <img class="h-10 w-10 rounded-full"
                                                        src="{{ asset('images/profile.default.jpg') }}" alt="img">
                                                @endif
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900 dark:text-gray-200">
                                                    {{ $order->client->user->name }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 dark:text-gray-200">
                                            {{ $order->items->first()->artwork->artist->user->name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 dark:text-gray-200">
                                            {{ $order->items->first()->artwork->category->name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 dark:text-gray-200">
                                            {{ \Carbon\Carbon::parse($order->delivery->expected_delivery)->format('Y-m-d') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 dark:text-gray-200">
                                            ₱{{ $order->total }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    @if ($order->status === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($order->status === 'accepted') bg-blue-100 text-blue-800
                                    @elseif($order->status === 'in-transit') bg-orange-100 text-orange-800
                                    @elseif($order->status === 'completed') bg-green-100 text-green-800
                                    @elseif($order->status === 'cancelled') bg-red-100 text-red-800
                                    @elseif($order->status === 'returned') bg-purple-100 text-purple-800
                                    @elseif($order->status === 'hold') bg-gray-100 text-gray-800 @endif">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    @if ($order->delivery->status === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($order->delivery->status === 'in-transit') bg-blue-100 text-blue-800
                                    @elseif($order->delivery->status === 'completed') bg-green-100 text-green-800
                                    @elseif($order->delivery->status === 'cancelled') bg-red-100 text-red-800 @endif">
                                            {{ ucfirst($order->delivery->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('admin.order.show', $order) }}"
                                            class="text-indigo-600 hover:text-indigo-900">
                                            View
                                        </a>
                                    </td>
                                </tr>
                            {{-- @endif --}}
                        @endforeach
                        <!-- Add more rows as needed -->
                    </tbody>
                </table>
                {{-- PAGINATION --}}
                {{-- <div class="flex items-center justify-between pt-4" aria-label="Table navigation">
                    <span
                        class="text-sm font-normal text-gray-500 dark:text-gray-400 mb-4 md:mb-0 block w-full md:inline md:w-auto">
                        Showing <span
                            class="font-semibold text-gray-900 dark:text-white">{{ $users->firstItem() }}</span>
                        to <span class="font-semibold text-gray-900 dark:text-white">{{ $users->lastItem() }}</span>
                        of <span class="font-semibold text-gray-900 dark:text-white">{{ $users->total() }}</span>
                        results
                    </span>
                    {{ $users->links() }}
                </div> --}}
            </div>
        @elseif ($table === 'refund')
            <div class="relative p-2 overflow-x-auto shadow-md sm:rounded-lg bg-white dark:bg-gray-900">
                <div
                    class="flex items-center justify-between flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 pb-2 border-b-2">
                    <div class="flex space-x-2">
                        <x-button-header :href="route('admin.order.index', ['status' => 'all'])" :active="request('status', 'all') === 'all'">
                            All
                        </x-button-header>
                        <x-button-header :href="route('admin.order.index', ['status' => 'pending'])" :active="request('status') === 'pending'">
                            Pending
                        </x-button-header>
                        <x-button-header :href="route('admin.order.index', ['status' => 'in-progress'])" :active="request('status') === 'in-progress'">
                            In Review
                        </x-button-header>
                        <x-button-header :href="route('admin.order.index', ['status' => 'completed'])" :active="request('status') === 'completed'">
                            Approved
                        </x-button-header>
                        <x-button-header :href="route('admin.order.index', ['status' => 'cancelled'])" :active="request('status') === 'cancelled'">
                            Denied
                        </x-button-header>
                    </div>
                    <!-- Search Form -->
                    <form method="GET" action="{{ route('admin.user.index') }}" class="relative">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                        </div>
                        <input type="text" name="search" id="table-search-users"
                            class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Search for users" value="{{ request('search') }}">
                    </form>
                </div>
                <!-- Table -->
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 mt-2">
                    <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Client Name
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Artist Name
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Refund Amount
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Request Date
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Reason
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($refunds as $refund)
                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-800">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <img class="h-10 w-10 rounded-full" src="{{$refund->order->client->user->profileImage ? asset('storage/' . $refund->order->client->user->profileImage->path) : asset('images/profile.default.jpg')}}" alt="img">
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900 dark:text-gray-200">
                                            {{$refund->order->client->user->name}}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <img class="h-10 w-10 rounded-full" src="{{$refund->order->items->first()->artwork->artist->user->profileImage ? asset('storage/' . $refund->order->items->first()->artwork->artist->user->profileImage->path) : asset('images/profile.default.jpg')}}" alt="img">
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900 dark:text-gray-200">
                                            {{$refund->order->items->first()->artwork->artist->user->name}}
                                        </div>
                                    </div>
                                </div>
                                <div class="text-sm text-gray-900 dark:text-gray-200"></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-gray-200">₱{{ number_format($refund->amount, 2, '.', ',') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-gray-200">{{ \Carbon\Carbon::parse($refund->created_at)->format('Y-m-d') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-gray-200">{{$refund->reason}}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    {{ucfirst($refund->status)}}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('admin.order.show', $refund->order) }}"
                                    class="text-indigo-600 hover:text-indigo-900">
                                    View
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{-- PAGINATION --}}
                {{-- <div class="flex items-center justify-between pt-4" aria-label="Table navigation">
                <span
                    class="text-sm font-normal text-gray-500 dark:text-gray-400 mb-4 md:mb-0 block w-full md:inline md:w-auto">
                    Showing <span
                        class="font-semibold text-gray-900 dark:text-white">{{ $users->firstItem() }}</span>
                    to <span class="font-semibold text-gray-900 dark:text-white">{{ $users->lastItem() }}</span>
                    of <span class="font-semibold text-gray-900 dark:text-white">{{ $users->total() }}</span>
                    results
                </span>
                {{ $users->links() }}
            </div> --}}
            </div>
        @elseif ($table === 'cancellation')
            <div class="relative p-2 overflow-x-auto shadow-md sm:rounded-lg bg-white dark:bg-gray-900">
                <div
                    class="flex items-center justify-between flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 pb-2 border-b-2">
                    <div class="flex space-x-2">
                        <x-button-header :href="route('admin.order.index', ['status' => 'all'])" :active="request('status', 'all') === 'all'">
                            All
                        </x-button-header>
                        <x-button-header :href="route('admin.order.index', ['status' => 'pending'])" :active="request('status') === 'pending'">
                            Pending
                        </x-button-header>
                        <x-button-header :href="route('admin.order.index', ['status' => 'in-progress'])" :active="request('status') === 'in-progress'">
                            In Review
                        </x-button-header>
                        <x-button-header :href="route('admin.order.index', ['status' => 'completed'])" :active="request('status') === 'completed'">
                            Approved
                        </x-button-header>
                        <x-button-header :href="route('admin.order.index', ['status' => 'cancelled'])" :active="request('status') === 'cancelled'">
                            Denied
                        </x-button-header>
                    </div>
                    <!-- Search Form -->
                    <form method="GET" action="{{ route('admin.user.index') }}" class="relative">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                        </div>
                        <input type="text" name="search" id="table-search-users"
                            class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Search for users" value="{{ request('search') }}">
                    </form>
                </div>
                <!-- Table -->
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 mt-2">
                    <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Client Name
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Artist Name
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Refund Amount
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Request Date
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Reason
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($cancellations as $cancellation)
                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-800">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <img class="h-10 w-10 rounded-full" src="{{$cancellation->order->client->user->profileImage ? asset('storage/' . $cancellation->order->client->user->profileImage->path) : asset('images/profile.default.jpg')}}" alt="img">
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900 dark:text-gray-200">
                                            {{$cancellation->order->client->user->name}}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <img class="h-10 w-10 rounded-full" src="{{$cancellation->order->items()->first()->artwork->artist->user->profileImage ? asset('storage/' . $cancellation->order->items->first()->artwork->artist->user->profileImage->path) : asset('images/profile.default.jpg')}}" alt="img">
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900 dark:text-gray-200">
                                            {{$cancellation->order->items->first()->artwork->artist->user->name}}
                                        </div>
                                    </div>
                                </div>
                                <div class="text-sm text-gray-900 dark:text-gray-200"></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-gray-200">₱{{ number_format($cancellation->amount, 2, '.', ',') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-gray-200">{{ \Carbon\Carbon::parse($cancellation->created_at)->format('Y-m-d') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-gray-200">{{$cancellation->reason ?? 'None'}}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    {{ucfirst($cancellation->status)}}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                None
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{-- PAGINATION --}}
                {{-- <div class="flex items-center justify-between pt-4" aria-label="Table navigation">
                <span
                    class="text-sm font-normal text-gray-500 dark:text-gray-400 mb-4 md:mb-0 block w-full md:inline md:w-auto">
                    Showing <span
                        class="font-semibold text-gray-900 dark:text-white">{{ $users->firstItem() }}</span>
                    to <span class="font-semibold text-gray-900 dark:text-white">{{ $users->lastItem() }}</span>
                    of <span class="font-semibold text-gray-900 dark:text-white">{{ $users->total() }}</span>
                    results
                </span>
                {{ $users->links() }}
            </div> --}}
            </div>
            `
        @endif
    </div>
</x-admin-layout>
