<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-blue-500 border border-pastel-purple rounded-md font-semibold text-xs text-pastel-purple uppercase tracking-widest hover:bg-blue-600 hover:text-pastel-blue focus:bg-blue-600 focus:text-pastel-blue active:bg-pastel-yellow focus:outline-none focus:ring-2 focus:ring-pastel-purple focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
