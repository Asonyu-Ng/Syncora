@props([
    'badge' => null,
    'title',
    'description' => null,
])

<div class="overflow-hidden rounded-[28px] border border-neutral-200 bg-gradient-to-r from-white via-white to-primary-50/60 shadow-card dark:border-neutral-800 dark:from-neutral-950 dark:via-neutral-950 dark:to-primary-500/10">
    <div class="flex flex-col gap-4 px-6 py-6 lg:px-8">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
            <div class="min-w-0">
                @if($badge)
                    <span class="inline-flex items-center rounded-full border border-primary-100 bg-white px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.16em] text-primary-700 shadow-soft dark:border-primary-500/20 dark:bg-neutral-950 dark:text-primary-200">
                        {{ $badge }}
                    </span>
                @endif
                <h1 class="mt-4 text-3xl font-semibold tracking-tight text-neutral-950 sm:text-[2.1rem] dark:text-neutral-50">{{ $title }}</h1>
                @if($description)
                    <p class="mt-3 max-w-3xl text-sm leading-6 text-neutral-600 dark:text-neutral-300">
                        {{ $description }}
                    </p>
                @endif
            </div>

            @if(isset($actions))
                <div class="flex shrink-0 flex-wrap items-center gap-3">
                    {{ $actions }}
                </div>
            @endif
        </div>
    </div>
</div>

