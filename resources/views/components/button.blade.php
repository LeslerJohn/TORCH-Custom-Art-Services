<button {{ $attributes->merge(['class' => 'px-4 py-2 font-semibold text-white bg-blue-500 rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75']) }}>
    {{ $slot }}
</button>
