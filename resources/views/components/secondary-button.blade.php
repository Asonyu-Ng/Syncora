<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex h-11 items-center justify-center gap-2 rounded-xl border border-neutral-200 bg-white px-5 text-sm font-semibold text-neutral-900 shadow-soft transition-colors duration-150 hover:bg-neutral-50 active:bg-neutral-100 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-primary-500/25 focus-visible:ring-offset-2 focus-visible:ring-offset-white disabled:pointer-events-none disabled:opacity-50']) }}>
    {{ $slot }}
</button>
