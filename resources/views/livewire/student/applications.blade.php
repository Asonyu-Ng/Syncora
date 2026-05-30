@php
    $statusPills = [
        'pending' => 'bg-warning-50 text-warning-700 ring-warning-100',
        'applied' => 'bg-warning-50 text-warning-700 ring-warning-100',
        'under_review' => 'bg-info-50 text-info-700 ring-info-100',
        'accepted' => 'bg-success-50 text-success-700 ring-success-100',
        'rejected' => 'bg-danger-50 text-danger-700 ring-danger-100',
        'withdrawn' => 'bg-neutral-100 text-neutral-700 ring-neutral-200',
    ];
@endphp

<div class="space-y-8">
    @if(session()->has('message'))
        <div class="rounded-2xl border border-primary-100 bg-primary-50 px-5 py-4 text-sm font-semibold text-primary-800 shadow-soft">
            {{ session('message') }}
        </div>
    @endif

    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div class="min-w-0">
            <h1 class="text-3xl font-semibold text-neutral-900 tracking-tight">Applications</h1>
            <p class="mt-2 text-sm text-neutral-600">Track your internship applications, stay on top of updates, and take action when needed.</p>
        </div>

        <a href="{{ route('student.internships.search') }}" class="inline-flex h-11 items-center justify-center gap-2 rounded-xl bg-primary-600 px-5 text-sm font-semibold text-white shadow-soft transition hover:bg-primary-500 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-primary-500/25">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 103.5 10.5a7.5 7.5 0 0013.15 6.15z" />
            </svg>
            Find Internships
        </a>
    </div>

    <div class="flex gap-2 overflow-x-auto pb-1 -mx-3 px-3 sm:mx-0 sm:px-0">
        @foreach($statusTabs as $tab)
            @php
                $active = $status === $tab['key'];
                $tabClasses = $active
                    ? 'bg-primary-600 text-white'
                    : 'bg-white text-neutral-700 border border-neutral-200 hover:bg-neutral-50';
                $countClasses = $active ? 'bg-white/20 text-white' : 'bg-neutral-100 text-neutral-700';
            @endphp

            <button
                type="button"
                wire:click="$set('status', '{{ $tab['key'] }}')"
                class="inline-flex items-center gap-2 whitespace-nowrap rounded-full px-4 py-2 text-sm font-semibold transition focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-primary-500/25 {{ $tabClasses }}"
            >
                <span>{{ $tab['label'] }}</span>
                <span class="inline-flex h-6 items-center rounded-full px-2 text-xs font-semibold {{ $countClasses }}">{{ $tab['count'] }}</span>
            </button>
        @endforeach
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-12">
        <div class="space-y-6 lg:col-span-8">
            <div class="rounded-2xl border border-neutral-200 bg-white shadow-card">
                <div class="flex flex-col gap-3 border-b border-neutral-200 p-5 sm:flex-row sm:items-center sm:justify-between sm:p-6">
                    <div class="relative w-full sm:max-w-sm">
                        <svg class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 103.5 10.5a7.5 7.5 0 0013.15 6.15z" />
                        </svg>
                        <input
                            type="search"
                            wire:model.live.debounce.300ms="search"
                            placeholder="Search by company or role..."
                            class="h-11 w-full rounded-xl border border-neutral-200 bg-neutral-50 pl-9 pr-3 text-sm text-neutral-900 shadow-soft placeholder:text-neutral-400 focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20"
                        />
                    </div>

                    <div class="flex items-center gap-3">
                        <label class="text-sm font-semibold text-neutral-700" for="applications-per-page">Rows</label>
                        <select
                            id="applications-per-page"
                            wire:model.live="perPage"
                            class="h-11 rounded-xl border border-neutral-200 bg-white px-3 text-sm font-semibold text-neutral-900 shadow-soft focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20"
                        >
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
                    </div>
                </div>

                <div class="hidden md:block">
                    <div class="grid grid-cols-12 gap-4 px-6 py-3 text-xs font-semibold text-neutral-500">
                        <div class="col-span-3">Company</div>
                        <div class="col-span-3">Position</div>
                        <div class="col-span-2">Status</div>
                        <div class="col-span-1">Applied</div>
                        <div class="col-span-3 text-right">Actions</div>
                    </div>

                    @forelse($applications as $application)
                        @php
                            $badge = $statusPills[$application['status_key']] ?? 'bg-neutral-100 text-neutral-700 ring-neutral-200';
                            $canWithdraw = in_array($application['status_key'], ['pending', 'applied', 'under_review'], true);
                        @endphp

                        <div class="grid grid-cols-12 gap-4 border-t border-neutral-100 px-6 py-4 items-center">
                            <div class="col-span-3 min-w-0">
                                <div class="truncate text-sm font-semibold text-neutral-900">{{ $application['company'] }}</div>
                            </div>
                            <div class="col-span-3 min-w-0">
                                <div class="truncate text-sm font-semibold text-neutral-900">{{ $application['position'] }}</div>
                                <div class="mt-1 text-xs text-neutral-500">Application #{{ $application['id'] }}</div>
                            </div>
                            <div class="col-span-2">
                                <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold ring-1 ring-inset {{ $badge }}">
                                    {{ $application['status'] }}
                                </span>
                            </div>
                            <div class="col-span-1 text-sm text-neutral-700">{{ $application['applied_on'] }}</div>
                            <div class="col-span-3 flex justify-end items-center gap-2">
                                @if($application['internship_id'])
                                    <a href="{{ route('student.internships.show', $application['internship_id']) }}" class="inline-flex h-9 shrink-0 items-center justify-center whitespace-nowrap rounded-xl border border-neutral-200 bg-white px-3 text-sm font-semibold text-neutral-900 transition hover:bg-neutral-50 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-primary-500/25">
                                        View Details
                                    </a>
                                @else
                                    <span class="inline-flex h-9 shrink-0 items-center justify-center whitespace-nowrap rounded-xl border border-neutral-200 bg-neutral-50 px-3 text-sm font-semibold text-neutral-400">View Details</span>
                                @endif

                                @if($application['status_key'] === 'accepted')
                                    <button type="button" wire:click="viewOffer({{ $application['id'] }})" class="inline-flex h-9 shrink-0 items-center justify-center whitespace-nowrap rounded-xl bg-success-600 px-3 text-sm font-semibold text-white shadow-soft transition hover:bg-success-500 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-success-500/25">
                                        View Offer
                                    </button>
                                @endif

                                <x-dropdown align="right" width="48" contentClasses="py-1 bg-white">
                                    <x-slot name="trigger">
                                        <button type="button" class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-neutral-200 bg-white text-neutral-700 transition hover:bg-neutral-50 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-primary-500/25" aria-label="More actions">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6h.01M12 12h.01M12 18h.01" />
                                            </svg>
                                        </button>
                                    </x-slot>

                                    <x-slot name="content">
                                        @if($application['internship_id'])
                                            <x-dropdown-link href="{{ route('student.internships.show', $application['internship_id']) }}">
                                                View Details
                                            </x-dropdown-link>
                                        @endif

                                        @if($application['status_key'] === 'accepted')
                                            <button type="button" wire:click="viewOffer({{ $application['id'] }})" class="block w-full px-4 py-2 text-start text-sm font-medium text-success-700 transition hover:bg-success-50 focus-visible:outline-none focus-visible:bg-success-50">
                                                View Offer
                                            </button>
                                        @endif

                                        @if($canWithdraw)
                                            <button type="button" x-on:click.prevent="if (confirm('Withdraw this application?')) { $wire.withdraw({{ $application['id'] }}) }" class="block w-full px-4 py-2 text-start text-sm font-medium text-danger-700 transition hover:bg-danger-50 focus-visible:outline-none focus-visible:bg-danger-50">
                                                Withdraw
                                            </button>
                                        @endif
                                    </x-slot>
                                </x-dropdown>
                            </div>
                        </div>
                    @empty
                        <div class="border-t border-neutral-100 px-6 py-12 text-center">
                            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-neutral-100 text-neutral-500">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 6H7a2 2 0 01-2-2V4a2 2 0 012-2h7l5 5v13a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <h3 class="mt-4 text-base font-semibold text-neutral-900">No applications found</h3>
                            <p class="mt-2 text-sm text-neutral-600">Try adjusting your status filter or search term.</p>
                        </div>
                    @endforelse
                </div>

                <div class="md:hidden space-y-4 p-5">
                    @forelse($applications as $application)
                        @php
                            $badge = $statusPills[$application['status_key']] ?? 'bg-neutral-100 text-neutral-700 ring-neutral-200';
                            $canWithdraw = in_array($application['status_key'], ['pending', 'applied', 'under_review'], true);
                        @endphp

                        <div class="rounded-2xl border border-neutral-200 bg-white p-4 shadow-soft">
                            <div class="flex items-start justify-between gap-3">
                                <div class="min-w-0">
                                    <p class="truncate text-sm font-semibold text-neutral-900">{{ $application['position'] }}</p>
                                    <p class="mt-1 truncate text-sm text-neutral-600">{{ $application['company'] }}</p>
                                </div>
                                <span class="shrink-0 inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold ring-1 ring-inset {{ $badge }}">
                                    {{ $application['status'] }}
                                </span>
                            </div>

                            <div class="mt-3 flex items-center justify-between text-xs font-medium text-neutral-500">
                                <span>Applied {{ $application['applied_on'] }}</span>
                                <span>#{{ $application['id'] }}</span>
                            </div>

                            <div class="mt-4 flex flex-wrap items-center gap-2">
                                @if($application['internship_id'])
                                    <a href="{{ route('student.internships.show', $application['internship_id']) }}" class="inline-flex h-10 flex-1 items-center justify-center whitespace-nowrap rounded-xl border border-neutral-200 bg-white px-3 text-sm font-semibold text-neutral-900 transition hover:bg-neutral-50 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-primary-500/25">
                                        View Details
                                    </a>
                                @endif

                                @if($application['status_key'] === 'accepted')
                                    <button type="button" wire:click="viewOffer({{ $application['id'] }})" class="inline-flex h-10 flex-1 items-center justify-center whitespace-nowrap rounded-xl bg-success-600 px-3 text-sm font-semibold text-white shadow-soft transition hover:bg-success-500 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-success-500/25">
                                        View Offer
                                    </button>
                                @endif

                                <x-dropdown align="right" width="48" contentClasses="py-1 bg-white">
                                    <x-slot name="trigger">
                                        <button type="button" class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-neutral-200 bg-white text-neutral-700 transition hover:bg-neutral-50 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-primary-500/25" aria-label="More actions">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6h.01M12 12h.01M12 18h.01" />
                                            </svg>
                                        </button>
                                    </x-slot>

                                    <x-slot name="content">
                                        @if($application['internship_id'])
                                            <x-dropdown-link href="{{ route('student.internships.show', $application['internship_id']) }}">
                                                View Details
                                            </x-dropdown-link>
                                        @endif

                                        @if($application['status_key'] === 'accepted')
                                            <button type="button" wire:click="viewOffer({{ $application['id'] }})" class="block w-full px-4 py-2 text-start text-sm font-medium text-success-700 transition hover:bg-success-50 focus-visible:outline-none focus-visible:bg-success-50">
                                                View Offer
                                            </button>
                                        @endif

                                        @if($canWithdraw)
                                            <button type="button" x-on:click.prevent="if (confirm('Withdraw this application?')) { $wire.withdraw({{ $application['id'] }}) }" class="block w-full px-4 py-2 text-start text-sm font-medium text-danger-700 transition hover:bg-danger-50 focus-visible:outline-none focus-visible:bg-danger-50">
                                                Withdraw
                                            </button>
                                        @endif
                                    </x-slot>
                                </x-dropdown>
                            </div>
                        </div>
                    @empty
                        <div class="rounded-2xl border border-dashed border-neutral-200 bg-white p-10 text-center shadow-soft">
                            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-neutral-100 text-neutral-500">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 6H7a2 2 0 01-2-2V4a2 2 0 012-2h7l5 5v13a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <h3 class="mt-4 text-base font-semibold text-neutral-900">No applications found</h3>
                            <p class="mt-2 text-sm text-neutral-600">Try adjusting your status filter or search term.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="pt-2">
                {{ $applications->withQueryString()->onEachSide(1)->links() }}
            </div>
        </div>

        <aside class="space-y-6 lg:col-span-4">
            <div class="rounded-2xl border border-neutral-200 bg-white p-5 shadow-card sm:p-6">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <h2 class="text-sm font-semibold text-neutral-900">Application Summary</h2>
                        <p class="mt-1 text-sm text-neutral-600">A quick snapshot of where things stand.</p>
                    </div>
                    <div class="rounded-full bg-primary-50 px-3 py-1 text-xs font-semibold text-primary-700">{{ $statusCounts['all'] ?? 0 }} total</div>
                </div>

                <div class="mt-5 space-y-3">
                    <div class="flex items-center justify-between rounded-xl border border-neutral-200 bg-neutral-50 px-4 py-3 text-sm font-semibold text-neutral-900">
                        <span class="flex items-center gap-2">
                            <span class="h-2.5 w-2.5 rounded-full bg-warning-500"></span>
                            Pending
                        </span>
                        <span class="inline-flex h-6 items-center rounded-full bg-white px-2 text-xs font-semibold text-neutral-700 shadow-soft">{{ $statusCounts['pending'] ?? 0 }}</span>
                    </div>
                    <div class="flex items-center justify-between rounded-xl border border-neutral-200 bg-white px-4 py-3 text-sm font-semibold text-neutral-900">
                        <span class="flex items-center gap-2">
                            <span class="h-2.5 w-2.5 rounded-full bg-info-500"></span>
                            Under Review
                        </span>
                        <span class="inline-flex h-6 items-center rounded-full bg-neutral-100 px-2 text-xs font-semibold text-neutral-700">{{ $statusCounts['under_review'] ?? 0 }}</span>
                    </div>
                    <div class="flex items-center justify-between rounded-xl border border-neutral-200 bg-white px-4 py-3 text-sm font-semibold text-neutral-900">
                        <span class="flex items-center gap-2">
                            <span class="h-2.5 w-2.5 rounded-full bg-success-500"></span>
                            Accepted
                        </span>
                        <span class="inline-flex h-6 items-center rounded-full bg-neutral-100 px-2 text-xs font-semibold text-neutral-700">{{ $statusCounts['accepted'] ?? 0 }}</span>
                    </div>
                    <div class="flex items-center justify-between rounded-xl border border-neutral-200 bg-white px-4 py-3 text-sm font-semibold text-neutral-900">
                        <span class="flex items-center gap-2">
                            <span class="h-2.5 w-2.5 rounded-full bg-danger-500"></span>
                            Rejected
                        </span>
                        <span class="inline-flex h-6 items-center rounded-full bg-neutral-100 px-2 text-xs font-semibold text-neutral-700">{{ $statusCounts['rejected'] ?? 0 }}</span>
                    </div>
                    <div class="flex items-center justify-between rounded-xl border border-neutral-200 bg-white px-4 py-3 text-sm font-semibold text-neutral-900">
                        <span class="flex items-center gap-2">
                            <span class="h-2.5 w-2.5 rounded-full bg-neutral-400"></span>
                            Withdrawn
                        </span>
                        <span class="inline-flex h-6 items-center rounded-full bg-neutral-100 px-2 text-xs font-semibold text-neutral-700">{{ $statusCounts['withdrawn'] ?? 0 }}</span>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-neutral-200 bg-white p-5 shadow-card sm:p-6">
                <h2 class="text-sm font-semibold text-neutral-900">Application Tips</h2>
                <p class="mt-1 text-sm text-neutral-600">Small improvements that can move your application forward.</p>

                <div class="mt-4 space-y-3 text-sm text-neutral-700">
                    <div class="flex items-start gap-3">
                        <span class="mt-1 h-2 w-2 rounded-full bg-primary-600"></span>
                        <span>Follow up within 5–7 days if you have not heard back.</span>
                    </div>
                    <div class="flex items-start gap-3">
                        <span class="mt-1 h-2 w-2 rounded-full bg-primary-600"></span>
                        <span>Tailor your resume keywords to match the role description.</span>
                    </div>
                    <div class="flex items-start gap-3">
                        <span class="mt-1 h-2 w-2 rounded-full bg-primary-600"></span>
                        <span>Keep your profile up-to-date so recruiters can review quickly.</span>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-neutral-200 bg-white p-5 shadow-card sm:p-6">
                <h2 class="text-sm font-semibold text-neutral-900">Keep applying</h2>
                <p class="mt-1 text-sm text-neutral-600">Browse new roles and submit more applications to increase your chances.</p>
                <a href="{{ route('student.internships.search') }}" class="mt-5 inline-flex h-11 w-full items-center justify-center rounded-xl bg-primary-600 px-5 text-sm font-semibold text-white shadow-soft transition hover:bg-primary-500 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-primary-500/25">
                    Find new internships
                </a>
            </div>
        </aside>
    </div>
</div>
