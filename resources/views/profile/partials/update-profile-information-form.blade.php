<section class="bg-white p-6 shadow-md rounded-lg">
    @if (session('status') === 'profile-updated')
    <p
        x-data="{ show: true }"
        x-show="show"
        x-transition
        x-init="setTimeout(() => show = false, 2000)"
        class="text-sm text-green-600 ml-4">{{ __('Saved.') }}</p>
    @endif
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
                    <x-text-input id="phone_number" name="phone_number" type="text" class="mt-1 block w-full rounded-l-none" :value="old('phone_number', $user->phone_number)" required autocomplete="phone_number" maxlength="10" />
                </div>
                <x-input-error class="mt-2" :messages="$errors->get('phone_number')" />
            </div>

            @if ($user->isArtist())
            <div>
                <x-input-label for="location" :value="__('Location')" />
                <x-text-input id="location" name="location" type="text" class="mt-1 block w-full" :value="old('location', $user->artist->location)" required autocomplete="location" />
                <x-input-error class="mt-2" :messages="$errors->get('location')" />
            </div>

            <!-- Birthdate -->
            <div class="w-full md:w-1/2 relative">
                <x-input-label for="birthdate" :value="__('Birthdate')" />
                <div class="absolute inset-y-0 top-6 start-0 flex justify-center items-center ps-3.5 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                    </svg>
                </div>
                <input id="datepicker-format" datepicker datepicker-max-date="{{ now()->format('m/d/Y') }}" name="birthdate" type="text" class="mt-1 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date" value="{{ old('birthdate', $user->artist->birthdate) }}">
            </div>

            <!-- Gender -->
            <div class="w-full md:w-1/2">
                <x-input-label for="gender" :value="__('Gender')" />
                <select id="gender" name="gender"
                    class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                    <option value="">{{ __('Select Gender') }}</option>
                    <option value="male" {{ old('gender', $user->artist->gender) == 'male' ? 'selected' : '' }}>{{ __('Male') }}</option>
                    <option value="female" {{ old('gender', $user->artist->gender) == 'female' ? 'selected' : '' }}>{{ __('Female') }}</option>
                    <option value="other" {{ old('gender', $user->artist->gender) == 'other' ? 'selected' : '' }}>{{ __('Other') }}</option>
                </select>
                <x-input-error :messages="$errors->get('gender')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="username" :value="__('Username')" />
                <x-text-input id="username" name="username" type="text" class="mt-1 block w-full" :value="old('username', $user->artist->username)" required autocomplete="username" />
                <x-input-error class="mt-2" :messages="$errors->get('username')" />
            </div>

            <div>
                <x-input-label for="max_commissions" :value="__('Max Commissions')" />
                <x-text-input id="max_commissions" name="max_commissions" type="number" class="mt-1 block w-full" :value="old('max_commissions', $user->artist->max_commissions)" required autocomplete="max_commissions" />
                <x-input-error class="mt-2" :messages="$errors->get('max_commissions')" />
            </div>

            <div>
                <x-input-label for="bio" :value="__('Bio')" />
                <textarea id="bio" name="bio" class="mt-1 block w-full" required>{{ old('bio', $user->artist->bio) }}</textarea>
                <x-input-error class="mt-2" :messages="$errors->get('bio')" />
            </div>
            @endif
        </div>

        <div class="flex flex-col gap-6">
            <!-- Profile Image -->
            <div class="w-full md:w-1/3 lg:w-1/4 space-y-4">
                <div class="space-y-2">
                    <x-input-label for="profile_image" :value="__('Profile Image')" />
                    <div class="relative flex flex-col items-center justify-center w-60 h-60 rounded-full border-2 border-dashed border-gray-300 hover:border-blue-500 cursor-pointer group" onclick="document.getElementById('profile_image').click()">
                        <!-- Profile Image Preview -->
                        <img id="profile-image-preview"
                            src="{{ Auth::user()->profileImage ? asset('storage/' . Auth::user()->profileImage->path) : '' }}"
                            alt="Profile Image"
                            class="w-full h-full object-cover rounded-full {{ Auth::user()->profileImage ? '' : 'hidden' }}">
                        <div id="profile-placeholder" class="absolute flex flex-col items-center text-gray-400 {{ Auth::user()->profileImage && Auth::user()->profileImage->path ? 'hidden' : '' }}">
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

            <!-- Cover Image -->
            <div class="w-full space-y-4">
                <div class="space-y-2">
                    <x-input-label for="cover_image" :value="__('Cover Image')" />
                    <div class="relative w-full h-48 md:h-64 bg-gray-100 border-2 border-dashed border-gray-300 hover:border-blue-500 rounded-lg flex items-center justify-center cursor-pointer group" onclick="document.getElementById('cover_image').click()">
                        <!-- Cover Image Preview -->
                        <img id="cover-image-preview"
                            src="{{ Auth::user()->coverImage ? asset('storage/' . Auth::user()->coverImage->path) : '' }}"
                            alt="Cover Image"
                            class="w-full h-full object-cover rounded-lg {{ Auth::user()->coverImage ? '' : 'hidden' }}">
                        <div id="cover-placeholder" class="absolute flex flex-col items-center text-gray-400 {{ Auth::user()->coverImage && Auth::user()->coverImage->path ? 'hidden' : '' }}">
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
        </div>

        <!-- Save Button -->
        <div class="col-span-1 md:col-span-2 flex justify-end mt-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

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