<div class="space-y-6">
    <div class="overflow-hidden rounded-[28px] border border-neutral-200 bg-gradient-to-r from-white via-white to-primary-50/60 shadow-card">
        <div class="grid gap-6 px-6 py-6 lg:grid-cols-[1.1fr_0.9fr] lg:px-8">
            <div class="min-w-0">
                <span class="inline-flex items-center rounded-full border border-primary-100 bg-white px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.16em] text-primary-700 shadow-soft">
                    Company reports
                </span>
                <h1 class="mt-4 text-3xl font-semibold tracking-tight text-neutral-950">Keep generated reporting output organised and reviewable.</h1>
                <p class="mt-3 max-w-2xl text-sm leading-6 text-neutral-600">
                    Use this list to track report availability, confirm status, and keep shared company reporting activity visible across internship programmes.
                </p>
            </div>

            <div class="rounded-3xl border border-neutral-200 bg-white/90 p-5 shadow-soft">
                <div class="text-[11px] font-semibold uppercase tracking-[0.16em] text-neutral-500">Reports in view</div>
                <div class="mt-4 rounded-2xl border border-neutral-200 bg-white px-4 py-4">
                    <div class="text-2xl font-semibold tracking-tight text-neutral-950">{{ count($reports) }}</div>
                    <div class="mt-1 text-xs font-semibold uppercase tracking-[0.14em] text-neutral-400">Available reports</div>
                </div>
            </div>
        </div>
    </div>

    <x-widget title="Available Reports" :collapsible="true">
        <x-dashboard.table
            :columns="[
                ['label' => 'Title', 'key' => 'title'],
                ['label' => 'Intern', 'key' => 'intern'],
                ['label' => 'Created', 'key' => 'createdAt'],
                ['label' => 'Status', 'key' => 'status'],
            ]"
            :rows="$reports"
            emptyMessage="No reports available."
        />
    </x-widget>
</div>
