<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-4 py-2 bg-pastel-yellow border border-pastel-orange rounded-md font-semibold text-xs text-pastel-orange uppercase tracking-widest shadow-sm hover:bg-pastel-orange hover:text-pastel-yellow focus:outline-none focus:ring-2 focus:ring-pastel-orange focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
