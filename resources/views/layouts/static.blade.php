<x-app-layout>
    <main class="bg-gradient-to-r from-white to-orange-100">
        <section class="p-8">
            {{ $slot }}
        </section>
        @include('layouts.footer')
    </main>
</x-app-layout>
