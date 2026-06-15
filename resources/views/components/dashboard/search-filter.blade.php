@props([
    'filters' => [],
    'placeholder' => 'Search...',
    'eventName' => 'dashboard-search',
])

<div
    x-data="{
        q: '',
        f: {},
        emit() { $dispatch('{{ $eventName }}', { query: this.q, filters: this.f }) },
    }"
    class="flex flex-col sm:flex-row gap-3"
>
    <div class="flex-1">
        <input
            type="text"
            x-model="q"
            @input.debounce.300ms="emit()"
            placeholder="{{ $placeholder }}"
            class="h-12 w-full rounded-2xl border border-neutral-200 bg-white px-4 text-sm text-neutral-900 shadow-soft placeholder:text-neutral-400 focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20 dark:border-neutral-800 dark:bg-neutral-950 dark:text-neutral-100 dark:placeholder:text-neutral-500"
        />
    </div>

    @foreach($filters as $filter)
        @php
            $key = $filter['key'] ?? null;
            $label = $filter['label'] ?? '';
            $options = $filter['options'] ?? [];
        @endphp
        @if($key)
            <div class="sm:w-48">
                <select
                    x-model="f['{{ $key }}']"
                    @change="emit()"
                    class="h-12 w-full rounded-2xl border border-neutral-200 bg-white px-4 text-sm text-neutral-900 shadow-soft focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20 dark:border-neutral-800 dark:bg-neutral-950 dark:text-neutral-100"
                >
                    <option value="">{{ $label }}</option>
                    @foreach($options as $optionValue => $optionLabel)
                        <option value="{{ $optionValue }}">{{ $optionLabel }}</option>
                    @endforeach
                </select>
            </div>
        @endif
    @endforeach
</div>
