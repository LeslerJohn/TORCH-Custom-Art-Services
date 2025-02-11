<x-artist-layout>
    {{-- Dashboard Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 pt-16">
        {{-- Card: Statistics --}}
        <div
            class="bg-gradient-to-r from-orange-400 via-orange-500 to-orange-600 rounded-lg shadow-md p-6 flex flex-col items-center text-black">
            <i class="fas fa-chart-bar text-4xl mb-4 icon-gradient"></i>
            <h3 class="text-xl font-semibold mb-2">Statistics</h3>
            <p class="text-center mb-4">Check your performance and stats.</p>
            <button class="bg-orange-500 text-white rounded px-4 py-2 hover:bg-orange-600">View Stats</button>
        </div>
    </div>
</x-artist-layout>
