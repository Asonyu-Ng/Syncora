@php
    $pendingRequests = collect($requests)->where('status', 'Pending')->count();
@endphp

<div class="space-y-6">
    <div class="overflow-hidden rounded-[28px] border border-neutral-200 bg-gradient-to-r from-white via-white to-primary-50/60 shadow-card">
        <div class="grid gap-6 px-6 py-6 lg:grid-cols-[1.1fr_0.9fr] lg:px-8">
            <div class="min-w-0">
                <span class="inline-flex items-center rounded-full border border-primary-100 bg-white px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.16em] text-primary-700 shadow-soft">
                    Verification queue
                </span>
                <h1 class="mt-4 text-3xl font-semibold tracking-tight text-neutral-950">Review pending requests with clearer context.</h1>
                <p class="mt-3 max-w-2xl text-sm leading-6 text-neutral-600">
                    Use this queue to confirm student verification items quickly, while keeping pending decisions separate from already-processed requests.
                </p>
            </div>

            <div class="rounded-3xl border border-neutral-200 bg-white/90 p-5 shadow-soft">
                <div class="text-[11px] font-semibold uppercase tracking-[0.16em] text-neutral-500">Approval snapshot</div>
                <div class="mt-4 grid gap-3 sm:grid-cols-2">
                    <div class="rounded-2xl border border-neutral-200 bg-white px-4 py-3">
                        <div class="text-2xl font-semibold tracking-tight text-neutral-950">{{ $pendingRequests }}</div>
                        <div class="mt-1 text-xs font-semibold uppercase tracking-[0.14em] text-neutral-400">Pending</div>
                    </div>
                    <div class="rounded-2xl border border-neutral-200 bg-white px-4 py-3">
                        <div class="text-2xl font-semibold tracking-tight text-neutral-950">{{ count($requests) }}</div>
                        <div class="mt-1 text-xs font-semibold uppercase tracking-[0.14em] text-neutral-400">Total requests</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-widget title="Requests" :collapsible="true">
        <div class="space-y-3">
            @foreach($requests as $index => $request)
                <div class="p-4 rounded-lg border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div>
                            <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                {{ $request['student'] }} · {{ $request['type'] }}
                            </div>
                            <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                Submitted: {{ $request['submitted_at'] }} · Status: {{ $request['status'] }}
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <button
                                type="button"
                                wire:click="approve({{ $index }})"
                                class="px-3 py-2 text-sm font-medium rounded-lg bg-green-600 hover:bg-green-700 text-white disabled:opacity-50"
                                @disabled($request['status'] !== 'Pending')
                            >
                                Approve
                            </button>
                            <button
                                type="button"
                                wire:click="reject({{ $index }})"
                                class="px-3 py-2 text-sm font-medium rounded-lg bg-red-600 hover:bg-red-700 text-white disabled:opacity-50"
                                @disabled($request['status'] !== 'Pending')
                            >
                                Reject
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </x-widget>
</div>
