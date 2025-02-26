@props(['active'])

@php
    $classes =
        $active ?? false
            ? 'border-2 rounded-lg inline-flex items-center px-3 py-2 bg-indigo-700 text-white text-sm font-medium leading-5  focus:outline-nonetransition duration-150 ease-in-out'
            : 'inline-flex items-center px-2 py-1 border border-gray-300 rounded-md text-sm font-medium leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
