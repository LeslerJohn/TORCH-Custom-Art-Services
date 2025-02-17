<x-admin-layout>
    <div>
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">Application Details</h1>
            <a href="{{ route('admin.application.index') }}" class="text-blue-500 hover:underline">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="m11.25 9-3 3m0 0 3 3m-3-3h7.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </a>
        </div>
        <div class="flex bg-white shadow-md rounded-lg p-6 mb-6 gap-4">
            <div class="w-1/2">
                <h2 class="text-xl font-semibold mb-4">User Information</h2>
                <div class="space-y-4">
                    <div class="flex items-center space-x-4">
                        <div class="w-32 h-32">
                            @if ($user->artist && $user->artist->profile_picture)
                                <img src="{{ asset('storage/' . $user->artist->profile_picture) }}" alt="Profile Picture" class="w-full h-full rounded-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gray-200 rounded-full">
                                    <span>No Profile Picture</span>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div>
                        <label class="font-medium">Name:</label>
                        <span>{{ $user->name ?? 'N/A' }}</span>
                    </div>
                    <div>
                        <label class="font-medium">Email:</label>
                        <span>{{ $user->email ?? 'N/A' }}</span>
                    </div>
                    <div>
                        <label class="font-medium">Role:</label>
                        <span>{{ ucfirst($user->role ?? 'N/A') }}</span>
                    </div>
                    <div>
                        <label class="font-medium">Gender:</label>
                        <span>{{ ucfirst($user->artist->gender ?? 'N/A') }}</span>
                    </div>
                    <div>
                        <label class="font-medium">Birthdate:</label>
                        <span>{{ $user->artist->birthdate ?? 'N/A' }}</span>
                    </div>
                    <div>
                        <label class="font-medium">Contact Number:</label>
                        <span>{{ $user->artist->phone_number ?? 'N/A' }}</span>
                    </div>
                    <div>
                        <label class="font-medium">Location:</label>
                        <span>{{ $user->artist->location ?? 'N/A' }}</span>
                    </div>
                    <div>
                        <label class="font-medium">Artist Bio:</label>
                        <div class="w-full p-2 border rounded bg-gray-100">{{ $user->artist->bio ?? 'N/A' }}</div>
                    </div>
                    <div>
                        <label class="font-medium">Status:</label>
                        <span>{{ ucfirst($user->artist->status ?? 'No Status') }}</span>
                    </div>
                    <div>
                        <label class="font-medium">Artist Tags:</label>
                        <div>
                            @if ($user->artist && $user->artist->tags)
                                @foreach ($user->artist->tags as $tag)
                                    <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2">{{ $tag->name }}</span>
                                @endforeach
                            @else
                                <span>No Tags</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-1/2">
                <h2 class="text-xl font-semibold mb-4">Portfolio</h2>
                <div class="space-y-2">
                    <p><span class="font-medium">Portfolio Link:</span> <a
                            href="{{ $user->artist->portfolio->link ?? '#' }}" target="_blank"
                            class="text-blue-500 hover:underline">{{ $user->artist->portfolio->link ?? 'No Link' }}</a>
                    </p>
                    <div class="border p-4 rounded-lg">
                        @if (
                            $user->artist &&
                                $user->artist->portfolio &&
                                $user->artist->portfolio->attachment &&
                                $user->artist->portfolio->attachment->path)
                            <p><span>Portfolio File: </span><a
                                    href="{{ asset('storage/' . $user->artist->portfolio->attachment->path) }}"
                                    target="_blank" class="text-blue-500 hover:underline">Download</a></p>
                        @else
                            <p>No portfolio available.</p>
                        @endif
                    </div>
                </div>
            </div>
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
