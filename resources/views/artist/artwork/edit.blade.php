<x-artist-layout>
    <div class="flex justify-between pt-16">
        <h1 class="text-2lg text-bold text-black-500">Edit Artwork</h1>
        <a href="{{ route('artist.artwork.index') }}">
            <x-secondary-button class="justify-center py-1 w-20 text-md hover:selected-tag">
                Back
            </x-secondary-button>
        </a>
    </div>
    <div class="mt-8">
        <form id="artwork-form" action="{{ route('artist.artwork.update', $artwork->id) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="flex gap-16">
                <div class="flex flex-col w-[400px]">
                    <div>
                        <x-input-label for="title" class="text-sm" :value="__('Title')" />
                        <x-text-input id="title" class="block mt-1 w-full" type="text" name="title"
                            value="{{ old('title', $artwork->title) }}" required autofocus />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>
                    <div class="mt-6">
                        <x-input-label for="description" class="text-sm" :value="__('Description')" />
                        <textarea id="description" class="block mt-1 w-full" name="description" required>{{ old('description', $artwork->description) }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>
                    <div class="mt-6">
                        <x-input-label for="dimension" class="text-sm" :value="__('Dimension (inch)')" />
                        <x-text-input id="dimension" class="block mt-1 w-full" type="text" name="dimension" required
                            value="{{ old('title', $artwork->dimension) }}" />
                        <x-input-error :messages="$errors->get('dimension')" class="mt-2" />
                    </div>
                    <div class="mt-6">
                        <x-input-label for="price" class="text-sm" :value="__('Price')" />
                        <x-text-input id="price" class="block mt-1 w-full" type="number" name="price" required
                            value="{{ old('title', $artwork->price) }}" />
                        <x-input-error :messages="$errors->get('price')" class="mt-2" />
                    </div>
                    <label class="inline-flex items-center cursor-pointer mt-4">
                        <input type="checkbox" value="1" name="is_showcase" class="sr-only peer"
                            {{ $artwork->is_showcase ? 'checked' : '' }}>
                        <div
                            class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600 dark:peer-checked:bg-blue-600">
                        </div>
                        <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Showcase this
                            Artwork</span>
                    </label>

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const categorySelect = document.getElementById('categories');
                            const tagsContainer = document.getElementById('tags-container');
                            const selectedTagsInput = document.getElementById('selected-tags');
                            let selectedTags = Array.from(selectedTagsInput.value.split(','));

                            // Fetch and display tags for the selected category
                            categorySelect.addEventListener('change', function() {
                                const categoryId = this.value;
                                fetch(`/get-tags/${categoryId}`)
                                    .then(response => response.json())
                                    .then(tags => {
                                        tagsContainer.innerHTML = ''; // Clear previous tags
                                        selectedTags = []; // Reset selected tags
                                        selectedTagsInput.value = '';

                                        tags.forEach(tag => {
                                            const tagCard = document.createElement('div');
                                            tagCard.classList.add('tag-card', 'border-2', 'border-gray-300',
                                                'text-sm', 'rounded-lg', 'p-2', 'cursor-pointer', 'w-32',
                                                'text-center');
                                            tagCard.setAttribute('data-tag-id', tag.id);
                                            tagCard.textContent = tag.name;

                                            // Mark tag as selected if it is in the selectedTags array
                                            if (selectedTags.includes(tag.id.toString())) {
                                                tagCard.classList.add('selected-tag');
                                            }

                                            tagCard.addEventListener('click', function() {
                                                const tagId = tag.id.toString();
                                                if (selectedTags.includes(tagId)) {
                                                    selectedTags = selectedTags.filter(id => id !==
                                                        tagId);
                                                    tagCard.classList.remove('selected-tag');
                                                } else {
                                                    selectedTags.push(tagId);
                                                    tagCard.classList.add('selected-tag');
                                                }
                                                selectedTagsInput.value = selectedTags.join(',');
                                            });

                                            tagsContainer.appendChild(tagCard);
                                        });
                                    })
                                    .catch(error => console.error('Error fetching tags:', error));
                            });

                            // Initialize existing tags as selected
                            document.querySelectorAll('.tag-card').forEach(tagCard => {
                                tagCard.addEventListener('click', function() {
                                    const tagId = tagCard.getAttribute('data-tag-id');
                                    if (selectedTags.includes(tagId)) {
                                        selectedTags = selectedTags.filter(id => id !== tagId);
                                        tagCard.classList.remove('selected-tag');
                                    } else {
                                        selectedTags.push(tagId);
                                        tagCard.classList.add('selected-tag');
                                    }
                                    selectedTagsInput.value = selectedTags.join(',');
                                });
                            });

                            // Populate tags for the initial category
                            const initialCategoryId = categorySelect.value;
                            if (initialCategoryId) {
                                fetch(`/get-tags/${initialCategoryId}`)
                                    .then(response => response.json())
                                    .then(tags => {
                                        tagsContainer.innerHTML = ''; // Clear previous tags

                                        tags.forEach(tag => {
                                            const tagCard = document.createElement('div');
                                            tagCard.classList.add('tag-card', 'border-2', 'border-gray-300', 'text-sm',
                                                'rounded-lg', 'p-2', 'cursor-pointer', 'w-32', 'text-center');
                                            tagCard.setAttribute('data-tag-id', tag.id);
                                            tagCard.textContent = tag.name;

                                            // Mark tag as selected if it is in the selectedTags array
                                            if (selectedTags.includes(tag.id.toString())) {
                                                tagCard.classList.add('selected-tag');
                                            }

                                            tagCard.addEventListener('click', function() {
                                                const tagId = tag.id.toString();
                                                if (selectedTags.includes(tagId)) {
                                                    selectedTags = selectedTags.filter(id => id !== tagId);
                                                    tagCard.classList.remove('selected-tag');
                                                } else {
                                                    selectedTags.push(tagId);
                                                    tagCard.classList.add('selected-tag');
                                                }
                                                selectedTagsInput.value = selectedTags.join(',');
                                            });

                                            tagsContainer.appendChild(tagCard);
                                        });
                                    })
                                    .catch(error => console.error('Error fetching tags:', error));
                            }
                        });
                    </script>
                </div>
                <div>
                    <div>
                        <label for="categories"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select a
                            Category</label>
                        <select id="categories" name="category_id"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option selected disabled>Choose a category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ $category->id == $artwork->category_id ? 'selected' : '' }}>
                                    {{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="w-full mt-4">
                        <label for="tags" class="block mb-2 text-cm">Select Tags</label>
                        <div id="tags-container" class="flex flex-wrap gap-4">
                            <!-- Tags will be populated by AJAX -->
                        </div>
                        <input type="hidden" id="selected-tags" name="tags[]"
                            value="{{ implode(',', $artwork->tags->pluck('id')->toArray()) }}">
                    </div>
                    <div class="mt-6">
                        <h2>Media</h2>
                        <p class="text-sm mb-1">A maximum of 5MB per file.</p>
                    </div>
                    <div class="flex items-center justify-center w-full">
                        @if ($errors->any())
                            <div class="text-red-500">
                                @foreach ($errors->all() as $error)
                                    <p>{{ $error }}</p>
                                @endforeach
                            </div>
                        @endif

                        <label for="dropzone-file"
                            class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                            <div id="dropzone-preview" class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="#9c9c9c" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-image-up">
                                    <path
                                        d="M10.3 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v10l-3.1-3.1a2 2 0 0 0-2.814.014L6 21" />
                                    <path d="m14 19.5 3-3 3 3" />
                                    <path d="M17 22v-5.5" />
                                    <circle cx="9" cy="9" r="2" />
                                </svg>
                                <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span
                                        class="font-semibold">Click to upload</span> or drag and drop</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">PNG, JPG, GIF, or SVG (MAX.
                                    800x400px)</p>
                            </div>
                            <input id="dropzone-file" type="file" class="hidden" name="thumbnails[]"
                                accept="image/*" multiple onchange="updateFilePreview()" />
                        </label>
                    </div>
                    <div id="file-preview" class="mt-4 grid grid-cols-3 gap-4">
                        @foreach ($artwork->images as $thumbnail)
                            <img src="{{ asset('storage/' . $thumbnail->attachment->path) }}"
                                class="w-32 h-32 object-cover rounded-lg border border-gray-300">
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="mt-6">
                <x-primary-button class="justify-center py-4 w-[200px] text-md">
                    {{ __('Update Artwork') }}
                </x-primary-button>
            </div>
        </form>
    </div>

    <div id="success-message"
        class="hidden z-100 fixed top-0 left-0 w-full h-full flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <p class="text-lg font-semibold">artwork updated successfully</p>
        </div>
    </div>

    <script>
        document.getElementById('artwork-form').addEventListener('submit', function(event) {
            event.preventDefault();
            const form = this;
            const successMessage = document.getElementById('success-message');
            successMessage.classList.remove('hidden');
            setTimeout(function() {
                form.submit();
            }, 2000);
        });

        function updateFilePreview() {
            const fileInput = document.getElementById('dropzone-file');
            const previewContainer = document.getElementById('file-preview');
            previewContainer.innerHTML = '';

            Array.from(fileInput.files).forEach(file => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.classList.add('w-32', 'h-32', 'object-cover', 'rounded-lg', 'border',
                    'border-gray-300');
                    previewContainer.appendChild(img);
                };
                reader.readAsDataURL(file);
            });
        }
    </script>
    <style>
        .selected-tag {
            border-color: #3b82f6 !important;
            /* Tailwind blue-500 */
        }
    </style>
</x-artist-layout>
