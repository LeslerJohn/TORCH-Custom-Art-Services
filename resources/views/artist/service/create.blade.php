<x-artist-layout>
    <div class="flex flex-col md:flex-row justify-between pt-16">
        <h1 class="text-2lg text-bold text-black-500">Add Service</h1>
        <a href="{{ route('artist.service.index') }}" class="mt-4 md:mt-0">
            <x-secondary-button class="justify-center py-1 w-20 text-md hover:border-blue-500">
                Back
            </x-secondary-button>
        </a>
    </div>
    <div class="mt-2">
        <form id="artwork-form" action="{{ route('artist.service.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="flex flex-col lg:flex-row gap-16">
                <div class="flex flex-col w-full lg:w-[400px]">
                    <div>
                        <label for="categories" class="block mb-2 text-md font-medium text-gray-900 dark:text-white">Select a Category</label>
                        <select id="categories" name="category_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                            <option selected disabled>Choose a category</option>
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                    </div>

                    <div class="w-full mt-4">
                        <label for="tags" class="block mb-2 text-cm">Select Tags</label>
                        <div id="tags-container" class="flex flex-wrap gap-4"></div>
                        <input type="hidden" id="selected-tags" name="tags[]" value="" required>
                        <x-input-error :messages="$errors->get('tags')" class="mt-2" />
                    </div>

                    <div class="mt-6">
                        <x-input-label for="price_rate" class="text-sm" :value="__('Price per square inch')" />
                        <div class="flex">
                            <x-text-input id="price_rate" class="block mt-1 w-full" type="number" name="price_rate" required placeholder="Set base price per cm." value="{{ old('price_rate') }}" />
                            <button data-tooltip-target="tooltip-price" type="button" class="ml-4"><svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 13V8m0 8h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('price_rate')" class="mt-2" />
                    </div>

                    <div id="tooltip-price" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-black transition-opacity duration-300 bg-gray-300 rounded-lg shadow-xs opacity-0 tooltip">
                        <p class="text-sm">Your base price will be used in the system's calculators framework width x height x base price.</p>
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>

                    <div id="tooltip-rush-price" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-black transition-opacity duration-300 bg-gray-300 rounded-lg shadow-xs opacity-0 tooltip">
                        <p class="text-sm">Rush base price is applied when the client makes a rush order.</p>
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>
                    <div class="mt-6">
                        <x-input-label for="rush_price_rate" class="text-sm" :value="__('Rush price per square inch')" />
                        <div class="flex">
                            <x-text-input id="rush_price_rate" class="block mt-1 w-full" type="number" name="rush_price_rate" required placeholder="Set base price for rush order." value="{{ old('rush_price_rate') }}" />
                            <button data-tooltip-target="tooltip-rush-price" type="button" class="ml-4"><svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 13V8m0 8h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('rush_price_rate')" class="mt-2" />
                    </div>

                    <div id="tooltip-animation" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-black transition-opacity duration-300 bg-gray-300 rounded-lg shadow-xs opacity-0 tooltip">
                        <p class="text-sm">A grace period of 5 days will be automatically added.</p>
                        <p class="text-sm">By going over your normal deadline a 3% charge will be deducted to your earning each day.</p>
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>
                    <div class="mt-6">
                        <x-input-label for="normal_timeframe" class="text-sm" :value="__('Normal Timeframe (days)')" />
                        <div class="flex">
                            <x-text-input id="normal_timeframe" class="block mt-1 w-full" type="number" name="normal_timeframe" required placeholder="No. of days completion." value="{{ old('normal_timeframe') }}" />
                            <button data-tooltip-target="tooltip-animation" type="button" class="ml-4"><svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 13V8m0 8h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('normal_timeframe')" class="mt-2" />
                    </div>

                    <div class="mt-6">
                        <x-input-label for="rush_timeframe" class="text-sm" :value="__('Rush Timeframe (days)')" />
                        <x-text-input id="rush_timeframe" class="block mt-1 w-full" type="number" name="rush_timeframe" required placeholder="No. of days completion." value="{{ old('rush_timeframe') }}" />
                        <x-input-error :messages="$errors->get('rush_timeframe')" class="mt-2" />
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const normalTimeframeInput = document.getElementById('normal_timeframe');
                            const rushTimeframeInput = document.getElementById('rush_timeframe');

                            rushTimeframeInput.addEventListener('input', function() {
                                const normalTimeframe = parseInt(normalTimeframeInput.value);
                                const rushTimeframe = parseInt(this.value);

                                if (rushTimeframe >= normalTimeframe) {
                                    this.setCustomValidity('Rush timeframe must be less than normal timeframe.');
                                } else {
                                    this.setCustomValidity('');
                                }
                            });

                            normalTimeframeInput.addEventListener('input', function() {
                                const normalTimeframe = parseInt(this.value);
                                const rushTimeframe = parseInt(rushTimeframeInput.value);

                                if (rushTimeframe >= normalTimeframe) {
                                    rushTimeframeInput.setCustomValidity('Rush timeframe must be less than normal timeframe.');
                                } else {
                                    rushTimeframeInput.setCustomValidity('');
                                }
                            });
                        });
                    </script>

                    <script>
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
                                            tagCard.classList.add('tag-card', 'border-2', 'border-gray-300', 'text-sm', 'rounded-lg', 'p-2', 'cursor-pointer', 'w-32', 'text-center');
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

                            document.getElementById('artwork-form').addEventListener('submit', function(event) {
                                if (!categorySelect.value || selectedTags.length === 0) {
                                    event.preventDefault();
                                    alert('Please select a category and at least one tag.');
                                }
                            });
                        });
                    </script>
                </div>

                <div class="flex flex-col w-full lg:w-auto">
                    <div>
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
                            <input id="dropzone-file" required type="file" class="hidden" name="thumbnails[]" accept="image/*"
                                multiple />
                        </label>
                        <x-input-error :messages="$errors->get('thumbnails')" class="mt-2" />
                    </div>
                    <div id="file-preview" class="mt-4 grid grid-cols-3 gap-4 hidden"></div>
                </div>

                <script>
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
                                    imgElement.classList.add('w-32', 'h-32', 'object-cover', 'rounded-lg', 'border',
                                        'border-gray-300');
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
            </div>
            <div class="mt-6">
                <x-primary-button class="justify-center py-4 w-full lg:w-[200px] text-md">
                    {{ __('Add Service') }}
                </x-primary-button>
            </div>
        </form>
    </div>

    <div id="success-message" class="hidden z-50 fixed top-0 left-0 w-full h-full flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white p-6 rounded-lg shadow-lg flex items-center">
            <svg class="animate-spin h-5 w-5 mr-3 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <p class="text-lg font-semibold">Creating service...</p>
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
            }, 2000); // Show the message for 2 seconds before redirecting
        });
    </script>
    <style>
        .selected-tag {
            border-color: #3b82f6 !important;
            /* Tailwind blue-500 */
        }
    </style>
</x-artist-layout>