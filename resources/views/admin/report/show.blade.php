<x-admin-layout>
    <div>
        <div class="flex gap-4 items-center mb-6">
            <a href="{{ url()->previous() }}"
                class="text-blue-600 hover:text-blue-800 flex items-center transition duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                Back
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Report ID #123123</h1>
        </div>
        <div class="flex bg-white shadow-lg rounded-lg p-8 mb-8 gap-8">
            <div class="w-1/2">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 border-b pb-3">Report Details</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="flex flex-col">
                        <label class="text-gray-500 font-medium">Name</label>
                        <p class="text-gray-800 font-semibold">Jane Smith</p>
                    </div>
                    <div class="flex flex-col items-center">
                        <img src="{{ asset('images/profile.image.jpg') }}" alt="Profile"
                            class="w-20 h-20 rounded-full border-2 border-gray-300">
                    </div>
                    <div class="flex flex-col">
                        <label class="text-gray-500 font-medium">Email</label>
                        <p class="text-gray-800">jane.smith@example.com</p>
                    </div>
                    <div class="flex flex-col">
                        <label class="text-gray-500 font-medium">Status</label>
                        <p class="text-green-500 font-semibold">Active</p>
                    </div>
                    <div class="flex flex-col">
                        <label class="text-gray-500 font-medium">Reported By</label>
                        <p class="text-gray-800">John Doe</p>
                    </div>
                    <div class="flex flex-col">
                        <label class="text-gray-500 font-medium">Reason for Report</label>
                        <p class="text-gray-800">Violation of terms</p>
                    </div>
                    <div class="flex flex-col">
                        <label class="text-gray-500 font-medium">Contact Info</label>
                        <p class="text-gray-800">+1 234 567 890</p>
                    </div>
                    <div class="flex flex-col">
                        <label class="text-gray-500 font-medium">Report Date</label>
                        <p class="text-gray-800">12/31/2023</p>
                    </div>
                </div>
            </div>
            <div class="w-1/2">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 border-b pb-3">Attachments</h2>
                <div class="space-y-4">
                    <img src="{{ asset('images/default.image.jpg') }}" alt="Attachment Image"
                        class="rounded-lg shadow-md w-full h-auto">
                    <div class="flex flex-col mt-4">
                        <label class="text-gray-500 font-medium">Description</label>
                        <p class="text-gray-800 mt-2">The user is reporting a violation of terms as shown in the
                            attached image.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="flex mt-6 mb-16 gap-4">
        <div>
            @include('admin.report.partials.issue-form')
        </div>
        <div>
            @include('admin.report.partials.suspend-form')
        </div>
        <div>
            @include('admin.report.partials.close-form')
        </div>
    </div>
</x-admin-layout>
