<x-admin-layout>
    <form method="POST" action="{{ route('admin.user.update', $user->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
            <input type="text" name="name" id="name" value="{{ $user->name }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
        </div>

        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="email" id="email" value="{{ $user->email }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
        </div>

        @if ($user->role === 'client')
            <div class="mb-4">
                <label for="rating" class="block text-sm font-medium text-gray-700">Rating</label>
                <input type="number" step="0.1" name="rating" id="rating" value="{{ $profile->rating }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>
        @elseif ($user->role === 'artist')
            <div class="mb-4">
                <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                <input type="text" name="location" id="location" value="{{ $profile->location }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>
            <div class="mb-4">
                <label for="bio" class="block text-sm font-medium text-gray-700">Bio</label>
                <textarea name="bio" id="bio" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ $profile->bio }}</textarea>
            </div>
        @endif

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Save</button>
    </form>
</x-admin-layout>
