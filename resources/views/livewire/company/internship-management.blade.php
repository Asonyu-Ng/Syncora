<div class="space-y-6">
    <div class="overflow-hidden rounded-[28px] border border-neutral-200 bg-gradient-to-r from-white via-white to-primary-50/60 shadow-card">
        <div class="flex flex-col gap-5 px-6 py-6 lg:flex-row lg:items-end lg:justify-between lg:px-8">
            <div class="min-w-0">
                <span class="inline-flex items-center rounded-full border border-primary-100 bg-white px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.16em] text-primary-700 shadow-soft">
                    Internship management
                </span>
                <h1 class="mt-4 text-3xl font-semibold tracking-tight text-neutral-950">Track every role your company has published.</h1>
                <p class="mt-3 max-w-2xl text-sm leading-6 text-neutral-600">Monitor active postings, location coverage, application volume, and role status from one structured management surface.</p>
            </div>

            <a
                href="{{ route('company.internships.create') }}"
                class="inline-flex h-11 items-center justify-center rounded-xl bg-primary-600 px-5 text-sm font-semibold text-white shadow-soft transition hover:bg-primary-500"
            >
                Post internship
            </a>
        </div>
    </div>

    <x-widget title="Internships" :collapsible="true">
        <x-dashboard.table
            :columns="[
                ['label' => 'Title', 'key' => 'title'],
                ['label' => 'Location', 'key' => 'location'],
                ['label' => 'Applications', 'key' => 'applications'],
                ['label' => 'Status', 'key' => 'status'],
            ]"
            :rows="$internships"
            emptyMessage="No internships posted yet."
        />
    </x-widget>
</div>
