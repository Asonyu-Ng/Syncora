<?php

namespace App\Services;

use Illuminate\Support\Str;

class EvaluationService
{
    public function submitEvaluation(int $evaluatorId, string $subjectName, string $score, ?string $notes = null): array
    {
        return [
            'id' => Str::uuid()->toString(),
            'evaluatorId' => $evaluatorId,
            'subject' => $subjectName,
            'score' => $score,
            'notes' => $notes,
            'status' => 'Submitted',
            'submittedAt' => now()->toDateTimeString(),
        ];
    }

    public function listEvaluations(?int $subjectId = null): array
    {
        return [
            [
                'id' => 'ev-001',
                'student' => 'John Doe',
                'score' => '8/10',
                'date' => '2026-05-01',
                'status' => 'Submitted',
            ],
            [
                'id' => 'ev-002',
                'student' => 'Jane Smith',
                'score' => 'Pending',
                'date' => '2026-05-15',
                'status' => 'Draft',
            ],
        ];
    }
}

