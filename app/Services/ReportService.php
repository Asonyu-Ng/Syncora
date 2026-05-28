<?php

namespace App\Services;

class ReportService
{
    public function generateStudentReport(string $prompt, ?int $studentId = null): string
    {
        $student = $studentId !== null ? " (student: {$studentId})" : '';

        return "Generated report stub{$student} for: {$prompt}\n\nThis is a placeholder output. Service integration will provide real content.";
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
}

