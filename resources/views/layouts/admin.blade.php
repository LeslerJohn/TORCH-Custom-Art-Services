<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen grid grid-rows-[auto_1fr] grid-cols-[20%_1fr] overflow-hidden">
        <header class="bg-white dark:bg-gray-800 shadow col-span-2">
            @include('layouts.admin-navigation')
            @isset($header)
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            @endisset
        </header>
        <aside class="bg-gray-100 dark:bg-gray-900 overflow-y-auto mt-16">
            @include('layouts.admin-sidebar')
        </aside>
        <main class="bg-gray-100 dark:bg-gray-800 p-6 overflow-y-auto mt-16">
            {{ $slot }}
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-annotation"></script>
    @stack('scripts')
</body>

</html>
