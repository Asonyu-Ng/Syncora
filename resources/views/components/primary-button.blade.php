<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex h-11 items-center justify-center gap-2 rounded-xl bg-primary-600 px-5 text-sm font-semibold text-white shadow-soft transition-colors duration-150 hover:bg-primary-500 active:bg-primary-700 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-primary-500/25 focus-visible:ring-offset-2 focus-visible:ring-offset-white dark:focus-visible:ring-offset-neutral-950 disabled:pointer-events-none disabled:opacity-50']) }}>
    {{ $slot }}
</button>
