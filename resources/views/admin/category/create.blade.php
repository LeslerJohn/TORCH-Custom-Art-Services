<x-admin-layout>
    <form action="{{ route('admin.category.store') }}" method="POST" class="max-w-lg mt-32 mx-auto p-6 bg-white shadow-md rounded">
        @csrf
        <div class="mb-4">
            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Category Name</label>
            <input type="text" id="name" name="name" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div id="tagsContainer" class="mb-4">
            <label for="tags" class="block text-gray-700 text-sm font-bold mb-2">Tags (comma separated)</label>
            <input type="text" id="tags" name="tags[]" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <button id="addTagButton" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Add Tag</button>
        <div class="flex items-center justify-between">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Add Category</button>
        </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const addTagButton = document.getElementById('addTagButton');
            const tagsContainer = document.getElementById('tagsContainer');

            addTagButton.addEventListener('click', function (e) {
                e.preventDefault();
                const newTagInput = document.createElement('input');
                newTagInput.type = 'text';
                newTagInput.name = 'tags[]';
                newTagInput.className = 'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mt-2';
                tagsContainer.appendChild(newTagInput);
            });
        });
    </script>
    </form>
</x-admin-layout>