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
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">


    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen flex">
        <aside class="bg-gray-100 dark:bg-gray-900 w-1/5 fixed h-full overflow-y-auto">
            @include('layouts.admin-sidebar')
        </aside>
        <div class="flex-1 ml-[20%]">
            <header class="bg-white dark:bg-gray-800 shadow w-full fixed top-0 left-0 z-10">
                @include('layouts.admin-navigation')
                @isset($header)
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                @endisset
            </header>
            <main class="bg-gray-100 dark:bg-gray-800 p-6 mt-16 overflow-y-auto h-screen">
                {{ $slot }}
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-annotation"></script>
    @stack('scripts')
</body>

</html>
