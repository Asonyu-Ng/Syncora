<?php

namespace App\Livewire\Student;

use App\Models\Application;
use App\Models\Internship;
use App\Models\Logbook;
use App\Models\Report;
use App\Models\StudentProfile;
use App\Models\Task;
use App\Services\ReportService;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Livewire\Attributes\Url;
use Livewire\Component;

class AiReportGenerator extends Component
{
    #[Url]
    public string $reportType = 'final';

    #[Url]
    public ?int $internshipId = null;

    public string $periodStart = '';

    public string $periodEnd = '';

    public bool $includeLogbooks = true;

    public bool $includeTasks = true;

    public bool $includeSkills = true;

    public bool $includeChallenges = true;

    public bool $includeFeedback = false;

    public string $status = '';

    public ?int $activeReportId = null;

    public ?array $activePreview = null;

    public string $assistantQuestion = '';

    public string $assistantAnswer = '';

    public function mount(): void
    {
        $profile = $this->ensureStudentProfile();
        $internship = $this->defaultInternship($profile);

        $this->internshipId = $this->internshipId ?? $internship?->id;
        $now = Carbon::now();

        $start = $internship?->start_date instanceof Carbon
            ? $internship->start_date
            : $now->copy()->subDays(30);

        $this->periodStart = $this->periodStart !== '' ? $this->periodStart : $start->toDateString();
        $this->periodEnd = $this->periodEnd !== '' ? $this->periodEnd : $now->toDateString();
    }

    public function selectTemplate(string $key): void
    {
        $allowed = collect($this->reportTypeOptions())->pluck('key')->all();

        if (! in_array($key, $allowed, true)) {
            return;
        }

        $this->reportType = $key;
    }

    public function generateReport(): void
    {
        $this->validate([
            'reportType' => ['required', 'string'],
            'internshipId' => ['nullable', 'integer'],
            'periodStart' => ['required', 'date'],
            'periodEnd' => ['required', 'date', 'after_or_equal:periodStart'],
        ]);

        $profile = $this->ensureStudentProfile();
        $internship = $this->internshipId
            ? Internship::query()->with('companyProfile')->whereKey($this->internshipId)->first()
            : $this->defaultInternship($profile);

        if (! $internship) {
            $this->status = 'Select an internship to generate a report.';
            return;
        }

        $start = Carbon::parse($this->periodStart)->startOfDay();
        $end = Carbon::parse($this->periodEnd)->endOfDay();
        $readiness = $this->showcaseState($profile->id, $internship, $start, $end);

        if (! $readiness['enough_real_data']) {
            $this->status = 'Add a few more logbook entries and at least one completed task, or use Generate Sample Preview for a showcase version.';
            return;
        }

        $logbooks = $this->logbookQuery($profile->id, $internship->id, $start, $end)
            ->limit(60)
            ->get()
            ->map(function (Logbook $logbook): array {
                $parsed = $this->parseLogbookContent((string) $logbook->content);

                return [
                    'date' => $logbook->entry_date?->format('M j, Y'),
                    'title' => $parsed['title'],
                    'body' => $parsed['body'],
                ];
            })
            ->all();

        $tasks = $this->taskQuery($profile->id, $internship->id, $start, $end)
            ->limit(60)
            ->get()
            ->map(fn (Task $task): array => [
                'title' => $task->title,
                'status' => $task->status,
            ])
            ->all();

        $skills = [];

        if ($this->includeSkills) {
            $skills = collect($logbooks)
                ->flatMap(fn (array $entry): array => app(ReportService::class)->extractSkillsFromText(($entry['title'] ?? '') . "\n" . ($entry['body'] ?? '')))
                ->unique()
                ->values()
                ->all();
        }

        $context = [
            'report_type' => $this->reportTypeLabel($this->reportType),
            'student_name' => auth()->user()?->name ?? 'Student',
            'internship_title' => $internship->title,
            'company_name' => $internship->companyProfile?->company_name ?? '',
            'period_label' => $start->format('M j, Y') . ' - ' . $end->format('M j, Y'),
            'logbooks' => $this->includeLogbooks ? $logbooks : [],
            'tasks' => $this->includeTasks ? $tasks : [],
            'skills' => $skills,
        ];

        $this->status = 'Generating...';

        $content = app(ReportService::class)->generateStudentReportFromContext($context);
        $now = Carbon::now();

        $report = Report::create([
            'user_id' => auth()->id(),
            'internship_id' => $internship->id,
            'student_profile_id' => $profile->id,
            'name' => $this->reportTypeLabel($this->reportType),
            'type' => $this->reportType,
            'status' => 'ready',
            'content' => $content,
            'generated_at' => $now,
        ]);

        $this->activeReportId = $report->id;
        $this->activePreview = null;
        $this->dispatch('open-modal', 'ai-report-preview');

        $this->status = 'Done';
    }

