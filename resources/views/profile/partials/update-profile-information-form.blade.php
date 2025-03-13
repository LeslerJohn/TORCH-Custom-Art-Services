<section class="bg-white p-6 shadow-md rounded-lg">
    <header class="mb-6">
        <h2 class="text-xl font-semibold text-gray-900">
            {{ __('Profile Information') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="grid grid-cols-1 md:grid-cols-2 gap-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <!-- Left Column: Profile Details -->
        <div class="space-y-4">
            <div>
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2 text-sm text-gray-800">
                    <p>{{ __('Your email address is unverified.') }}</p>
                    <button form="send-verification" class="underline text-blue-600 hover:text-blue-800">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>

                    @if (session('status') === 'verification-link-sent')
                    <p class="mt-2 text-green-600 font-medium">
                        {{ __('A new verification link has been sent to your email address.') }}
                    </p>
                    @endif
                </div>
                @endif
            </div>

            <div>
                <x-input-label for="phone_number" :value="__('Phone Number')" />
                <div class="flex">
                    <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">+63</span>
                    <x-text-input id="phone_number" name="phone_number" type="text" class="mt-1 block w-full rounded-l-none" :value="old('phone_number', $user->phone_number)" required autocomplete="phone_number" />
                </div>
                <x-input-error class="mt-2" :messages="$errors->get('phone_number')" />
            </div>
        </div>

        <!-- Right Column: Profile Image -->
        <div class="space-y-4">
            <!-- Profile Image Upload -->
            <div class="space-y-2">
                <x-input-label for="profile_image" :value="__('Profile Image')" />
                <div class="relative flex flex-col items-center justify-center w-60 h-60 rounded-full border-2 border-dashed border-gray-300 hover:border-blue-500 cursor-pointer group" onclick="document.getElementById('profile_image').click()">
                    <!-- Profile Image Preview -->
                    <img id="profile-image-preview"
                        src="{{ Auth::user()->profileImage ? asset('storage/' . Auth::user()->profileImage->path) : '' }}"
                        alt="Profile Image"
                        class="w-full h-full object-cover rounded-full {{ Auth::user()->profileImage ? '' : 'hidden' }}">

                    <!-- Profile Image Placeholder -->
                    <div id="profile-placeholder" class="absolute flex flex-col items-center text-gray-400 {{ Auth::user()->profileImage ? 'hidden' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-image-up">
                            <path d="M10.3 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v10l-3.1-3.1a2 2 0 0 0-2.814.014L6 21" />
                            <path d="m14 19.5 3-3 3 3" />
                            <path d="M17 22v-5.5" />
                            <circle cx="9" cy="9" r="2" />
                        </svg>
                        <span class="text-xs">Upload Image</span>
                    </div>

                    <!-- Hover Overlay -->
                    <div id="profile-hover-overlay" class="absolute inset-0 bg-black bg-opacity-50 rounded-full flex items-center justify-center space-x-2 opacity-0 group-hover:opacity-100 transition-opacity {{ Auth::user()->profileImage ? '' : 'hidden' }}">
                        <!-- Upload New Button -->
                        <button type="button" class="p-2 text-blue-500 hover:text-blue-600" onclick="event.stopPropagation(); document.getElementById('profile_image').click()">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-pen">
                                <path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                <path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z" />
                            </svg>
                        </button>

                        <!-- Remove Button -->
                        <button type="button" class="p-2 text-red-500 hover:text-red-600" onclick="event.stopPropagation(); removeImage('profile-image-preview', 'profile-placeholder', 'profile_image', 'remove_profile_image')">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash">
                                <path d="M3 6h18" />
                                <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                                <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                            </svg>
                        </button>
                    </div>
                </div>
                <input id="profile_image" name="profile_image" type="file" class="hidden" accept="image/*" onchange="previewImage(event, 'profile-image-preview', 'profile-placeholder')" />
                <!-- Hidden input to indicate image removal -->
                <input type="hidden" id="remove_profile_image" name="remove_profile_image" value="0" />
                <x-input-error class="mt-2" :messages="$errors->get('profile_image')" />
            </div>
        </div>

        <!-- Cover Image Upload (Placed at the bottom of both columns) -->
        <div class="col-span-1 md:col-span-2">
            <div class="space-y-2">
                <x-input-label for="cover_image" :value="__('Cover Image')" />
                <div class="relative w-full h-47 bg-gray-100 border-2 border-dashed border-gray-300 hover:border-blue-500 rounded-lg flex items-center justify-center cursor-pointer group" onclick="document.getElementById('cover_image').click()">
                    <!-- Cover Image Preview -->
                    <img id="cover-image-preview"
                        src="{{ Auth::user()->coverImage ? asset('storage/' . Auth::user()->coverImage->path) : '' }}"
                        alt="Cover Image"
                        class="w-full h-full object-cover rounded-lg {{ Auth::user()->coverImage ? '' : 'hidden' }}">

                    <!-- Cover Image Placeholder -->
                    <div id="cover-placeholder" class="absolute flex flex-col items-center text-gray-400 {{ Auth::user()->coverImage ? 'hidden' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-image-up">
                            <path d="M10.3 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v10l-3.1-3.1a2 2 0 0 0-2.814.014L6 21" />
                            <path d="m14 19.5 3-3 3 3" />
                            <path d="M17 22v-5.5" />
                            <circle cx="9" cy="9" r="2" />
                        </svg>
                        <span class="text-xs">Upload Cover</span>
                    </div>

                    <!-- Hover Overlay -->
                    <div id="cover-hover-overlay" class="absolute inset-0 bg-black bg-opacity-50 rounded-lg flex items-center justify-center space-x-2 opacity-0 group-hover:opacity-100 transition-opacity {{ Auth::user()->coverImage ? '' : 'hidden' }}">
                        <!-- Upload New Button -->
                        <button type="button" class="p-2 text-blue-500 hover:text-blue-600" onclick="event.stopPropagation(); document.getElementById('cover_image').click()">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-pen">
                                <path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                <path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z" />
                            </svg>
                        </button>

                        <!-- Remove Button -->
                        <button type="button" class="p-2 text-red-500 hover:text-red-600" onclick="event.stopPropagation(); removeImage('cover-image-preview', 'cover-placeholder', 'cover_image', 'remove_cover_image')">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash">
                                <path d="M3 6h18" />
                                <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                                <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                            </svg>
                        </button>
                    </div>
                </div>
                <input id="cover_image" name="cover_image" type="file" class="hidden" accept="image/*" onchange="previewImage(event, 'cover-image-preview', 'cover-placeholder')" />
                <!-- Hidden input to indicate image removal -->
                <input type="hidden" id="remove_cover_image" name="remove_cover_image" value="0" />
                <x-input-error class="mt-2" :messages="$errors->get('cover_image')" />
            </div>
        </div>

        <!-- Save Button -->
        <div class="col-span-1 md:col-span-2 flex justify-end mt-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
            <p
                x-data="{ show: true }"
                x-show="show"
                x-transition
                x-init="setTimeout(() => show = false, 2000)"
                class="text-sm text-green-600 ml-4">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>

    <!-- Image Preview and Remove Script -->
    <script>
        function previewImage(event, previewId, placeholderId) {
            const file = event.target.files[0];
            const preview = document.getElementById(previewId);
            const placeholder = document.getElementById(placeholderId);
            const hoverOverlay = document.getElementById(`${previewId.split('-')[0]}-hover-overlay`);

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                    hoverOverlay.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        }

        function removeImage(previewId, placeholderId, inputId, removeInputId) {
            const preview = document.getElementById(previewId);
            const placeholder = document.getElementById(placeholderId);
            const input = document.getElementById(inputId);
            const removeInput = document.getElementById(removeInputId);
            const hoverOverlay = document.getElementById(`${previewId.split('-')[0]}-hover-overlay`);

            // Clear the preview and show the placeholder
            preview.src = '';
            preview.classList.add('hidden');
            placeholder.classList.remove('hidden');

            // Clear the file input
            input.value = '';

            // Set the remove flag to 1
            removeInput.value = '1';

            // Hide the hover overlay
            hoverOverlay.classList.add('hidden');
        }
    </script>
</section>