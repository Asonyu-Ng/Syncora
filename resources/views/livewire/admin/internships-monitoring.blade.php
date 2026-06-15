@php
    $internshipCollection = collect($internships);
    $openInternships = $internshipCollection->where('status', 'Open')->count();
    $closedInternships = $internshipCollection->where('status', 'Closed')->count();
    $totalApplications = $internshipCollection->sum('applications');
@endphp

<div class="space-y-6">
    <div class="overflow-hidden rounded-[28px] border border-neutral-200 bg-gradient-to-r from-white via-white to-primary-50/60 shadow-card">
        <div class="grid gap-6 px-6 py-6 lg:grid-cols-[1.1fr_0.9fr] lg:px-8">
            <div class="min-w-0">
                <span class="inline-flex items-center rounded-full border border-primary-100 bg-white px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.16em] text-primary-700 shadow-soft">
                    Listing monitoring
                </span>
                <h1 class="mt-4 text-3xl font-semibold tracking-tight text-neutral-950">Keep internship availability, demand, and listing health in view.</h1>
                <p class="mt-3 max-w-2xl text-sm leading-6 text-neutral-600">
                    Follow current openings, compare application volume, and spot listings that may need intervention or closure review across the platform.
                </p>
            </div>

            <div class="rounded-3xl border border-neutral-200 bg-white/90 p-5 shadow-soft">
                <div class="text-[11px] font-semibold uppercase tracking-[0.16em] text-neutral-500">Market snapshot</div>
                <div class="mt-4 grid gap-3 sm:grid-cols-3">
                    <div class="rounded-2xl border border-neutral-200 bg-white px-4 py-3">
                        <div class="text-2xl font-semibold tracking-tight text-neutral-950">{{ $internshipCollection->count() }}</div>
                        <div class="mt-1 text-xs font-semibold uppercase tracking-[0.14em] text-neutral-400">Listings</div>
                    </div>
                    <div class="rounded-2xl border border-neutral-200 bg-white px-4 py-3">
                        <div class="text-2xl font-semibold tracking-tight text-neutral-950">{{ $openInternships }}</div>
                        <div class="mt-1 text-xs font-semibold uppercase tracking-[0.14em] text-neutral-400">Open roles</div>
                    </div>
                    <div class="rounded-2xl border border-neutral-200 bg-white px-4 py-3">
                        <div class="text-2xl font-semibold tracking-tight text-neutral-950">{{ $totalApplications }}</div>
                        <div class="mt-1 text-xs font-semibold uppercase tracking-[0.14em] text-neutral-400">Applications</div>
                    </div>
                </div>
                <p class="mt-4 text-xs leading-5 text-neutral-500">Closed listings: {{ $closedInternships }}. Review open roles with high application volume for faster downstream decision-making.</p>
            </div>
        </div>
    </div>

    <x-widget title="Internships" :collapsible="true">
        <div class="space-y-4">
            <div class="grid gap-3 sm:grid-cols-2">
                <div class="rounded-2xl border border-neutral-200 bg-neutral-50 px-4 py-4">
                    <div class="text-xs font-semibold uppercase tracking-[0.14em] text-neutral-400">Open listing share</div>
                    <p class="mt-2 text-sm leading-6 text-neutral-600">
                        {{ $openInternships }} of {{ $internshipCollection->count() }} listed internships are still receiving candidates.
                    </p>
                </div>
                <div class="rounded-2xl border border-neutral-200 bg-neutral-50 px-4 py-4">
                    <div class="text-xs font-semibold uppercase tracking-[0.14em] text-neutral-400">Review cue</div>
                    <p class="mt-2 text-sm leading-6 text-neutral-600">
                        High-volume roles can be routed for closer monitoring when application counts outpace review capacity.
                    </p>
                </div>
            </div>

            <x-dashboard.table
                :columns="[
                    ['label' => 'Title', 'key' => 'title'],
                    ['label' => 'Company', 'key' => 'company'],
                    ['label' => 'Location', 'key' => 'location'],
                    ['label' => 'Status', 'key' => 'status'],
                    ['label' => 'Applications', 'key' => 'applications'],
                ]"
                :rows="$internships"
                emptyMessage="No internships are being monitored yet."
            />
        </div>
    </x-widget>
</div>