    public function generateSamplePreview(): void
    {
        $profile = $this->ensureStudentProfile();
        $internship = $this->internshipId
            ? Internship::query()->with('companyProfile')->whereKey($this->internshipId)->first()
            : $this->defaultInternship($profile);

        $context = $this->sampleContext($internship);
        $content = app(ReportService::class)->generateStudentReportFromContext($context);

        $this->activeReportId = null;
        $this->activePreview = [
            'id' => null,
            'name' => $this->reportTypeLabel($this->reportType) . ' Showcase Preview',
            'generated' => 'Showcase sample',
            'source' => 'Showcase sample',
            'summary' => 'Built from curated sample internship activity for demo purposes.',
            'content' => $content,
        ];

        $this->status = 'Sample preview ready.';
        $this->dispatch('open-modal', 'ai-report-preview');
    }

    public function openReport(int $reportId): void
    {
        $this->activeReportId = $reportId;
        $this->activePreview = null;
        $this->dispatch('open-modal', 'ai-report-preview');
    }

    public function closeReport(): void
    {
        $this->activeReportId = null;
        $this->activePreview = null;
        $this->dispatch('close-modal', 'ai-report-preview');
    }

    public function openAssistant(): void
    {
        $this->assistantAnswer = '';
        $this->assistantQuestion = $this->assistantQuestion !== '' ? $this->assistantQuestion : 'Help me write a strong internship report summary.';
        $this->dispatch('open-modal', 'ai-assistant');
    }

    public function askAssistant(): void
    {
        $question = trim($this->assistantQuestion);

        if ($question === '') {
            return;
        }

        $this->assistantAnswer = app(ReportService::class)->generateStudentReport($question, auth()->id());
    }

    public function render(): View
    {
        $profile = $this->ensureStudentProfile();
        $internships = $this->availableInternships($profile->id);

        if ($this->internshipId === null && count($internships) > 0) {
            $this->internshipId = $internships[0]['id'];
        }

        $internship = $this->internshipId ? Internship::query()->with('companyProfile')->whereKey($this->internshipId)->first() : null;
        $start = $this->periodStart !== '' ? Carbon::parse($this->periodStart)->startOfDay() : Carbon::now()->subDays(30)->startOfDay();
        $end = $this->periodEnd !== '' ? Carbon::parse($this->periodEnd)->endOfDay() : Carbon::now()->endOfDay();
        $dashboardHref = Route::has('student.dashboard') ? route('student.dashboard') : '/student/dashboard';
        $reportsHref = Route::has('student.reports.ai') ? route('student.reports.ai') : '/student/ai-reports';
        $readiness = $this->showcaseState($profile->id, $internship, $start, $end);

        return view('livewire.student.ai-report-generator', [
            'title' => 'AI Report Generator',
            'breadcrumbs' => [
                ['label' => 'Dashboards', 'href' => '/__dashboards'],
                ['label' => 'Student Dashboard', 'href' => $dashboardHref],
                ['label' => 'Reports', 'href' => $reportsHref],
                ['label' => 'AI Reports', 'href' => null],
            ],
            'reportTypes' => $this->reportTypeOptions(),
            'internships' => $internships,
            'includeCounts' => $this->includeCounts($profile->id, $internship?->id, $start, $end),
            'recentReports' => $this->recentReports($profile->id),
            'stats' => $this->reportStats($profile->id, $internship?->id, $start, $end),
            'activeReport' => $this->activePreview ?? $this->activeReportPayload($profile->id),
            'preview' => $this->previewPayload($readiness, $internship, $start, $end),
            'readiness' => $readiness,
        ])->extends('layouts.dashboard')->section('content');
    }

    private function reportTypeOptions(): array
    {
        return [
            [
                'key' => 'final',
                'label' => 'Final Internship Report',
                'description' => 'Comprehensive report of your entire internship experience',
            ],
            [
                'key' => 'monthly',
                'label' => 'Monthly Progress Report',
                'description' => 'Monthly summary of activities and progress',
            ],
            [
                'key' => 'technical',
                'label' => 'Technical Implementation Report',
                'description' => 'Technical skills, projects, and implementation details',
            ],
            [
                'key' => 'summary',
                'label' => 'Executive Summary',
                'description' => 'High-level overview for quick assessment',
            ],
        ];
    }

