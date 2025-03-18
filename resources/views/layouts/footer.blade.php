<div class="flex flex-col sm:flex-row justify-between items-center max-w-6xl mx-auto sm:px-6 sm:mt-5 pb-4">
    <!-- Logo and Social Links -->
    <div class="flex flex-col justify-start items-center sm:items-start mb-6 sm:mb-0">
        <img src="{{ asset('images/torch-full-high-resolution-logo-transparent.png') }}" alt="Torch Logo" class="w-32">
        <p class="w-full sm:w-[320px] mt-4 text-center sm:text-left">Custom art commissions and premade artworks available.</p>
        <div class="flex justify-center sm:justify-start items-center gap-2 mt-6">
            <a href="#" class="hover:text-orange-600 transform hover:scale-110 transition duration-300">
                <img src="{{asset('images/facebook-svgrepo-com.svg')}}" alt="Facebook" class="w-8 h-8">
            </a>
            <a href="#" class="hover:text-orange-600 transform hover:scale-110 transition duration-300">
                <img src="{{asset('images/instagram-svgrepo-com.svg')}}" alt="Instagram" class="w-8 h-8">
            </a>
            <a href="#" class="hover:text-orange-600 transform hover:scale-110 transition duration-300">
                <img src="{{asset('images/linkedin-svgrepo-com.svg')}}" alt="LinkedIn" class="w-8 h-8">
            </a>
            <a href="#" class="hover:text-orange-600 transform hover:scale-110 transition duration-300">
                <img src="{{asset('images/twitter.png')}}" alt="Twitter" class="w-7 h-7">
            </a>
        </div>
        <p class="mt-8 text-center sm:text-left">&copy; 2025. All rights reserved.</p>
    </div>

    <!-- Company Links -->
    <div class="flex flex-col items-center sm:items-start gap-4 mb-6 sm:mb-0">
        <h2 class="font-bold">Company</h2>
        <a href="{{ route('about') }}" class="hover:text-orange-500">About us</a>
        <a href="{{ route('terms') }}" class="hover:text-orange-500">Terms of Service</a>
        <a href="{{ route('privacy') }}" class="hover:text-orange-500">Privacy Policy</a>
    </div>

    <!-- Support Section -->
    <div class="flex flex-col items-center sm:items-start">
        <h2 class="font-bold">Support</h2>
        <p class="text-sm text-gray-500 mt-2 w-full sm:w-[300px] text-center sm:text-left">Feel free to reach out to us with any questions or concerns you may have. We're here to help!</p>
        <button onclick="window.location.href='mailto:torchtech2024@gmail.com'" class="w-full sm:w-auto text-lg font-semibold mb-2 text-white py-2 px-4 rounded-full mt-4 bg-orange-500 hover:text-orange-600 hover:bg-white hover:border hover:border-orange-500 transform hover:scale-110 transition duration-300">
            Contact us
        </button>
    </div>
</div>