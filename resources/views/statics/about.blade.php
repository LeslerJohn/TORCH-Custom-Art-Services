<x-static-layout>
    <main>
        <div class="max-w-6xl mx-auto px-6 lg:px-12 py-16">
            <!-- Title Section -->
            <div class="text-center">
                <h1 class="text-6xl font-extrabold text-orange-500 drop-shadow-md">About TORCH</h1>
                <p class="mt-4 text-xl text-gray-700 max-w-3xl mx-auto">
                    Welcome to TORCH, where creativity meets opportunity. Whether you're an artist looking for your next big commission
                    or someone searching for the perfect custom artwork, you've come to the right place.
                    We ignite the connection between artistic talent and those who appreciate it.
                </p>
            </div>

            <!-- Vision & Mission Section -->
            <div class="mt-16 grid grid-cols-1 md:grid-cols-2 gap-12">
                <div class="bg-white rounded-lg shadow-md p-8 text-center transform hover:scale-105 transition-all duration-300">
                    <h2 class="text-4xl font-bold text-orange-500">Our Vision</h2>
                    <p class="text-lg text-gray-600 mt-4">
                        We envision a world where art is for everyone—where creativity has no limits, and artists are valued for their unique talents.
                        TORCH is the ultimate hub for commissioning custom artwork, making the process fun, fair, and transparent.
                    </p>
                </div>

                <div class="bg-white rounded-lg shadow-md p-8 text-center transform hover:scale-105 transition-all duration-300">
                    <h2 class="text-4xl font-bold text-orange-500">Our Mission</h2>
                    <p class="text-lg text-gray-600 mt-4">
                        Our mission is to empower artists and provide clients with a seamless experience in commissioning custom art.
                        We prioritize fair pricing, secure payments, and transparent communication, ensuring a smooth process for everyone involved.
                    </p>
                </div>
            </div>

            <!-- Team Section -->
            <div class="py-20">
                <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                    <!-- Section Header -->
                    <div class="text-center">
                        <h2 class="text-4xl sm:text-5xl font-bold text-orange-500 drop-shadow-md">Meet the Team</h2>
                        <p class="text-lg text-gray-600 mt-4 max-w-2xl mx-auto">
                            A passionate team dedicated to making TORCH the best platform for artists and clients alike.
                        </p>
                    </div>

                    <!-- Team Members Grid -->
                    <div class="mt-12 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-8 justify-items-center">
                        <!-- Team Member 1 -->
                        <div class="bg-white rounded-lg shadow-lg p-6 flex flex-col items-center text-center transform hover:-translate-y-2 transition-all duration-300 w-full max-w-xs">
                            <img src="{{ asset('images/Screenshot 2025-03-19 044108.png') }}" alt="Daniela Marie Alpez"
                                class="w-32 h-32 rounded-full border-4 border-orange-500 object-cover">
                            <p class="text-xl font-semibold mt-4 text-gray-800">Daniela Marie Alpez</p>
                            <p class="text-md text-orange-500">Project Manager</p>
                            <p class="text-sm text-gray-600 mt-4">
                                Passionate about bridging the gap between artists and clients. Focused on innovation and fairness in the art world.
                            </p>
                        </div>

                        <!-- Team Member 2 -->
                        <div class="bg-white rounded-lg shadow-lg p-6 flex flex-col items-center text-center transform hover:-translate-y-2 transition-all duration-300 w-full max-w-xs">
                            <img src="{{ asset('images/Screenshot 2025-03-19 045051.png') }}" alt="Cyrus Bon Dimain"
                                class="w-32 h-32 rounded-full border-4 border-orange-500 object-cover">
                            <p class="text-xl font-semibold mt-4 text-gray-800">Cyrus Bon Dimain</p>
                            <p class="text-md text-orange-500">Head of Artist Relations / UI/UX</p>
                            <p class="text-sm text-gray-600 mt-4">
                                Dedicated to ensuring artists receive fair pay and proper recognition for their work.
                            </p>
                        </div>

                        <!-- Team Member 3 -->
                        <div class="bg-white rounded-lg shadow-lg p-6 flex flex-col items-center text-center transform hover:-translate-y-2 transition-all duration-300 w-full max-w-xs">
                            <img src="{{ asset('images/Screenshot 2025-03-19 045154.png') }}" alt="Lesler John Gantalao"
                                class="w-32 h-32 rounded-full border-4 border-orange-500 object-cover">
                            <p class="text-xl font-semibold mt-4 text-gray-800">Lesler John Gantalao</p>
                            <p class="text-md text-orange-500">Lead Developer</p>
                            <p class="text-sm text-gray-600 mt-4">
                                Focused on building a seamless, user-friendly platform that enhances the art commission process.
                            </p>
                        </div>

                        <!-- Team Member 4 -->
                        <div class="bg-white rounded-lg shadow-lg p-6 flex flex-col items-center text-center transform hover:-translate-y-2 transition-all duration-300 w-full max-w-xs">
                            <img src="{{ asset('images/Screenshot 2025-03-19 045245.png') }}" alt="Indira Ulah"
                                class="w-32 h-32 rounded-full border-4 border-orange-500 object-cover">
                            <p class="text-xl font-semibold mt-4 text-gray-800">Indira Ulah</p>
                            <p class="text-md text-orange-500">Quality Assurance</p>
                            <p class="text-sm text-gray-600 mt-4">
                                Ensuring the highest standards of quality and reliability in our platform.
                            </p>
                        </div>

                        <!-- Team Member 5 -->
                        <div class="bg-white rounded-lg shadow-lg p-6 flex flex-col items-center text-center transform hover:-translate-y-2 transition-all duration-300 w-full max-w-xs">
                            <img src="{{ asset('images/Screenshot 2025-03-19 045341.png') }}" alt="Sharmaine Ambula"
                                class="w-32 h-32 rounded-full border-4 border-orange-500 object-cover">
                            <p class="text-xl font-semibold mt-4 text-gray-800">Sharmaine Ambula</p>
                            <p class="text-md text-orange-500">Testing And Analytics</p>
                            <p class="text-sm text-gray-600 mt-4">
                                Specializes in testing and analytics to ensure a smooth and efficient user experience on our platform.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        </div>
    </main>
</x-static-layout>