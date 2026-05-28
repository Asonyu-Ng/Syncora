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

<div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-800">
            <thead class="bg-gray-50 dark:bg-gray-800/40">
                <tr>
                    @foreach($columns as $column)
                        @php
                            $label = is_array($column) ? ($column['label'] ?? '') : (string) $column;
                        @endphp
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                            {{ $label }}
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                @if($loading)
                    @for($i = 0; $i < 5; $i++)
                        <tr class="animate-pulse">
                            @foreach($columns as $column)
                                <td class="px-4 py-3">
                                    <div class="h-4 bg-gray-200 dark:bg-gray-800 rounded"></div>
                                </td>
                            @endforeach
                        </tr>
                    @endfor
                @elseif(empty($items) || count($items) === 0)
                    <tr>
                        <td colspan="{{ count($columns) }}" class="px-4 py-10 text-center text-sm text-gray-500 dark:text-gray-400">
                            {{ $emptyMessage }}
                        </td>
                    </tr>
                @else
                    @foreach($items as $row)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/40 transition-colors">
                            @foreach($columns as $column)
                                @php
                                    $key = is_array($column) ? ($column['key'] ?? null) : (string) $column;
                                    $value = $key ? data_get($row, $key) : null;
                                @endphp
                                <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-200">
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
        <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-800">
            {{ $rows->links() }}
        </div>
    @endif
</div>
