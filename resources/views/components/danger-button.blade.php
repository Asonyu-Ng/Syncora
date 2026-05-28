<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex h-11 items-center justify-center gap-2 rounded-xl bg-danger-600 px-5 text-sm font-semibold text-white shadow-soft transition-colors duration-150 hover:bg-danger-500 active:bg-danger-700 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-danger-500/25 focus-visible:ring-offset-2 focus-visible:ring-offset-white disabled:pointer-events-none disabled:opacity-50']) }}>
    {{ $slot }}
</button>
