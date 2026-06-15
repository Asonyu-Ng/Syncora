@props([
    'stickyAside' => true,
])

<div class="grid grid-cols-1 gap-6 lg:grid-cols-[minmax(0,1fr)_360px]">
    <div class="min-w-0">
        {{ $main }}
    </div>

    <aside class="min-w-0 space-y-6 {{ $stickyAside ? 'lg:sticky lg:top-24 lg:self-start' : '' }}">
        {{ $aside }}
    </aside>
</div>

