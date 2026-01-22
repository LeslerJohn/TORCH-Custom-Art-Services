<x-admin-layout>
    <div class="col-span-7">
        <h1 class="text-xl font-bold mb-4">{{ __('Payout Details') }}</h1>
        <div class="bg-white dark:bg-gray-900 p-4 rounded-lg shadow-md">
            <p><strong>Artist Name:</strong> {{ $payout->artist->user->name }}</p>
            <p><strong>Amount:</strong> ₱{{ number_format($payout->amount, 2) }}</p>
            <p><strong>Payment Method:</strong> {{ $payout->payout_method }}</p>
            <p><strong>Status:</strong> {{ ucfirst($payout->status) }}</p>
        </div>
        @if($payout->status === 'ready')
            <form method="POST" action="{{ route('admin.payout.update', $payout) }}" class="mt-4">
                @csrf
                @method('PUT')
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg">
                    Confirm Payment
                </button>
            </form>
        @endif
    </div>
</x-admin-layout>
