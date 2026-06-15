@props(['disabled' => false])

<input
    @disabled($disabled)
    {{ $attributes->merge(['class' => 'h-12 w-full rounded-2xl border border-neutral-200 bg-white px-4 text-sm text-neutral-900 shadow-soft placeholder:text-neutral-400 transition focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20 disabled:cursor-not-allowed disabled:bg-neutral-100 disabled:text-neutral-500 dark:border-neutral-800 dark:bg-neutral-950 dark:text-neutral-100 dark:placeholder:text-neutral-500 dark:disabled:bg-neutral-900 dark:disabled:text-neutral-500']) }}
>
