@php
    $sentCollection = collect($sent);
@endphp

<div class="space-y-6">
    <div class="overflow-hidden rounded-[28px] border border-neutral-200 bg-gradient-to-r from-white via-white to-primary-50/60 shadow-card">
        <div class="grid gap-6 px-6 py-6 lg:grid-cols-[1.1fr_0.9fr] lg:px-8">
            <div class="min-w-0">
                <span class="inline-flex items-center rounded-full border border-primary-100 bg-white px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.16em] text-primary-700 shadow-soft">
                    Communications hub
                </span>
                <h1 class="mt-4 text-3xl font-semibold tracking-tight text-neutral-950">Prepare platform announcements and keep recent sends easy to review.</h1>
                <p class="mt-3 max-w-2xl text-sm leading-6 text-neutral-600">
                    Use this workspace to reach students, supervisors, companies, or the full platform with clear operational messages while preserving the current send flow.
                </p>
            </div>

            <div class="rounded-3xl border border-neutral-200 bg-white/90 p-5 shadow-soft">
                <div class="text-[11px] font-semibold uppercase tracking-[0.16em] text-neutral-500">Messaging snapshot</div>
                <div class="mt-4 grid gap-3 sm:grid-cols-2">
                    <div class="rounded-2xl border border-neutral-200 bg-white px-4 py-3">
                        <div class="text-2xl font-semibold tracking-tight text-neutral-950">{{ $sentCollection->count() }}</div>
                        <div class="mt-1 text-xs font-semibold uppercase tracking-[0.14em] text-neutral-400">Recent sends</div>
                    </div>
                    <div class="rounded-2xl border border-neutral-200 bg-white px-4 py-3">
                        <div class="text-2xl font-semibold tracking-tight text-neutral-950">{{ ucfirst($audience) }}</div>
                        <div class="mt-1 text-xs font-semibold uppercase tracking-[0.14em] text-neutral-400">Current audience</div>
                    </div>
                </div>
                <p class="mt-4 text-xs leading-5 text-neutral-500">Compose targeted updates on the left and confirm what was recently delivered on the right.</p>
            </div>
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-[1.1fr_0.9fr]">
        <x-widget title="Compose Announcement" :collapsible="true">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div class="md:col-span-1">
                    <label class="text-xs font-semibold uppercase tracking-[0.14em] text-neutral-500">Audience</label>
                    <select
                        wire:model="audience"
                        class="mt-2 h-12 w-full rounded-2xl border border-neutral-200 bg-white px-4 text-sm text-neutral-900 shadow-soft focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20"
                    >
                        <option value="all">All</option>
                        <option value="students">Students</option>
                        <option value="supervisors">Supervisors</option>
                        <option value="companies">Companies</option>
                    </select>
                </div>

                <div class="md:col-span-1">
                    <label class="text-xs font-semibold uppercase tracking-[0.14em] text-neutral-500">Subject</label>
                    <input
                        type="text"
                        wire:model="subject"
                        class="mt-2 h-12 w-full rounded-2xl border border-neutral-200 bg-white px-4 text-sm text-neutral-900 shadow-soft placeholder:text-neutral-400 focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20"
                        placeholder="Platform update subject"
                    />
                </div>

                <div class="md:col-span-2">
                    <label class="text-xs font-semibold uppercase tracking-[0.14em] text-neutral-500">Message</label>
                    <textarea
                        rows="5"
                        wire:model="message"
                        class="mt-2 w-full rounded-[24px] border border-neutral-200 bg-white px-4 py-3 text-sm text-neutral-900 shadow-soft placeholder:text-neutral-400 focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20"
                        placeholder="Share the update, timing, and any action recipients should take."
                    ></textarea>
                </div>

                <div class="md:col-span-2 flex items-center justify-between gap-3 rounded-2xl border border-neutral-200 bg-neutral-50 px-4 py-4">
                    <p class="text-sm leading-6 text-neutral-600">Messages sent here are intended for operational communication and broadcast updates across the platform.</p>
                    <button
                        type="button"
                        wire:click="send"
                        class="inline-flex h-11 items-center justify-center rounded-xl bg-primary-600 px-5 text-sm font-semibold text-white shadow-soft transition hover:bg-primary-500"
                    >
                        Send announcement
                    </button>
                </div>
            </div>
        </x-widget>

        <x-widget title="Recently Sent" :collapsible="true">
            <div class="space-y-3">
                @forelse($sent as $item)
                    <div class="rounded-2xl border border-neutral-200 bg-white px-4 py-4">
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0">
                                <div class="text-sm font-semibold text-neutral-950">{{ $item['subject'] }}</div>
                                <div class="mt-1 text-xs leading-5 text-neutral-500">Audience: {{ ucfirst($item['audience']) }}</div>
                            </div>
                            <span class="rounded-full bg-neutral-100 px-2.5 py-1 text-[11px] font-semibold uppercase tracking-[0.14em] text-neutral-500">
                                {{ $item['time'] }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="rounded-2xl border border-dashed border-neutral-300 bg-neutral-50 px-4 py-8 text-center text-sm text-neutral-500">
                        No announcements have been sent yet. Your next platform update will appear here once delivered.
                    </div>
                @endforelse
            </div>
        </x-widget>
    </div>
</div>
