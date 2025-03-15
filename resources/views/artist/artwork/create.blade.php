<x-artist-layout>
    <div class="pt-16 px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h1 class="text-xl sm:text-2xl font-bold text-gray-800">Add Artwork</h1>
            <a href="{{ route('artist.artwork.index') }}">
                <x-secondary-button class="w-full sm:w-auto justify-center py-2 sm:py-1 text-sm sm:text-md hover:border-blue-500">
                    Back
                </x-secondary-button>
            </a>
        </div>

        <!-- Form Section -->
        <form id="artwork-form" action="{{ route('artist.artwork.store') }}" method="POST" enctype="multipart/form-data" class="mt-6">
            @csrf
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Left Column -->
                <div class="w-full lg:w-[800px]">
                    <!-- Title -->
                    <div>
                        <x-input-label for="title" class="text-sm" :value="__('Title')" />
                        <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" required autofocus placeholder="Enter the title of your artwork." />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <!-- Description -->
                    <div class="mt-6">
                        <x-input-label for="description" class="text-sm" :value="__('Description')" />
                        <textarea id="description" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm" name="description" required placeholder="Provide a detailed description of your artwork." rows="4"></textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <!-- Dimensions -->
                    <div class="mt-6" x-data="{ width: '', height: '', unit: 'cm' }">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="width" :value="__('Width')" />
                                <div class="flex">
                                    <x-text-input id="width" class="block w-full" type="number" name="width" x-model="width" min="1" required />
                                    <select class="ml-2 border-gray-300 rounded-md" x-model="unit" name="unit">
                                        <option value="cm">cm</option>
                                        <option value="in">inches</option>
                                    </select>
                                </div>
                                <small class="text-gray-500">Enter the width of your artwork.</small>
                            </div>

                            <div>
                                <x-input-label for="height" :value="__('Height')" />
                                <div class="flex">
                                    <x-text-input id="height" class="block w-full" type="number" name="height" x-model="height" min="1" required />
                                    <select class="ml-2 border-gray-300 rounded-md" x-model="unit" name="unit" disabled>
                                        <option value="cm">cm</option>
                                        <option value="in">inches</option>
                                    </select>
                                </div>
                                <small class="text-gray-500">Enter the height of your artwork.</small>
                            </div>
                        </div>
                    </div>
                    <div id="tooltip-price" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-black transition-opacity duration-300 bg-gray-300 rounded-lg shadow-xs opacity-0 tooltip">
                        <p class="text-sm">This is a fixed price for your artwork.</p>
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>
                    <div class="mt-6">
                        <x-input-label for="price" class="text-sm" :value="__('Price')" />
                        <div class="flex">
                            <x-text-input id="price" class="block mt-1 w-full" type="number" name="price" required placeholder="Set the price for your artwork." />
                            <button data-tooltip-target="tooltip-price" type="button" class="ml-4">
                                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 13V8m0 8h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                </svg>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('price')" class="mt-2" />
                    </div>

                    <!-- Showcase Toggle -->
                    <label class="inline-flex items-center cursor-pointer mt-6">
                        <input type="checkbox" value="1" name="is_showcase" class="sr-only peer">
                        <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        <span class="ms-3 text-sm font-medium text-gray-900">Showcase this Artwork</span>
                    </label>
                </div>

                <!-- Right Column -->
                <div class="w-full">
                    <!-- Category Selection -->
                    <div>
                        <label for="categories" class="block mb-2 text-sm font-medium text-gray-900">Select a Category</label>
                        <select id="categories" name="category_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            <option selected disabled>Choose a category</option>
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Tags Selection -->
                    <div class="mt-6">
                        <label for="tags" class="block mb-2 text-sm">Select Tags</label>
                        <div id="tags-container" class="flex flex-wrap gap-2"></div>
                        <input type="hidden" id="selected-tags" name="tags[]" value="">
                    </div>

                    <!-- Media Upload -->
                    <div class="mt-6">
                        <h2 class="text-lg font-semibold">Media</h2>
                        <p class="text-sm mb-4">A maximum of 5MB per file.</p>
                        <div class="flex items-center justify-center w-full">
                            <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                                <div id="dropzone-preview" class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#9c9c9c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-image-up">
                                        <path d="M10.3 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v10l-3.1-3.1a2 2 0 0 0-2.814.014L6 21" />
                                        <path d="m14 19.5 3-3 3 3" />
                                        <path d="M17 22v-5.5" />
                                        <circle cx="9" cy="9" r="2" />
                                    </svg>
                                    <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                    <p class="text-xs text-gray-500">PNG, JPG, GIF, or SVG (MAX. 800x400px)</p>
                                </div>
                                <input id="dropzone-file" required type="file" class="hidden" name="thumbnails[]" accept="image/*" multiple />
                            </label>
                        </div>
                        <div id="file-preview" class="mt-4 grid grid-cols-2 sm:grid-cols-3 gap-4 hidden"></div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="mt-6">
                <x-primary-button class="w-full sm:w-auto justify-center py-3 text-sm sm:text-md">
                    {{ __('Add artwork') }}
                </x-primary-button>
            </div>
        </form>
    </div>

    <!-- Success Message -->
    <div id="success-message" class="hidden fixed top-0 left-0 w-full h-full flex items-center justify-center bg-black bg-opacity-50 z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <p class="text-lg font-semibold">Artwork created successfully</p>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        document.getElementById('artwork-form').addEventListener('submit', function(event) {
            event.preventDefault();
            const form = this;
            const successMessage = document.getElementById('success-message');
            successMessage.classList.remove('hidden');
            setTimeout(function() {
                form.submit();
            }, 2000); // Show the message for 2 seconds before redirecting
        });

        // Tags Selection Script
        document.addEventListener('DOMContentLoaded', function() {
            const categorySelect = document.getElementById('categories');
            const tagsContainer = document.getElementById('tags-container');
            const selectedTagsInput = document.getElementById('selected-tags');
            let selectedTags = [];

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
                            tagCard.classList.add('tag-card', 'border-2', 'border-gray-300', 'text-sm', 'rounded-lg', 'p-2', 'cursor-pointer', 'w-full', 'sm:w-32', 'text-center');
                            tagCard.setAttribute('data-tag-id', tag.id);
                            tagCard.textContent = tag.name;

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
            });
        });

        // File Upload Preview Script
        const fileInput = document.getElementById('dropzone-file');
        const previewContainer = document.getElementById('file-preview');

        fileInput.addEventListener('change', (event) => {
            previewContainer.innerHTML = ''; // Clear previous previews
            const files = event.target.files;
            if (files.length > 0) {
                previewContainer.classList.remove('hidden');
                Array.from(files).forEach(file => {
                    const reader = new FileReader();
                    reader.onload = () => {
                        const imgElement = document.createElement('img');
                        imgElement.src = reader.result;
                        imgElement.classList.add('w-full', 'h-32', 'sm:w-32', 'sm:h-32', 'object-cover', 'rounded-lg', 'border', 'border-gray-300');
                        previewContainer.appendChild(imgElement);
                    };
                    reader.readAsDataURL(file);
                });
            }
        });

        // Drag-and-drop functionality
        const dropzone = document.querySelector('label[for="dropzone-file"]');
        dropzone.addEventListener('dragover', (event) => {
            event.preventDefault();
            dropzone.classList.add('border-blue-500');
        });

        dropzone.addEventListener('dragleave', () => {
            dropzone.classList.remove('border-blue-500');
        });

        dropzone.addEventListener('drop', (event) => {
            event.preventDefault();
            dropzone.classList.remove('border-blue-500');

            const files = event.dataTransfer.files;
            if (files.length > 0) {
                fileInput.files = files;
                fileInput.dispatchEvent(new Event('change')); // Trigger change event
            }
        });
    </script>

    <!-- Styles -->
    <style>
        .selected-tag {
            border-color: #3b82f6 !important;
            /* Tailwind blue-500 */
        }
    </style>
</x-artist-layout>