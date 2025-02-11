<x-admin-layout>
    <div class="pt-16 px-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">Application Details</h1>
            <a href="{{ route('admin.application.index') }}" class="">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 9-3 3m0 0 3 3m-3-3h7.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </a>
        </div>
        <div class="bg-white shadow-md rounded-lg p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4">User Information</h2>
            <div class="space-y-2">
                <p><span class="font-medium">Name:</span> {{ $user->name ?? 'N/A' }}</p>
                <p><span class="font-medium">Email:</span> {{ $user->email ?? 'N/A' }}</p>
                <p><span class="font-medium">Role:</span> {{ ucfirst($user->role ?? 'N/A') }}</p>
                <p><span class="font-medium">Gender:</span> {{ ucfirst($user->artist->gender ?? 'N/A') }}</p>
                <p><span class="font-medium">Birthdate:</span> {{ $user->artist->birthdate ?? 'N/A' }}</p>
                <p><span class="font-medium">Contact Number:</span> {{ $user->artist->phone_number ?? 'N/A' }}</p>
                <p><span class="font-medium">Location:</span> {{ $user->artist->location ?? 'N/A' }}</p>
                <p class="mt-4 font-medium">Artist Bio</p>
                <textarea class="w-full p-2 border rounded" rows="4" readonly>{{ $user->artist->bio ?? 'N/A' }}</textarea>
                <p class="mt-4"><span class="font-medium">Status:</span> {{ ucfirst($user->artist->status ?? 'No Status') }}</p>
                <p class="mt-4"><span class="font-medium">Artist Tags:</span> 
                    @if($user->artist && $user->artist->tags)
                        @foreach($user->artist->tags as $tag)
                            <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2">{{ $tag }}</span>
                        @endforeach
                    @else
                        <span>No Tags</span>
                    @endif
                </p>
            </div>
        </div>
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-xl font-semibold mb-4">Portfolio</h2>
            <div class="space-y-2">
                <p><span class="font-medium">Portfolio Link:</span> <a href="{{ $user->artist->portfolio->link ?? '#' }}" target="_blank" class="text-blue-500 hover:underline">{{ $user->artist->portfolio->link ?? 'No Link' }}</a></p>
                @if($user->artist && $user->artist->portfolio && $user->artist->portfolio->attachment && $user->artist->portfolio->attachment->path)
                    <p><span>Portfolio File: </span><a href="{{ asset('storage/' . $user->artist->portfolio->attachment->path) }}" target="_blank" class="text-blue-500 hover:underline">Download</a></p>
                @else
                    <p>No portfolio available.</p>
                @endif
            </div>
        </div>
        <div class="flex mt-6 mb-16 gap-4">
            <a href="{{ route('admin.application.approve', $user->id) }}">
                <x-primary-button>
                    Approve
                </x-primary-button>
            </a>
            <a href="{{ route('admin.application.reject', $user->id) }}">
                <x-secondary-button>
                    Reject
                </x-secondary-button>
            </a>
        </div>
    </div>
</x-admin-layout>