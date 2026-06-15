@props([
    'columns' => [],
    'rows' => [],
    'loading' => false,
    'emptyMessage' => 'No records found.',
])

@php
    $isPaginator = $rows instanceof \Illuminate\Contracts\Pagination\Paginator;
    $items = $isPaginator ? $rows->items() : $rows;
@endphp

<div class="overflow-hidden rounded-[24px] border border-neutral-200 bg-white shadow-card dark:border-neutral-800 dark:bg-neutral-950">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-800">
            <thead class="bg-neutral-50 dark:bg-neutral-900/60">
                <tr>
                    @foreach($columns as $column)
                        @php
                            $label = is_array($column) ? ($column['label'] ?? '') : (string) $column;
                        @endphp
                        <th class="px-4 py-3 text-left text-[11px] font-semibold uppercase tracking-[0.16em] text-neutral-500 dark:text-neutral-400">
                            {{ $label }}
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="divide-y divide-neutral-200 bg-white dark:divide-neutral-800 dark:bg-neutral-950">
                @if($loading)
                    @for($i = 0; $i < 5; $i++)
                        <tr class="animate-pulse">
                            @foreach($columns as $column)
                                <td class="px-4 py-4">
                                    <div class="h-4 rounded bg-neutral-200 dark:bg-neutral-800"></div>
                                </td>
                            @endforeach
                        </tr>
                    @endfor
                @elseif(empty($items) || count($items) === 0)
                    <tr>
                        <td colspan="{{ count($columns) }}" class="px-4 py-10">
                            <div class="rounded-2xl border border-dashed border-neutral-300 bg-neutral-50 px-5 py-10 text-center text-sm text-neutral-500 dark:border-neutral-700 dark:bg-neutral-900/40 dark:text-neutral-400">
                                {{ $emptyMessage }}
                            </div>
                        </td>
                    </tr>
                @else
                    @foreach($items as $row)
                        <tr class="transition-colors hover:bg-neutral-50 dark:hover:bg-neutral-900/60">
                            @foreach($columns as $column)
                                @php
                                    $key = is_array($column) ? ($column['key'] ?? null) : (string) $column;
                                    $value = $key ? data_get($row, $key) : null;
                                @endphp
                                <td class="px-4 py-4 text-sm text-neutral-600 dark:text-neutral-300">
                                    {{ $value }}
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>

    @if($isPaginator)
        <div class="px-4 py-3 border-t border-neutral-200 dark:border-neutral-800">
            {{ $rows->links() }}
        </div>
    @endif
</div>
