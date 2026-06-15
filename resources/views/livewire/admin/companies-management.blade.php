@php
    $companyCollection = collect($companies);
    $verifiedCompanies = $companyCollection->where('status', 'Verified')->count();
    $pendingCompanies = $companyCollection->where('status', 'Pending')->count();
@endphp

<div class="space-y-6">
    <div class="overflow-hidden rounded-[28px] border border-neutral-200 bg-gradient-to-r from-white via-white to-primary-50/60 shadow-card">
        <div class="grid gap-6 px-6 py-6 lg:grid-cols-[1.1fr_0.9fr] lg:px-8">
            <div class="min-w-0">
                <span class="inline-flex items-center rounded-full border border-primary-100 bg-white px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.16em] text-primary-700 shadow-soft">
                    Company verification
                </span>
                <h1 class="mt-4 text-3xl font-semibold tracking-tight text-neutral-950">Track partner onboarding and keep verification decisions easy to review.</h1>
                <p class="mt-3 max-w-2xl text-sm leading-6 text-neutral-600">
                    Use this workspace to confirm partner readiness, surface pending reviews, and maintain trust across internship opportunities listed on the platform.
                </p>
            </div>

            <div class="rounded-3xl border border-neutral-200 bg-white/90 p-5 shadow-soft">
                <div class="text-[11px] font-semibold uppercase tracking-[0.16em] text-neutral-500">Partner snapshot</div>
                <div class="mt-4 grid gap-3 sm:grid-cols-3">
                    <div class="rounded-2xl border border-neutral-200 bg-white px-4 py-3">
                        <div class="text-2xl font-semibold tracking-tight text-neutral-950">{{ $companyCollection->count() }}</div>
                        <div class="mt-1 text-xs font-semibold uppercase tracking-[0.14em] text-neutral-400">Companies</div>
                    </div>
                    <div class="rounded-2xl border border-neutral-200 bg-white px-4 py-3">
                        <div class="text-2xl font-semibold tracking-tight text-neutral-950">{{ $verifiedCompanies }}</div>
                        <div class="mt-1 text-xs font-semibold uppercase tracking-[0.14em] text-neutral-400">Verified</div>
                    </div>
                    <div class="rounded-2xl border border-neutral-200 bg-white px-4 py-3">
                        <div class="text-2xl font-semibold tracking-tight text-neutral-950">{{ $pendingCompanies }}</div>
                        <div class="mt-1 text-xs font-semibold uppercase tracking-[0.14em] text-neutral-400">Pending review</div>
                    </div>
                </div>
                <p class="mt-4 text-xs leading-5 text-neutral-500">Pending companies can be verified directly from the table below using the existing action flow.</p>
            </div>
        </div>
    </div>

    <x-widget title="Companies" :collapsible="true">
        <div class="overflow-hidden rounded-[24px] border border-neutral-200 bg-white">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-neutral-200">
                    <thead class="bg-neutral-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-[11px] font-semibold uppercase tracking-[0.16em] text-neutral-500">Company</th>
                            <th class="px-4 py-3 text-left text-[11px] font-semibold uppercase tracking-[0.16em] text-neutral-500">Industry</th>
                            <th class="px-4 py-3 text-left text-[11px] font-semibold uppercase tracking-[0.16em] text-neutral-500">Status</th>
                            <th class="px-4 py-3 text-right text-[11px] font-semibold uppercase tracking-[0.16em] text-neutral-500">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-200 bg-white">
                        @forelse($companies as $index => $company)
                            <tr class="transition-colors hover:bg-neutral-50">
                                <td class="px-4 py-4 text-sm font-semibold text-neutral-950">{{ $company['name'] }}</td>
                                <td class="px-4 py-4 text-sm text-neutral-600">{{ $company['industry'] }}</td>
                                <td class="px-4 py-4 text-sm">
                                    <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold {{ $company['status'] === 'Verified' ? 'bg-success-50 text-success-700 ring-1 ring-inset ring-success-100' : 'bg-warning-50 text-warning-700 ring-1 ring-inset ring-warning-100' }}">
                                        {{ $company['status'] }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm text-right">
                                    <button
                                        type="button"
                                        wire:click="verify({{ $index }})"
                                        class="rounded-xl bg-success-600 px-3 py-2 text-xs font-semibold text-white transition hover:bg-success-500"
                                    >
                                        Verify
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-12 text-center text-sm text-neutral-500">No companies are awaiting admin review yet. New partner records will appear here for verification.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </x-widget>
</div>
