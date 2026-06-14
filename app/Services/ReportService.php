<?php

namespace App\Services;

use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class ReportService
{
    public function supervisorReportDefinitions(): array
    {
        return [
            [
                'type' => 'monthly',
                'name' => 'Monthly Progress Report',
                'description' => 'Summarizes intern progress, activities, and highlights for the month.',
            ],
            [
                'type' => 'technical',
                'name' => 'Technical Implementation Report',
                'description' => 'Focuses on tools, implementation details, and technical outcomes.',
            ],
            [
                'type' => 'final',
                'name' => 'Final Internship Report',
                'description' => 'Captures final deliverables, learnings, and evaluation outcomes.',
            ],
        ];
    }

    public function generateStudentReport(string $prompt, ?int $studentId = null): string
    {
        $student = $studentId !== null ? " (student: {$studentId})" : '';

        return "Generated report stub{$student} for: {$prompt}\n\nThis is a placeholder output. Service integration will provide real content.";
    }

    public function generateStudentReportFromContext(array $context): string
    {
        $reportType = (string) ($context['report_type'] ?? 'Internship Report');
        $studentName = (string) ($context['student_name'] ?? 'Student');
        $internshipTitle = (string) ($context['internship_title'] ?? 'Internship');
        $companyName = (string) ($context['company_name'] ?? '');
        $rangeLabel = (string) ($context['period_label'] ?? '');

        $logbooks = is_array($context['logbooks'] ?? null) ? $context['logbooks'] : [];
        $tasks = is_array($context['tasks'] ?? null) ? $context['tasks'] : [];
        $skills = is_array($context['skills'] ?? null) ? $context['skills'] : [];

        $titleLine = '# ' . $reportType;
        $metaLines = array_values(array_filter([
            '**Student:** ' . $studentName,
            '**Internship:** ' . $internshipTitle . ($companyName !== '' ? ' — ' . $companyName : ''),
            $rangeLabel !== '' ? '**Period:** ' . $rangeLabel : null,
            '**Generated:** ' . Carbon::now()->format('M j, Y'),
        ]));

        $sections = [];

        $sections[] = implode("\n", array_merge([$titleLine, ''], $metaLines, ['']));

        $sections[] = "## Executive Summary\n"
            . "This report summarizes internship progress, documented activities, and outcomes during the selected period.\n";

        if (count($logbooks) > 0) {
            $sections[] = "## Key Activities\n" . $this->bullets(
                collect($logbooks)
                    ->take(8)
                    ->map(fn (array $row): string => ($row['date'] ?? '—') . ' — ' . ($row['title'] ?? 'Logbook entry'))
                    ->all()
            );
        }

        if (count($tasks) > 0) {
            $sections[] = "## Task Outcomes\n" . $this->bullets(
                collect($tasks)
                    ->take(10)
                    ->map(fn (array $row): string => ($row['title'] ?? 'Task') . ($row['status'] ? ' (' . Str::headline((string) $row['status']) . ')' : ''))
                    ->all()
            );
        }

        if (count($skills) > 0) {
            $sections[] = "## Skills & Technologies\n" . $this->bullets(
                collect($skills)
                    ->unique()
                    ->take(12)
                    ->values()
                    ->all()
            );
        }

        $sections[] = "## Recommendations\n"
            . $this->bullets([
                'Continue logging activities consistently to strengthen evidence of progress.',
                'Add measurable outcomes (metrics, screenshots, links) to improve data quality.',
                'Align weekly goals with supervisor feedback for continuous improvement.',
            ]);

        $sections[] = "## Appendix: Logbook Highlights\n"
            . collect($logbooks)
                ->take(3)
                ->map(function (array $row): string {
                    $date = (string) ($row['date'] ?? '—');
                    $title = (string) ($row['title'] ?? 'Logbook entry');
                    $body = trim((string) ($row['body'] ?? ''));
                    $body = $body !== '' ? Str::limit($body, 700) : '—';

                    return "### {$date} — {$title}\n{$body}";
                })
                ->implode("\n\n");

        return trim(implode("\n\n", array_filter($sections)));
    }

    public function extractSkillsFromText(string $text): array
    {
        $normalized = preg_replace("/\r\n?/", "\n", $text) ?? '';
        $lines = collect(explode("\n", $normalized))
            ->map(fn (string $line): string => trim($line))
            ->filter()
            ->values();

        $candidates = [];

        foreach ($lines as $line) {
            if (Str::startsWith(Str::lower($line), ['tools:', 'skills:', 'technologies:'])) {
                $payload = trim((string) Str::after($line, ':'));
                $items = collect(explode(',', $payload))
                    ->map(fn (string $item): string => trim($item))
                    ->filter()
                    ->all();

                $candidates = array_merge($candidates, $items);
            }
        }

        return collect($candidates)
            ->map(fn (string $item): string => Str::title($item))
            ->unique()
            ->values()
            ->all();
    }

    public function regenerateReport(string $reportName, ?int $actorId = null): array
    {
        return [
            'name' => $reportName,
            'actorId' => $actorId,
            'status' => 'Queued',
            'queuedAt' => now()->toDateTimeString(),
        ];
    }

    public function listReports(array $filters = []): array
    {
        return [
            [
                'name' => 'Monthly Platform Summary',
                'type' => 'System',
                'generated' => '2026-05-01',
                'status' => 'Ready',
            ],
        ];
    }

    private function bullets(array $items): string
    {
        $items = array_values(array_filter($items, fn ($item): bool => is_string($item) && trim($item) !== ''));

        if (count($items) === 0) {
            return "- —";
        }

        return collect($items)
            ->map(fn (string $item): string => '- ' . $item)
            ->implode("\n");
    }
}