    private function reportTypeLabel(string $key): string
    {
        $match = collect($this->reportTypeOptions())->firstWhere('key', $key);

        return (string) ($match['label'] ?? Str::headline($key));
    }

    private function previewPayload(array $readiness, ?Internship $internship, Carbon $start, Carbon $end): array
    {
        $typeLabel = $this->reportTypeLabel($this->reportType);
        $include = array_values(array_filter([
            $this->includeLogbooks ? 'logbook entries' : null,
            $this->includeTasks ? 'tasks' : null,
            $this->includeSkills ? 'skills & technologies' : null,
            $this->includeChallenges ? 'challenges & solutions' : null,
            $this->includeFeedback ? 'feedback & evaluations' : null,
        ]));

        $counts = [
            'logbooks' => $this->includeLogbooks ? $readiness['logbooks'] : 0,
            'tasks' => $this->includeTasks ? $readiness['completed_tasks'] : 0,
            'skills' => $this->includeSkills ? max(0, (int) ($readiness['skills'] ?? 0)) : 0,
        ];
        $periodLabel = $start->format('M j, Y') . ' - ' . $end->format('M j, Y');
        $sourceLabel = $readiness['showcase_mode'] ? 'Showcase sample' : 'Real data';
        $internshipLabel = $internship?->title
            ? $internship->title . ($internship->companyProfile?->company_name ? ' - ' . $internship->companyProfile->company_name : '')
            : 'Curated internship sample';

        return [
            'title' => $typeLabel,
            'include_label' => count($include) > 0 ? 'Includes: ' . implode(', ', $include) . '.' : null,
            'body' => $readiness['showcase_mode']
                ? 'Preview built from curated sample internship activity so the workspace stays active even with limited student data.'
                : 'AI will analyze your selected data and generate a professional report including summary, achievements, skills gained, and recommendations.',
            'source' => $sourceLabel,
            'period' => $periodLabel,
            'internship' => $internshipLabel,
            'counts' => $counts,
            'summary' => $readiness['showcase_mode']
                ? 'Uses a few curated entries, task outcomes, and skills to demonstrate the final report experience.'
                : 'Uses your selected internship activity and currently available records in the chosen period.',
        ];
    }

    private function activeReportPayload(int $studentProfileId): ?array
    {
        if (! $this->activeReportId) {
            return null;
        }

        $report = Report::query()
            ->whereKey($this->activeReportId)
            ->where('student_profile_id', $studentProfileId)
            ->first();

        if (! $report) {
            return null;
        }

        return [
            'id' => $report->id,
            'name' => $report->name,
            'generated' => $report->generated_at?->format('M j, Y') ?? $report->created_at?->format('M j, Y'),
            'source' => 'Real data',
            'summary' => 'Generated from your saved internship activity and persisted to your reports.',
            'content' => (string) ($report->content ?? ''),
        ];
    }

    private function showcaseState(int $studentProfileId, ?Internship $internship, Carbon $start, Carbon $end): array
    {
        $counts = $this->includeCounts($studentProfileId, $internship?->id, $start, $end);
        $skills = $internship?->id
            ? collect($this->logbookQuery($studentProfileId, $internship->id, $start, $end)->limit(15)->get(['content']))
                ->flatMap(fn (Logbook $logbook): array => app(ReportService::class)->extractSkillsFromText((string) $logbook->content))
                ->unique()
                ->values()
                ->count()
            : 0;
        $enoughRealData = $internship !== null
            && $counts['logbooks'] >= 1
            && $counts['completed_tasks'] >= 1;

        return [
            'showcase_mode' => ! $enoughRealData,
            'enough_real_data' => $enoughRealData,
            'has_internship' => $internship !== null,
            'logbooks' => $counts['logbooks'],
            'completed_tasks' => $counts['completed_tasks'],
            'skills' => $skills,
            'internship_label' => $internship?->title
                ? $internship->title . ($internship->companyProfile?->company_name ? ' - ' . $internship->companyProfile->company_name : '')
                : 'Curated internship sample',
            'headline' => $enoughRealData ? 'Ready to generate from your data' : 'Showcase mode: preview with sample activity',
            'message' => $enoughRealData
                ? 'You already have enough activity in the selected period to generate a strong report from your own records.'
                : 'Your current activity is still light, so this page can demonstrate the report experience with a curated sample preview.',
            'missing' => array_values(array_filter([
                $internship === null ? 'Select an internship' : null,
                $counts['logbooks'] < 1 ? 'Add at least 1 detailed logbook entry' : null,
                $counts['completed_tasks'] < 1 ? 'Complete at least 1 task' : null,
            ])),
        ];
    }

