@php
    $userCollection = collect($users);
    $activeUsers = $userCollection->where('status', 'Active')->count();
    $suspendedUsers = $userCollection->where('status', 'Suspended')->count();
    $rolesCovered = $userCollection->pluck('role')->unique()->count();
@endphp

<div class="space-y-6">
    <div class="overflow-hidden rounded-[28px] border border-neutral-200 bg-gradient-to-r from-white via-white to-primary-50/60 shadow-card">
        <div class="grid gap-6 px-6 py-6 lg:grid-cols-[1.1fr_0.9fr] lg:px-8">
            <div class="min-w-0">
                <span class="inline-flex items-center rounded-full border border-primary-100 bg-white px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.16em] text-primary-700 shadow-soft">
                    Account oversight
                </span>
                <h1 class="mt-4 text-3xl font-semibold tracking-tight text-neutral-950">Manage user access and keep platform account health visible.</h1>
                <p class="mt-3 max-w-2xl text-sm leading-6 text-neutral-600">
                    Review role coverage, reactivate trusted users, and suspend accounts that need admin follow-up without changing the current Livewire workflow.
                </p>
            </div>

            <div class="rounded-3xl border border-neutral-200 bg-white/90 p-5 shadow-soft">
                <div class="text-[11px] font-semibold uppercase tracking-[0.16em] text-neutral-500">Current snapshot</div>
                <div class="mt-4 grid gap-3 sm:grid-cols-3">
                    <div class="rounded-2xl border border-neutral-200 bg-white px-4 py-3">
                        <div class="text-2xl font-semibold tracking-tight text-neutral-950">{{ $userCollection->count() }}</div>
                        <div class="mt-1 text-xs font-semibold uppercase tracking-[0.14em] text-neutral-400">Total users</div>
                    </div>
                    <div class="rounded-2xl border border-neutral-200 bg-white px-4 py-3">
                        <div class="text-2xl font-semibold tracking-tight text-neutral-950">{{ $activeUsers }}</div>
                        <div class="mt-1 text-xs font-semibold uppercase tracking-[0.14em] text-neutral-400">Active now</div>
                    </div>
                    <div class="rounded-2xl border border-neutral-200 bg-white px-4 py-3">
                        <div class="text-2xl font-semibold tracking-tight text-neutral-950">{{ $suspendedUsers }}</div>
                        <div class="mt-1 text-xs font-semibold uppercase tracking-[0.14em] text-neutral-400">Suspended</div>
                    </div>
                </div>
                <p class="mt-4 text-xs leading-5 text-neutral-500">
                    Roles currently represented: {{ $rolesCovered }}. Use the actions below to restore or limit access while preserving the existing data source.
                </p>
            </div>
        </div>
    </div>

    <x-widget title="Users" :collapsible="true">
        <div class="overflow-hidden rounded-[24px] border border-neutral-200 bg-white">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-neutral-200">
                    <thead class="bg-neutral-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-[11px] font-semibold uppercase tracking-[0.16em] text-neutral-500">Name</th>
                            <th class="px-4 py-3 text-left text-[11px] font-semibold uppercase tracking-[0.16em] text-neutral-500">Email</th>
                            <th class="px-4 py-3 text-left text-[11px] font-semibold uppercase tracking-[0.16em] text-neutral-500">Role</th>
                            <th class="px-4 py-3 text-left text-[11px] font-semibold uppercase tracking-[0.16em] text-neutral-500">Status</th>
                            <th class="px-4 py-3 text-right text-[11px] font-semibold uppercase tracking-[0.16em] text-neutral-500">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-200 bg-white">
                        @forelse($users as $index => $user)
                            <tr class="transition-colors hover:bg-neutral-50">
                                <td class="px-4 py-4 text-sm font-semibold text-neutral-950">{{ $user['name'] }}</td>
                                <td class="px-4 py-4 text-sm text-neutral-600">{{ $user['email'] }}</td>
                                <td class="px-4 py-4 text-sm text-neutral-600">
                                    <span class="inline-flex items-center rounded-full bg-neutral-100 px-2.5 py-1 text-xs font-semibold text-neutral-700">
                                        {{ ucfirst($user['role']) }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-sm">
                                    <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold {{ $user['status'] === 'Active' ? 'bg-success-50 text-success-700 ring-1 ring-inset ring-success-100' : 'bg-rose-50 text-rose-700 ring-1 ring-inset ring-rose-100' }}">
                                        {{ $user['status'] }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm text-right">
                                    <div class="inline-flex items-center gap-2">
                                        <button
                                            type="button"
                                            wire:click="activate({{ $index }})"
                                            class="rounded-xl bg-success-600 px-3 py-2 text-xs font-semibold text-white transition hover:bg-success-500"
                                        >
                                            Activate
                                        </button>
                                        <button
                                            type="button"
                                            wire:click="suspend({{ $index }})"
                                            class="rounded-xl bg-rose-600 px-3 py-2 text-xs font-semibold text-white transition hover:bg-rose-500"
                                        >
                                            Suspend
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-12 text-center text-sm text-neutral-500">No user accounts are available yet. New registrations will appear here for review.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </x-widget>
</div>
