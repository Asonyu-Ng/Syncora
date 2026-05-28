<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Task Board</h1>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">Kanban/list stub</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        @foreach($columns as $columnName => $tasks)
            <x-widget :title="$columnName" :collapsible="true">
                <div class="space-y-3">
                    @foreach($tasks as $task)
                        <div class="p-3 rounded-lg border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900">
                            <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $task['title'] }}</div>
                            <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">Due: {{ $task['due'] }}</div>
                        </div>
                    @endforeach
                </div>
            </x-widget>
        @endforeach
    </div>
</div>

