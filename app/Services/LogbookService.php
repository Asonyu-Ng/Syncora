<?php

namespace App\Services;

use Illuminate\Support\Str;

class LogbookService
{
    public function submitEntry(int $studentId, string $date, int $hours, string $notes): array
    {
        return [
            'id' => Str::uuid()->toString(),
            'studentId' => $studentId,
            'date' => $date,
            'hours' => $hours,
            'notes' => $notes,
            'status' => 'Pending',
            'submittedAt' => now()->toDateTimeString(),
        ];
    }

    public function approveEntry(int|string $entryId, int $supervisorId): array
    {
        return [
            'id' => $entryId,
            'supervisorId' => $supervisorId,
            'status' => 'Approved',
            'updatedAt' => now()->toDateTimeString(),
        ];
    }

    public function rejectEntry(int|string $entryId, int $supervisorId, ?string $reason = null): array
    {
        return [
            'id' => $entryId,
            'supervisorId' => $supervisorId,
            'status' => 'Rejected',
            'reason' => $reason,
            'updatedAt' => now()->toDateTimeString(),
        ];
    }

    public function listEntriesForStudent(int $studentId): array
    {
        return [
            [
                'id' => 'lb-001',
                'date' => '2026-05-25',
                'hours' => 6,
                'notes' => 'Worked on dashboard scaffolding.',
                'status' => 'Approved',
            ],
            [
                'id' => 'lb-002',
                'date' => '2026-05-26',
                'hours' => 7,
                'notes' => 'Reviewed tasks and updated UI stubs.',
                'status' => 'Pending',
            ],
        ];
    }
}

