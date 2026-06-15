<div class="space-y-6">
    <div class="overflow-hidden rounded-[28px] border border-neutral-200 bg-gradient-to-r from-white via-white to-primary-50/60 shadow-card">
        <div class="grid gap-6 px-6 py-6 lg:grid-cols-[1.1fr_0.9fr] lg:px-8">
            <div class="min-w-0">
                <span class="inline-flex items-center rounded-full border border-primary-100 bg-white px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.16em] text-primary-700 shadow-soft">
                    Review calendar
                </span>
                <h1 class="mt-4 text-3xl font-semibold tracking-tight text-neutral-950">Keep supervision milestones and follow-up dates visible.</h1>
                <p class="mt-3 max-w-2xl text-sm leading-6 text-neutral-600">
                    Use this calendar view as a scheduling surface for intern reviews, reporting checkpoints, and important supervision deadlines.
                </p>
            </div>

            <div class="rounded-3xl border border-neutral-200 bg-white/90 p-5 shadow-soft">
                <div class="text-[11px] font-semibold uppercase tracking-[0.16em] text-neutral-500">Upcoming events</div>
                <div class="mt-4 rounded-2xl border border-neutral-200 bg-white px-4 py-4">
                    <div class="text-2xl font-semibold tracking-tight text-neutral-950">{{ count($events) }}</div>
                    <div class="mt-1 text-xs font-semibold uppercase tracking-[0.14em] text-neutral-400">Events scheduled</div>
                </div>
            </div>
        </div>
    </div>

    <x-widget title="Upcoming Events" :collapsible="true">
        <x-dashboard.table
            :columns="[
                ['label' => 'Event', 'key' => 'title'],
                ['label' => 'Date', 'key' => 'date'],
            ]"
            :rows="$events"
            emptyMessage="No events scheduled."
        />
    </x-widget>
</div>
