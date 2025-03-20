<x-admin-layout>
    <div class="flex justify-between pr-4">
        <h1 class="text-4xl text-bold text-black-500">Categories</h1>
        <button id="openModalButton" class="bg-orange-600 text-white px-4 py-2 rounded-lg hover:bg-orange-700">
            Add Category
        </button>
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
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                <input type="text" value="{{ $category->name }}" 
                                    class="border rounded px-2 py-1 w-full" 
                                    onchange="updateCategory('{{ $category->id }}', this.value)">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <ul class="list-disc list-inside">
                                    @foreach ($category->tags as $tag)
                                        <li class="flex items-center">
                                            {{ $tag->name }}
                                            <button onclick="removeTag('{{ $category->id }}', '{{ $tag->id }}')" 
                                                class="text-red-500 ml-2 hover:underline">Remove</button>
                                        </li>
                                    @endforeach
                                </ul>
                                <div class="mt-2">
                                    <input type="text" placeholder="Add new tag" 
                                        class="border rounded px-2 py-1 w-full" 
                                        onkeypress="addTag(event, '{{ $category->id }}')">
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <form action="{{ route('admin.category.destroy', $category) }}" method="POST"
                                    class="inline" onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline ml-2">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div id="categoryModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center">
        <div class="bg-white p-6 rounded shadow-lg w-1/3">
            <h2 class="text-lg font-bold mb-4">Add Category</h2>
            <form action="{{ route('admin.category.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Category Name</label>
                    <input type="text" id="name" name="name" required
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div id="tagsContainer" class="mb-4">
                    <label for="tags" class="block text-gray-700 text-sm font-bold mb-2">Tags (comma separated)</label>
                    <input type="text" id="tags" name="tags[]" 
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <button id="addTagButton" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Add Tag</button>
                <div class="flex items-center justify-between mt-4">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Add Category</button>
                    <button type="button" id="closeModalButton" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const openModalButton = document.getElementById('openModalButton');
            const closeModalButton = document.getElementById('closeModalButton');
            const categoryModal = document.getElementById('categoryModal');
            const addTagButton = document.getElementById('addTagButton');
            const tagsContainer = document.getElementById('tagsContainer');

            openModalButton.addEventListener('click', () => categoryModal.classList.remove('hidden'));
            closeModalButton.addEventListener('click', () => categoryModal.classList.add('hidden'));

            addTagButton.addEventListener('click', function (e) {
                e.preventDefault();
                const newTagInput = document.createElement('input');
                newTagInput.type = 'text';
                newTagInput.name = 'tags[]';
                newTagInput.className = 'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mt-2';
                tagsContainer.appendChild(newTagInput);
            });
        });

        function updateCategory(categoryId, newName) {
            fetch(`/admin/category/${categoryId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ name: newName })
            }).then(response => {
                if (!response.ok) {
                    alert('Failed to update category');
                }
            });
        }

        function removeTag(categoryId, tagId) {
            fetch(`/admin/category/${categoryId}/tags/${tagId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }).then(response => {
                if (response.ok) {
                    location.reload();
                } else {
                    alert('Failed to remove tag');
                }
            });
        }

        function addTag(event, categoryId) {
            if (event.key === 'Enter') {
                event.preventDefault();
                const tagName = event.target.value.trim();
                if (tagName) {
                    fetch(`/admin/category/${categoryId}/tags`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ name: tagName })
                    }).then(response => {
                        if (response.ok) {
                            location.reload();
                        } else {
                            alert('Failed to add tag');
                        }
                    });
                }
            }
        }
    </script>
</x-admin-layout>
