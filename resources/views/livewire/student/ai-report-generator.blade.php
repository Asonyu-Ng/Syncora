@php
    $statCards = [
        [
            'title' => 'Smart Analysis',
            'body' => 'AI analyzes your logbook, tasks and activities to create comprehensive reports.',
            'icon' => 'sparkles',
            'icon_bg' => 'bg-secondary-50 text-secondary-700',
        ],
        [
            'title' => 'Time Saving',
            'body' => 'Generate detailed reports in minutes instead of hours of manual writing.',
            'icon' => 'clock',
            'icon_bg' => 'bg-success-50 text-success-700',
        ],
        [
            'title' => 'Professional Quality',
            'body' => 'Get well-structured, academic reports ready for submission and evaluation.',
            'icon' => 'badge',
            'icon_bg' => 'bg-warning-50 text-warning-700',
        ],
    ];

    $templateCards = [
        ['key' => 'final', 'title' => 'Final Internship Report', 'desc' => 'Complete analysis of your internship experience', 'icon_bg' => 'bg-primary-50 text-primary-700'],
        ['key' => 'monthly', 'title' => 'Monthly Progress Report', 'desc' => 'Monthly summary of activities and progress', 'icon_bg' => 'bg-success-50 text-success-700'],
        ['key' => 'technical', 'title' => 'Technical Report', 'desc' => 'Technical skills, projects and implementation details', 'icon_bg' => 'bg-info-50 text-info-700'],
        ['key' => 'summary', 'title' => 'Executive Summary', 'desc' => 'High-level overview for quick assessment', 'icon_bg' => 'bg-warning-50 text-warning-700'],
    ];
@endphp