    private function sampleContext(?Internship $internship): array
    {
        $studentName = auth()->user()?->name ?? 'Student User';
        $periodStart = $this->periodStart !== '' ? Carbon::parse($this->periodStart)->startOfDay() : Carbon::now()->subDays(14)->startOfDay();
        $periodEnd = $this->periodEnd !== '' ? Carbon::parse($this->periodEnd)->endOfDay() : Carbon::now()->endOfDay();
        $internshipTitle = $internship?->title ?? 'Software Engineering Internship';
        $companyName = $internship?->companyProfile?->company_name ?? 'Syncora Labs';
        $logbooks = [
            [
                'date' => $periodEnd->copy()->subDays(5)->format('M j, Y'),
                'title' => 'Implemented dashboard analytics cards',
                'body' => 'Built summary cards, refined spacing, and improved responsive behaviour for the student workspace. Tools: Laravel, Livewire, Tailwind CSS.',
            ],
            [
                'date' => $periodEnd->copy()->subDays(3)->format('M j, Y'),
                'title' => 'Documented internship workflow updates',
                'body' => 'Captured process changes, clarified task submission steps, and prepared notes for supervisor review. Tools: Laravel, Blade, Git.',
            ],
            [
                'date' => $periodEnd->copy()->subDay()->format('M j, Y'),
                'title' => 'Improved profile and settings usability',
                'body' => 'Adjusted form feedback, dark mode surfaces, and information hierarchy to make the workspace easier to use. Tools: Livewire, Tailwind CSS, UX writing.',
            ],
        ];
        $tasks = [
            ['title' => 'Refresh student dashboard components', 'status' => 'completed'],
            ['title' => 'Prepare weekly internship summary', 'status' => 'completed'],
            ['title' => 'Document UI feedback and fixes', 'status' => 'completed'],
        ];
        $skills = ['Laravel', 'Livewire', 'Tailwind Css', 'Blade', 'Git', 'Ui/Ux Review'];

        return [
            'report_type' => $this->reportTypeLabel($this->reportType),
            'student_name' => $studentName,
            'internship_title' => $internshipTitle,
            'company_name' => $companyName,
            'period_label' => $periodStart->format('M j, Y') . ' - ' . $periodEnd->format('M j, Y'),
            'logbooks' => $this->includeLogbooks ? $logbooks : [],
            'tasks' => $this->includeTasks ? $tasks : [],
            'skills' => $this->includeSkills ? $skills : [],
        ];
    }

    private function availableInternships(int $studentProfileId): array
    {
        $applicationInternships = Internship::query()
            ->with('companyProfile')
            ->whereHas('applications', fn (Builder $builder): Builder => $builder->where('student_profile_id', $studentProfileId))
            ->orderByDesc('id')
            ->limit(10)
            ->get();

        $logbookInternships = Internship::query()
            ->with('companyProfile')
            ->whereHas('logbooks', fn (Builder $builder): Builder => $builder->where('student_profile_id', $studentProfileId))
            ->orderByDesc('id')
            ->limit(10)
            ->get();

        return $applicationInternships
            ->merge($logbookInternships)
            ->unique('id')
            ->map(fn (Internship $internship): array => [
                'id' => $internship->id,
                'label' => $internship->title . ($internship->companyProfile?->company_name ? ' - ' . $internship->companyProfile->company_name : ''),
            ])
            ->values()
            ->all();
    }

    private function ensureStudentProfile(): StudentProfile
    {
        $user = auth()->user();

        return $user->studentProfile()->firstOrCreate();
    }

    private function defaultInternship(StudentProfile $profile): ?Internship
    {
        $application = Application::query()
            ->with(['internship.companyProfile'])
            ->where('student_profile_id', $profile->id)
            ->where('status', 'accepted')
            ->orderByDesc('decided_at')
            ->orderByDesc('updated_at')
            ->first();

        if ($application?->internship) {
            return $application->internship;
        }

        $logbook = Logbook::query()
            ->with(['internship.companyProfile'])
            ->where('student_profile_id', $profile->id)
            ->orderByDesc('entry_date')
            ->first();

        return $logbook?->internship;
    }

