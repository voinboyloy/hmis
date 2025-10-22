<button {{ $attributes->merge(['class' => 'btn bg-teal-500 text-white hover:bg-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-300']) }}>
    {{ $slot }}
</button>
