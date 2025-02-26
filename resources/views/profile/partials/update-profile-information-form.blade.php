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
                <x-input-label for="phone" :value="__('Phone')" />
                <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $user->phone)" required autocomplete="phone" />
                <x-input-error class="mt-2" :messages="$errors->get('phone')" />
            </div>
        </div>

        <!-- Right Column: Profile & Cover Image -->
        <div class="space-y-4">
            <!-- Profile Image Upload -->
            <div class="space-y-2">
                <x-input-label for="profile_image" :value="__('Profile Image')" />
                <div class="relative flex flex-col items-center justify-center w-32 h-32 rounded-full border-2 border-dashed border-gray-300 hover:border-blue-500 cursor-pointer" onclick="document.getElementById('profile_image').click()">
                    <img id="profile-image-preview" src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : '' }}" alt="Profile Image"
                        class="w-full h-full object-cover rounded-full hidden">
                    <div id="profile-placeholder" class="absolute flex flex-col items-center text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-image-up">
                            <path d="M10.3 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v10l-3.1-3.1a2 2 0 0 0-2.814.014L6 21" />
                            <path d="m14 19.5 3-3 3 3" />
                            <path d="M17 22v-5.5" />
                            <circle cx="9" cy="9" r="2" />
                        </svg>
                        <span class="text-xs">Upload Image</span>
                    </div>
                </div>
                <input id="profile_image" name="profile_image" type="file" class="hidden" accept="image/*" onchange="previewImage(event, 'profile-image-preview', 'profile-placeholder')" />
                <x-input-error class="mt-2" :messages="$errors->get('profile_image')" />
            </div>

            <!-- Cover Image Upload -->
            <div class="space-y-2">
                <x-input-label for="cover_image" :value="__('Cover Image')" />
                <div class="relative w-full h-32 bg-gray-100 border-2 border-dashed border-gray-300 hover:border-blue-500 rounded-lg flex items-center justify-center cursor-pointer" onclick="document.getElementById('cover_image').click()">
                    <img id="cover-image-preview" src="{{ $user->cover_image ? asset('storage/' . $user->cover_image) : '' }}" alt="Cover Image"
                        class="w-full h-full object-cover rounded-lg hidden">
                    <div id="cover-placeholder" class="absolute flex flex-col items-center text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-image-up">
                            <path d="M10.3 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v10l-3.1-3.1a2 2 0 0 0-2.814.014L6 21" />
                            <path d="m14 19.5 3-3 3 3" />
                            <path d="M17 22v-5.5" />
                            <circle cx="9" cy="9" r="2" />
                        </svg>
                        <span class="text-xs">Upload Cover</span>
                    </div>
                </div>
                <input id="cover_image" name="cover_image" type="file" class="hidden" accept="image/*" onchange="previewImage(event, 'cover-image-preview', 'cover-placeholder')" />
                <x-input-error class="mt-2" :messages="$errors->get('cover_image')" />
            </div>

            <!-- Image Preview Script -->
            <script>
                function previewImage(event, previewId, placeholderId) {
                    var reader = new FileReader();
                    reader.onload = function() {
                        var img = document.getElementById(previewId);
                        var placeholder = document.getElementById(placeholderId);
                        img.src = reader.result;
                        img.classList.remove('hidden');
                        placeholder.classList.add('hidden');
                    };
                    reader.readAsDataURL(event.target.files[0]);
                }
            </script>


            <!-- Save Button -->
            <div class="col-span-2 flex justify-end mt-4">
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
</section>