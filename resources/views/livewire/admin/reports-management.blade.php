@php
    $reportCollection = collect($reports);
    $readyReports = $reportCollection->where('status', 'Ready')->count();
    $queuedReports = $reportCollection->where('status', 'Queued')->count();
@endphp

<div class="space-y-6">
    <div class="overflow-hidden rounded-[28px] border border-neutral-200 bg-gradient-to-r from-white via-white to-primary-50/60 shadow-card">
        <div class="grid gap-6 px-6 py-6 lg:grid-cols-[1.1fr_0.9fr] lg:px-8">
            <div class="min-w-0">
                <span class="inline-flex items-center rounded-full border border-primary-100 bg-white px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.16em] text-primary-700 shadow-soft">
                    Export queue
                </span>
                <h1 class="mt-4 text-3xl font-semibold tracking-tight text-neutral-950">Manage scheduled outputs, compliance exports, and regenerated report jobs.</h1>
                <p class="mt-3 max-w-2xl text-sm leading-6 text-neutral-600">
                    This screen keeps platform reporting visible so admins can track which files are ready, which are queued, and where regeneration is needed.
                </p>
            </div>

            <div class="rounded-3xl border border-neutral-200 bg-white/90 p-5 shadow-soft">
                <div class="text-[11px] font-semibold uppercase tracking-[0.16em] text-neutral-500">Report status</div>
                <div class="mt-4 grid gap-3 sm:grid-cols-3">
                    <div class="rounded-2xl border border-neutral-200 bg-white px-4 py-3">
                        <div class="text-2xl font-semibold tracking-tight text-neutral-950">{{ $reportCollection->count() }}</div>
                        <div class="mt-1 text-xs font-semibold uppercase tracking-[0.14em] text-neutral-400">Total</div>
                    </div>
                    <div class="rounded-2xl border border-neutral-200 bg-white px-4 py-3">
                        <div class="text-2xl font-semibold tracking-tight text-neutral-950">{{ $readyReports }}</div>
                        <div class="mt-1 text-xs font-semibold uppercase tracking-[0.14em] text-neutral-400">Ready</div>
                    </div>
                    <div class="rounded-2xl border border-neutral-200 bg-white px-4 py-3">
                        <div class="text-2xl font-semibold tracking-tight text-neutral-950">{{ $queuedReports }}</div>
                        <div class="mt-1 text-xs font-semibold uppercase tracking-[0.14em] text-neutral-400">Queued</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-widget title="Reports" :collapsible="true">
        <div class="overflow-hidden rounded-[24px] border border-neutral-200 bg-white">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-neutral-200">
                    <thead class="bg-neutral-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-[11px] font-semibold uppercase tracking-[0.16em] text-neutral-500">Report</th>
                            <th class="px-4 py-3 text-left text-[11px] font-semibold uppercase tracking-[0.16em] text-neutral-500">Type</th>
                            <th class="px-4 py-3 text-left text-[11px] font-semibold uppercase tracking-[0.16em] text-neutral-500">Generated</th>
                            <th class="px-4 py-3 text-left text-[11px] font-semibold uppercase tracking-[0.16em] text-neutral-500">Status</th>
                            <th class="px-4 py-3 text-right text-[11px] font-semibold uppercase tracking-[0.16em] text-neutral-500">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-200 bg-white">
                        @forelse($reports as $index => $report)
                            <tr class="transition-colors hover:bg-neutral-50">
                                <td class="px-4 py-4 text-sm font-semibold text-neutral-950">{{ $report['name'] }}</td>
                                <td class="px-4 py-4 text-sm text-neutral-600">{{ $report['type'] }}</td>
                                <td class="px-4 py-4 text-sm text-neutral-600">{{ $report['generated'] }}</td>
                                <td class="px-4 py-4 text-sm">
                                    <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold {{ $report['status'] === 'Ready' ? 'bg-success-50 text-success-700 ring-1 ring-inset ring-success-100' : 'bg-warning-50 text-warning-700 ring-1 ring-inset ring-warning-100' }}">
                                        {{ $report['status'] }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm text-right">
                                    <button
                                        type="button"
                                        wire:click="regenerate({{ $index }})"
                                        class="rounded-xl bg-primary-600 px-3 py-2 text-xs font-semibold text-white transition hover:bg-primary-500"
                                    >
                                        Regenerate
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-12 text-center text-sm text-neutral-500">No reports are queued yet. Generated exports will appear here when reporting activity begins.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </x-widget>
</div>
