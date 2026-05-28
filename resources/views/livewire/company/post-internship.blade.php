<div class="space-y-6">
    <div class="flex items-start justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Post Internship</h1>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">Create stub</p>
        </div>

        <a href="{{ route('company.internships.index') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-700">
            Back to internships
        </a>
    </div>

    <x-widget title="New Internship">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="md:col-span-2">
                <label class="text-xs font-semibold text-gray-600 dark:text-gray-300">Title</label>
                <input
                    type="text"
                    wire:model.defer="title"
                    placeholder="e.g. Software Engineering Intern"
                    class="mt-1 w-full rounded-lg border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 px-3 py-2 text-sm text-gray-900 dark:text-gray-100 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                />
            </div>

            <div>
                <label class="text-xs font-semibold text-gray-600 dark:text-gray-300">Location</label>
                <input
                    type="text"
                    wire:model.defer="location"
                    placeholder="e.g. Lagos, NG"
                    class="mt-1 w-full rounded-lg border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 px-3 py-2 text-sm text-gray-900 dark:text-gray-100 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                />
            </div>

            <div>
                <label class="text-xs font-semibold text-gray-600 dark:text-gray-300">Duration</label>
                <input
                    type="text"
                    wire:model.defer="duration"
                    placeholder="e.g. 3 months"
                    class="mt-1 w-full rounded-lg border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 px-3 py-2 text-sm text-gray-900 dark:text-gray-100 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                />
            </div>

            <div class="md:col-span-2">
                <label class="text-xs font-semibold text-gray-600 dark:text-gray-300">Description</label>
                <textarea
                    rows="5"
                    wire:model.defer="description"
                    placeholder="Short role summary (stub)"
                    class="mt-1 w-full rounded-lg border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 px-3 py-2 text-sm text-gray-900 dark:text-gray-100 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                ></textarea>
            </div>

            <div class="md:col-span-2">
                <button
                    type="button"
                    wire:click="submit"
                    class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700 transition-colors"
                >
                    Publish (stub)
                </button>
            </div>
        </div>
    </x-widget>
</div>

