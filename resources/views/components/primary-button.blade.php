<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-[#E57C2C] border border-transparent rounded-md font-semibold text-white tracking-widest hover:bg-[#E57C2C] focus:bg-[#E57C2C] active:bg-[#E57C2C] focus:outline-none focus:ring-2 focus:ring-[#E57C2C] focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
