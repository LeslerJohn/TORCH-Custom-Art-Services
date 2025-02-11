<x-admin-layout>
    <div class="flex justify-between pt-16 pr-4">
        <h1 class="text-2lg text-bold text-black-500">Categories</h1>
        <a href="{{ route('admin.category.create') }}">
            <button class="bg-orange-600 text-white px-4 py-2 rounded-lg hover:bg-orange-700">
                Add Category
            </button>
        </a>
    </div>

    <div class="mt-8">
        <div class="bg-white p-4 rounded-lg shadow-md w-full">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Category</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tags
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($categories as $category)
                        <tr>
                            <a href="{{ route('admin.category.show', $category) }}">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $category->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <ul class="list-disc list-inside">
                                        @foreach ($category->tags as $tag)
                                            <li>{{ $tag->name }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('admin.category.show', $category) }} "
                                        class="text-green-500 pr-2 hover:underline">View</a>
                                    <a href="{{ route('admin.category.edit', $category) }}"
                                        class="text-blue-500 hover:underline">Edit</a>
                                    <form action="{{ route('admin.category.destroy', $category) }}" method="POST"
                                        class="inline" onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:underline ml-2">Delete</button>
                                    </form>
                                </td>
                            </a>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
