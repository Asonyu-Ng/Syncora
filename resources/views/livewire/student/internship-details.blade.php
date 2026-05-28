<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Internship Details</h1>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">Read-only stub</p>
        </div>
        <a
            href="{{ route('student.internships.search') }}"
            class="text-sm font-semibold text-indigo-600 hover:text-indigo-700"
        >
            Back to search
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <x-widget title="Overview">
                <div class="space-y-2">
                    <div class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $details['title'] }}</div>
                    <div class="text-sm text-gray-600 dark:text-gray-300">{{ $details['company'] }} • {{ $details['city'] }} • {{ $details['type'] }}</div>
                    <div class="pt-2 text-sm text-gray-700 dark:text-gray-200">{{ $details['description'] }}</div>
                </div>
            </x-widget>

            <x-widget title="Requirements" :collapsible="true">
                <ul class="list-disc pl-5 space-y-1 text-sm text-gray-700 dark:text-gray-200">
                    @foreach($details['requirements'] as $req)
                        <li>{{ $req }}</li>
                    @endforeach
                </ul>
            </x-widget>
        </div>

        <div class="space-y-6">
            <x-widget title="Meta" :collapsible="true">
                <div class="space-y-3 text-sm">
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600 dark:text-gray-300">Internship ID</span>
                        <span class="font-semibold text-gray-900 dark:text-gray-100">{{ $details['id'] }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600 dark:text-gray-300">Duration</span>
                        <span class="font-semibold text-gray-900 dark:text-gray-100">{{ $details['duration'] }}</span>
                    </div>
                </div>
            </x-widget>

            <x-widget title="Actions">
                <div class="space-y-3">
                    <button type="button" class="w-full rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700 transition-colors">
                        Apply (stub)
                    </button>
                    <a href="{{ route('student.applications.index') }}" class="w-full inline-flex items-center justify-center rounded-lg border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 px-4 py-2 text-sm font-semibold text-gray-900 dark:text-gray-100 hover:bg-gray-50 dark:hover:bg-gray-800/40 transition-colors">
                        View applications
                    </a>
                </div>
            </x-widget>
        </div>
    </div>
</div>

