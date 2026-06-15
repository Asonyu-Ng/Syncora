<div class="space-y-6">
    <div class="overflow-hidden rounded-[28px] border border-neutral-200 bg-gradient-to-r from-white via-white to-primary-50/60 shadow-card">
        <div class="grid gap-6 px-6 py-6 lg:grid-cols-[1.1fr_0.9fr] lg:px-8">
            <div class="min-w-0">
                <span class="inline-flex items-center rounded-full border border-primary-100 bg-white px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.16em] text-primary-700 shadow-soft">
                    Intern evaluations
                </span>
                <h1 class="mt-4 text-3xl font-semibold tracking-tight text-neutral-950">Record structured performance feedback for your interns.</h1>
                <p class="mt-3 max-w-2xl text-sm leading-6 text-neutral-600">
                    Keep scoring, notes, and evaluation history organised so hiring teams and internship coordinators can review progress with more clarity.
                </p>
            </div>

            <div class="rounded-3xl border border-neutral-200 bg-white/90 p-5 shadow-soft">
                <div class="text-[11px] font-semibold uppercase tracking-[0.16em] text-neutral-500">Evaluation history</div>
                <div class="mt-4 rounded-2xl border border-neutral-200 bg-white px-4 py-4">
                    <div class="text-2xl font-semibold tracking-tight text-neutral-950">{{ count($evaluations) }}</div>
                    <div class="mt-1 text-xs font-semibold uppercase tracking-[0.14em] text-neutral-400">Entries recorded</div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-1">
            <x-widget title="New Evaluation">
                <div class="space-y-3">
                    <input
                        type="text"
                        wire:model.defer="internName"
                        placeholder="Intern name"
                        class="w-full rounded-lg border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 px-3 py-2 text-sm text-gray-900 dark:text-gray-100 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    />
                    <input
                        type="text"
                        wire:model.defer="score"
                        placeholder="Score (e.g. 8/10)"
                        class="w-full rounded-lg border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 px-3 py-2 text-sm text-gray-900 dark:text-gray-100 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    />
                    <textarea
                        rows="4"
                        wire:model.defer="notes"
                        placeholder="Notes on performance, strengths, and support needed"
                        class="w-full rounded-lg border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 px-3 py-2 text-sm text-gray-900 dark:text-gray-100 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    ></textarea>
                    <button
                        type="button"
                        wire:click="submit"
                        class="w-full rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700 transition-colors"
                    >
                        Save evaluation
                    </button>
                </div>
            </x-widget>
        </div>

        <div class="lg:col-span-2">
            <x-widget title="Evaluations" :collapsible="true">
                <x-dashboard.table
                    :columns="[
                        ['label' => 'Intern', 'key' => 'intern'],
                        ['label' => 'Score', 'key' => 'score'],
                        ['label' => 'Date', 'key' => 'date'],
                        ['label' => 'Status', 'key' => 'status'],
                    ]"
                    :rows="$evaluations"
                    emptyMessage="No evaluations created yet."
                />
            </x-widget>
        </div>
    </div>
</div>
