<x-static-layout>
    <main >
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
            <div class="mt-20 text-center">
                <h2 class="text-5xl font-bold text-orange-500 drop-shadow-md">Meet the Team</h2>
                <p class="text-lg text-gray-600 mt-4 max-w-2xl mx-auto">
                    A passionate team dedicated to making TORCH the best platform for artists and clients alike.
                </p>

                <div class="mt-12 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-10">
                    <!-- Team Member 1 -->
                    <div class="bg-white rounded-lg shadow-lg p-6 flex flex-col items-center text-center transform hover:scale-105 transition-all duration-300">
                        <img src="{{ asset('images/team1.jpg') }}" alt="Alex Flame" 
                            class="w-24 h-24 rounded-full border-4 border-orange-500">
                        <p class="text-xl font-semibold mt-4 text-gray-800">Alex Flame</p>
                        <p class="text-md text-orange-500">Founder & CEO</p>
                        <p class="text-sm text-gray-600 mt-4">
                            Passionate about bridging the gap between artists and clients. Focused on innovation and fairness in the art world.
                        </p>
                    </div>

                    <!-- Team Member 2 -->
                    <div class="bg-white rounded-lg shadow-lg p-6 flex flex-col items-center text-center transform hover:scale-105 transition-all duration-300">
                        <img src="{{ asset('images/team2.jpg') }}" alt="Samantha Sketch" 
                            class="w-24 h-24 rounded-full border-4 border-orange-500">
                        <p class="text-xl font-semibold mt-4 text-gray-800">Samantha Sketch</p>
                        <p class="text-md text-orange-500">Head of Artist Relations</p>
                        <p class="text-sm text-gray-600 mt-4">
                            Dedicated to ensuring artists receive fair pay and proper recognition for their work.
                        </p>
                    </div>

                    <!-- Team Member 3 -->
                    <div class="bg-white rounded-lg shadow-lg p-6 flex flex-col items-center text-center transform hover:scale-105 transition-all duration-300">
                        <img src="{{ asset('images/team3.jpg') }}" alt="Danny Design" 
                            class="w-24 h-24 rounded-full border-4 border-orange-500">
                        <p class="text-xl font-semibold mt-4 text-gray-800">Danny Design</p>
                        <p class="text-md text-orange-500">Lead Developer</p>
                        <p class="text-sm text-gray-600 mt-4">
                            Focused on building a seamless, user-friendly platform that enhances the art commission process.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-static-layout>