    private function includeCounts(int $studentProfileId, ?int $internshipId, Carbon $start, Carbon $end): array
    {
        $logbooks = $internshipId ? $this->logbookQuery($studentProfileId, $internshipId, $start, $end)->count() : 0;
        $completedTasks = $internshipId ? $this->taskQuery($studentProfileId, $internshipId, $start, $end)->where('status', 'completed')->count() : 0;

        return [
            'logbooks' => $logbooks,
            'completed_tasks' => $completedTasks,
        ];
    }

    private function reportStats(int $studentProfileId, ?int $internshipId, Carbon $start, Carbon $end): array
    {
        $reportsGenerated = Report::query()->where('student_profile_id', $studentProfileId)->count();
        $logbooks = $internshipId ? $this->logbookQuery($studentProfileId, $internshipId, $start, $end)->count() : 0;
        $tasksCompleted = $internshipId
            ? Task::query()
                ->where('student_profile_id', $studentProfileId)
                ->where('internship_id', $internshipId)
                ->where('status', 'completed')
                ->count()
            : 0;

        $quality = $this->dataQualityScore($studentProfileId, $internshipId, $start, $end);

        return [
            'reports_generated' => $reportsGenerated,
            'logbooks_analyzed' => $logbooks,
            'tasks_completed' => $tasksCompleted,
            'quality_score' => $quality,
        ];
    }

    private function dataQualityScore(int $studentProfileId, ?int $internshipId, Carbon $start, Carbon $end): int
    {
        if (! $internshipId) {
            return 0;
        }

        $entries = $this->logbookQuery($studentProfileId, $internshipId, $start, $end)->get(['content']);
        $count = max(1, $entries->count());

        $avgLength = (int) round($entries->map(fn (Logbook $l): int => Str::length((string) $l->content))->sum() / $count);
        $hasTools = $entries->filter(fn (Logbook $l): bool => str_contains(Str::lower((string) $l->content), 'tools:'))->count();

        $score = 0;
        $score += min(60, (int) round(min(1, $avgLength / 650) * 60));
        $score += min(40, (int) round(($hasTools / $count) * 40));

        return max(0, min(100, $score));
    }

    private function recentReports(int $studentProfileId): array
    {
        return Report::query()
            ->where('student_profile_id', $studentProfileId)
            ->orderByDesc('generated_at')
            ->orderByDesc('created_at')
            ->limit(4)
            ->get()
            ->map(fn (Report $report): array => [
                'id' => $report->id,
                'name' => $report->name,
                'date' => $report->generated_at?->format('M j, Y') ?? $report->created_at?->format('M j, Y'),
                'status' => $report->status,
                'pages' => $this->estimatePages((string) ($report->content ?? '')),
                'icon' => $report->type === 'technical' ? 'code' : ($report->type === 'monthly' ? 'calendar' : 'document'),
            ])
            ->all();
    }

    private function estimatePages(string $content): int
    {
        $words = str_word_count(strip_tags($content));

        return max(1, (int) ceil($words / 350));
    }

    private function logbookQuery(int $studentProfileId, int $internshipId, Carbon $start, Carbon $end): Builder
    {
        return Logbook::query()
            ->where('student_profile_id', $studentProfileId)
            ->where('internship_id', $internshipId)
            ->whereBetween('entry_date', [$start->toDateString(), $end->toDateString()]);
    }

    private function taskQuery(int $studentProfileId, int $internshipId, Carbon $start, Carbon $end): Builder
    {
        return Task::query()
            ->where('student_profile_id', $studentProfileId)
            ->where('internship_id', $internshipId)
            ->where(function (Builder $builder) use ($start, $end): void {
                $builder->whereBetween('created_at', [$start, $end])
                    ->orWhereBetween('completed_at', [$start, $end]);
            });
    }

    private function parseLogbookContent(string $content): array
    {
        $normalized = preg_replace("/\r\n?/", "\n", trim($content)) ?? '';

        if ($normalized === '') {
            return [
                'title' => 'Logbook entry',
                'body' => '',
            ];
        }

        $blocks = explode("\n\n", $normalized, 2);
        $candidateTitle = trim($blocks[0] ?? '');
        $body = trim($blocks[1] ?? '');

        if ($body === '' && Str::length($candidateTitle) > 120) {
            return [
                'title' => Str::limit($normalized, 80, ''),
                'body' => $normalized,
            ];
        }

        return [
            'title' => $candidateTitle !== '' ? Str::limit($candidateTitle, 90, '') : 'Logbook entry',
            'body' => $body,
        ];
    }
}