<div class="space-y-8">
    <div class="flex flex-col gap-3">
        <h1 class="text-3xl font-semibold text-neutral-900 tracking-tight">AI Report Generator</h1>
        <p class="text-sm text-neutral-600">Generate professional internship reports using AI based on your logbook entries and activities.</p>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-12">
        <div class="space-y-6 lg:col-span-8">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                @foreach($statCards as $card)
                    <div class="rounded-2xl border border-neutral-200 bg-white p-5 shadow-card sm:p-6">
                        <div class="flex items-start gap-3">
                            <div class="flex h-11 w-11 items-center justify-center rounded-2xl {{ $card['icon_bg'] }}">
                                @if($card['icon'] === 'sparkles')
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3l1 2m12-2l-1 2M12 2l1 3m-2 0l1-3m-7 9l2 1m14-1l-2 1M4 12l3 1m13-1l-3 1M7 21l1-2m8 2l-1-2M12 22l-1-3m2 0l-1 3" />
                                    </svg>
                                @elseif($card['icon'] === 'clock')
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                @else
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5-1a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                @endif
                            </div>
                            <div class="min-w-0">
                                <div class="text-sm font-semibold text-neutral-900">{{ $card['title'] }}</div>
                                <div class="mt-1 text-sm text-neutral-600">{{ $card['body'] }}</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="rounded-2xl border border-neutral-200 bg-white p-5 shadow-card sm:p-6">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <h2 class="text-sm font-semibold text-neutral-900">Generate New Report</h2>
                        <p class="mt-1 text-sm text-neutral-600">Select report type and configure your preferences.</p>
                    </div>
                </div>

                <div class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-12">
                    <div class="space-y-5 lg:col-span-7">
                        <div>
                            <label class="block text-sm font-semibold text-neutral-900" for="report-type">Report Type</label>
                            <div class="mt-2">
                                <select id="report-type" wire:model.live="reportType" class="h-11 w-full rounded-xl border border-neutral-200 bg-white px-3 text-sm font-semibold text-neutral-900 shadow-soft focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20">
                                    @foreach($reportTypes as $type)
                                        <option value="{{ $type['key'] }}">{{ $type['label'] }}</option>
                                    @endforeach
                                </select>
                                <p class="mt-2 text-xs font-semibold text-neutral-500">
                                    {{ collect($reportTypes)->firstWhere('key', $reportType)['description'] ?? '' }}
                                </p>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-neutral-900" for="report-internship">Internship</label>
                            <div class="mt-2">
                                <select id="report-internship" wire:model.live="internshipId" class="h-11 w-full rounded-xl border border-neutral-200 bg-white px-3 text-sm font-semibold text-neutral-900 shadow-soft focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20">
                                    <option value="">Select internship</option>
                                    @foreach($internships as $internship)
                                        <option value="{{ $internship['id'] }}">{{ $internship['label'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-neutral-900">Report Period</label>
                            <div class="mt-2 grid grid-cols-1 gap-3 sm:grid-cols-2">
                                <input type="date" wire:model.defer="periodStart" class="h-11 w-full rounded-xl border border-neutral-200 bg-white px-3 text-sm font-semibold text-neutral-900 shadow-soft focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20" />
                                <input type="date" wire:model.defer="periodEnd" class="h-11 w-full rounded-xl border border-neutral-200 bg-white px-3 text-sm font-semibold text-neutral-900 shadow-soft focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20" />
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-neutral-900">Include in Report</label>
                            <div class="mt-3 grid grid-cols-1 gap-3 sm:grid-cols-2">
                                <label class="flex items-center justify-between rounded-xl border border-neutral-200 bg-white px-4 py-3 text-sm font-semibold text-neutral-700 shadow-soft">
                                    <span class="flex items-center gap-2">
                                        <input type="checkbox" wire:model.live="includeLogbooks" class="h-4 w-4 rounded border-neutral-300 text-primary-600 focus:ring-primary-500/20" />
                                        Logbook Entries ({{ $includeCounts['logbooks'] }})
                                    </span>
                                </label>
                                <label class="flex items-center justify-between rounded-xl border border-neutral-200 bg-white px-4 py-3 text-sm font-semibold text-neutral-700 shadow-soft">
                                    <span class="flex items-center gap-2">
                                        <input type="checkbox" wire:model.live="includeTasks" class="h-4 w-4 rounded border-neutral-300 text-primary-600 focus:ring-primary-500/20" />
                                        Completed Tasks ({{ $includeCounts['completed_tasks'] }})
                                    </span>
                                </label>
                                <label class="flex items-center justify-between rounded-xl border border-neutral-200 bg-white px-4 py-3 text-sm font-semibold text-neutral-700 shadow-soft">
                                    <span class="flex items-center gap-2">
                                        <input type="checkbox" wire:model.live="includeSkills" class="h-4 w-4 rounded border-neutral-300 text-primary-600 focus:ring-primary-500/20" />
                                        Skills & Technologies
                                    </span>
                                </label>
                                <label class="flex items-center justify-between rounded-xl border border-neutral-200 bg-white px-4 py-3 text-sm font-semibold text-neutral-700 shadow-soft">
                                    <span class="flex items-center gap-2">
                                        <input type="checkbox" wire:model.live="includeChallenges" class="h-4 w-4 rounded border-neutral-300 text-primary-600 focus:ring-primary-500/20" />
                                        Challenges & Solutions
                                    </span>
                                </label>
                                <label class="flex items-center justify-between rounded-xl border border-neutral-200 bg-white px-4 py-3 text-sm font-semibold text-neutral-700 shadow-soft sm:col-span-2">
                                    <span class="flex items-center gap-2">
                                        <input type="checkbox" wire:model.live="includeFeedback" class="h-4 w-4 rounded border-neutral-300 text-primary-600 focus:ring-primary-500/20" />
                                        Feedback & Evaluations
                                    </span>
                                </label>
                            </div>
                        </div>

                        <div class="rounded-2xl border border-primary-100 bg-primary-50 px-4 py-3 text-sm font-semibold text-primary-900">
                            AI will use your logbook entries, tasks, and activities to generate a personalized report.
                        </div>
                    </div>

                    <div class="lg:col-span-5">
                        <div class="flex h-full flex-col justify-between rounded-2xl border border-neutral-200 bg-neutral-50 p-5">
                            <div class="flex flex-col items-center text-center">
                                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-primary-600 text-white">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 6H7a2 2 0 01-2-2V4a2 2 0 012-2h7l5 5v13a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <div class="mt-4 text-sm font-semibold text-neutral-900">Report Preview</div>
                                <p class="mt-2 text-sm text-neutral-600">{{ $preview['body'] }}</p>
                                @if($preview['include_label'])
                                    <p class="mt-3 text-xs font-semibold text-neutral-500">{{ $preview['include_label'] }}</p>
                                @endif
                            </div>

                            <div class="mt-6">
                                <button type="button" wire:click="generateReport" class="inline-flex h-11 w-full items-center justify-center rounded-xl bg-primary-600 px-5 text-sm font-semibold text-white shadow-soft transition hover:bg-primary-500 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-primary-500/25">
                                    Generate Report
                                </button>
                                @if($status !== '')
                                    <div class="mt-3 text-center text-xs font-semibold text-neutral-500">{{ $status }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-neutral-200 bg-white p-5 shadow-card sm:p-6">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <h2 class="text-sm font-semibold text-neutral-900">Report Templates</h2>
                        <p class="mt-1 text-sm text-neutral-600">Choose from different report templates.</p>
                    </div>
                </div>

                <div class="mt-5 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach($templateCards as $card)
                        <button type="button" wire:click="selectTemplate('{{ $card['key'] }}')" class="rounded-2xl border p-4 text-left shadow-soft transition focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-primary-500/25 {{ $reportType === $card['key'] ? 'border-primary-300 bg-primary-50' : 'border-neutral-200 bg-white hover:bg-neutral-50' }}">
                            <div class="flex items-start justify-between gap-3">
                                <div class="flex h-11 w-11 items-center justify-center rounded-2xl {{ $card['icon_bg'] }}">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 6H7a2 2 0 01-2-2V4a2 2 0 012-2h7l5 5v13a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                @if($reportType === $card['key'])
                                    <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-primary-600 text-white">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </span>
                                @endif
                            </div>
                            <div class="mt-4 text-sm font-semibold text-neutral-900">{{ $card['title'] }}</div>
                            <div class="mt-1 text-sm text-neutral-600">{{ $card['desc'] }}</div>
                        </button>
                    @endforeach
                </div>
            </div>
        </div>

        <aside class="space-y-6 lg:col-span-4">
            <div class="rounded-2xl border border-neutral-200 bg-white p-5 shadow-card sm:p-6">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <h2 class="text-sm font-semibold text-neutral-900">AI Assistant</h2>
                        <p class="mt-1 text-sm text-neutral-600">Personalized tips to improve your report quality.</p>
                    </div>
                    <span class="inline-flex items-center rounded-full bg-primary-50 px-3 py-1 text-xs font-semibold text-primary-700 ring-1 ring-inset ring-primary-100">Beta</span>
                </div>

                <div class="mt-5 rounded-2xl border border-neutral-200 bg-neutral-50 p-4">
                    <div class="flex items-start gap-3">
                        <div class="mt-0.5 flex h-10 w-10 items-center justify-center rounded-2xl bg-primary-600 text-white">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 6H7a2 2 0 01-2-2V4a2 2 0 012-2h7l5 5v13a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <div class="text-sm font-semibold text-neutral-900">Hi {{ auth()->user()?->name ?? 'there' }}! I can help you generate amazing reports. Here are some tips:</div>
                            <ul class="mt-3 space-y-2 text-sm text-neutral-700">
                                <li class="flex items-center gap-2">
                                    <span class="inline-flex h-5 w-5 items-center justify-center rounded-full bg-success-50 text-success-700">
                                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </span>
                                    Keep your logbook entries updated
                                </li>
                                <li class="flex items-center gap-2">
                                    <span class="inline-flex h-5 w-5 items-center justify-center rounded-full bg-success-50 text-success-700">
                                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </span>
                                    Be specific about your activities
                                </li>
                                <li class="flex items-center gap-2">
                                    <span class="inline-flex h-5 w-5 items-center justify-center rounded-full bg-success-50 text-success-700">
                                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </span>
                                    Include challenges you faced
                                </li>
                                <li class="flex items-center gap-2">
                                    <span class="inline-flex h-5 w-5 items-center justify-center rounded-full bg-success-50 text-success-700">
                                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </span>
                                    Highlight your achievements
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <button type="button" wire:click="openAssistant" class="mt-5 inline-flex h-11 w-full items-center justify-center rounded-xl border border-primary-200 bg-white px-5 text-sm font-semibold text-primary-700 shadow-soft transition hover:bg-primary-50 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-primary-500/25">
                    Ask AI Assistant
                    <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>

            <div class="rounded-2xl border border-neutral-200 bg-white p-5 shadow-card sm:p-6">
                <div class="flex items-start justify-between gap-3">
                    <h2 class="text-sm font-semibold text-neutral-900">Recent Reports</h2>
                    <a href="{{ route('student.reports.ai') }}" class="text-sm font-semibold text-primary-700 hover:text-primary-800">View All</a>
                </div>

                <div class="mt-5 space-y-3">
                    @forelse($recentReports as $report)
                        @php
                            $statusLabel = $report['status'] === 'ready' ? 'Completed' : Str::headline((string) $report['status']);
                            $statusClass = $report['status'] === 'ready'
                                ? 'bg-success-50 text-success-700 ring-success-100'
                                : 'bg-warning-50 text-warning-700 ring-warning-100';
                            $iconBg = $report['icon'] === 'code'
                                ? 'bg-info-50 text-info-700'
                                : ($report['icon'] === 'calendar' ? 'bg-success-50 text-success-700' : 'bg-primary-50 text-primary-700');
                        @endphp
                        <div class="flex items-start justify-between gap-3 rounded-2xl border border-neutral-200 bg-white p-4 shadow-soft">
                            <div class="flex min-w-0 items-start gap-3">
                                <div class="mt-0.5 flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl {{ $iconBg }}">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 6H7a2 2 0 01-2-2V4a2 2 0 012-2h7l5 5v13a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <div class="text-sm font-semibold text-neutral-900 line-clamp-2">{{ $report['name'] }}</div>
                                    <div class="mt-1 text-xs font-semibold text-neutral-500">{{ $report['date'] }} • {{ $report['pages'] }} pages</div>
                                    <div class="mt-2 inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold ring-1 ring-inset {{ $statusClass }}">{{ $statusLabel }}</div>
                                </div>
                            </div>
                            <button type="button" wire:click="openReport({{ $report['id'] }})" class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-neutral-200 bg-white text-neutral-500 shadow-soft transition hover:bg-neutral-50 hover:text-neutral-900">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v12m0 0l-4-4m4 4l4-4M4 20h16" />
                                </svg>
                            </button>
                        </div>
                    @empty
                        <div class="rounded-2xl border border-dashed border-neutral-200 bg-white p-8 text-center text-sm text-neutral-600">
                            No reports generated yet.
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="rounded-2xl border border-neutral-200 bg-white p-5 shadow-card sm:p-6">
                <div class="flex items-start justify-between gap-3">
                    <h2 class="text-sm font-semibold text-neutral-900">Report Statistics</h2>
                    <span class="text-sm font-semibold text-primary-700">This Internship Period</span>
                </div>

                <div class="mt-5 grid grid-cols-2 gap-4">
                    <div class="rounded-2xl border border-neutral-200 bg-white p-4 shadow-soft">
                        <div class="text-xs font-semibold text-neutral-500">Reports Generated</div>
                        <div class="mt-2 text-2xl font-semibold text-neutral-900">{{ $stats['reports_generated'] }}</div>
                    </div>
                    <div class="rounded-2xl border border-neutral-200 bg-white p-4 shadow-soft">
                        <div class="text-xs font-semibold text-neutral-500">Logbook Entries Analyzed</div>
                        <div class="mt-2 text-2xl font-semibold text-neutral-900">{{ $stats['logbooks_analyzed'] }}</div>
                    </div>
                    <div class="rounded-2xl border border-neutral-200 bg-white p-4 shadow-soft">
                        <div class="text-xs font-semibold text-neutral-500">Tasks Completed</div>
                        <div class="mt-2 text-2xl font-semibold text-neutral-900">{{ $stats['tasks_completed'] }}</div>
                    </div>
                    <div class="rounded-2xl border border-neutral-200 bg-white p-4 shadow-soft">
                        <div class="text-xs font-semibold text-neutral-500">Data Quality Score</div>
                        <div class="mt-2 text-2xl font-semibold text-neutral-900">{{ $stats['quality_score'] }}%</div>
                    </div>
                </div>
            </div>
        </aside>
    </div>

    <x-modal name="ai-report-preview" focusable maxWidth="2xl">
        <div class="p-6">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h2 class="text-lg font-semibold text-neutral-900">{{ $activeReport['name'] ?? 'Report' }}</h2>
                    @if(isset($activeReport['generated']))
                        <p class="mt-2 text-sm font-semibold text-neutral-500">Generated {{ $activeReport['generated'] }}</p>
                    @endif
                </div>
                <button type="button" wire:click="closeReport" class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-neutral-200 bg-white text-neutral-500 shadow-soft transition hover:bg-neutral-50 hover:text-neutral-900">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="mt-5 rounded-2xl border border-neutral-200 bg-white p-5 text-sm text-neutral-800 whitespace-pre-line">
                {{ $activeReport['content'] ?? '' }}
            </div>

            <div class="mt-6 flex justify-end">
                <button type="button" wire:click="closeReport" class="inline-flex h-11 items-center justify-center rounded-xl border border-neutral-200 bg-white px-5 text-sm font-semibold text-neutral-900 shadow-soft transition hover:bg-neutral-50">
                    Close
                </button>
            </div>
        </div>
    </x-modal>

    <x-modal name="ai-assistant" focusable maxWidth="2xl">
        <div class="p-6">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h2 class="text-lg font-semibold text-neutral-900">Ask AI Assistant</h2>
                    <p class="mt-2 text-sm text-neutral-600">Ask for help improving your report, structure, or summary.</p>
                </div>
                <button type="button" x-on:click="$dispatch('close-modal', 'ai-assistant')" class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-neutral-200 bg-white text-neutral-500 shadow-soft transition hover:bg-neutral-50 hover:text-neutral-900">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="mt-5 space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-neutral-900" for="assistant-question">Question</label>
                    <div class="mt-2">
                        <textarea id="assistant-question" rows="4" wire:model.defer="assistantQuestion" class="w-full rounded-xl border border-neutral-200 bg-white px-3 py-3 text-sm font-semibold text-neutral-900 shadow-soft placeholder:text-neutral-400 focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20"></textarea>
                    </div>
                </div>

                <button type="button" wire:click="askAssistant" class="inline-flex h-11 w-full items-center justify-center rounded-xl bg-primary-600 px-5 text-sm font-semibold text-white shadow-soft transition hover:bg-primary-500 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-primary-500/25">
                    Get Suggestions
                </button>

                @if($assistantAnswer !== '')
                    <div class="rounded-2xl border border-neutral-200 bg-white p-5 text-sm text-neutral-800 whitespace-pre-line">
                        {{ $assistantAnswer }}
                    </div>
                @endif
            </div>
        </div>
    </x-modal>
</div>
