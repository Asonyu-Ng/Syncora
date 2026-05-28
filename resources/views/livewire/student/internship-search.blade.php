<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Internship Search</h1>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">Search by city (stub)</p>
        </div>
    </div>

    <x-widget title="Search">
        <div class="flex flex-col sm:flex-row gap-3">
            <input
                type="text"
                wire:model.defer="city"
                placeholder="City (e.g., Lagos)"
                class="w-full sm:flex-1 rounded-lg border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 px-3 py-2 text-sm text-gray-900 dark:text-gray-100 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500"
            />
            <button
                type="button"
                wire:click="search"
                class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700 transition-colors"
            >
                Search
            </button>
        </div>
    </x-widget>

    <x-widget title="Results" :collapsible="true">
        <x-dashboard.table
            :columns="[
                ['label' => 'Title', 'key' => 'title'],
                ['label' => 'Company', 'key' => 'company'],
                ['label' => 'City', 'key' => 'city'],
                ['label' => 'Type', 'key' => 'type'],
            ]"
            :rows="$results"
            emptyMessage="{{ $searched ? 'No internships matched your search.' : 'Start by searching for a city.' }}"
        />

        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-3">
            @foreach($results as $internship)
                <a
                    href="{{ route('student.internships.show', $internship['id']) }}"
                    class="px-4 py-3 rounded-lg border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 hover:bg-gray-50 dark:hover:bg-gray-800/40 transition-colors"
                >
                    <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $internship['title'] }}</div>
                    <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">{{ $internship['company'] }} • {{ ucfirst($internship['city']) }} • {{ $internship['type'] }}</div>
                </a>
            @endforeach
        </div>
    </x-widget>
</div>

