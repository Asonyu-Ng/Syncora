<?php

namespace App\Services;

use Illuminate\Support\Str;

class InternshipService
{
    public function searchInternships(?string $city = null): array
    {
        $all = [
            [
                'id' => 'tc-001',
                'title' => 'Software Development Intern',
                'company' => 'TechCorp Inc.',
                'city' => 'lagos',
                'type' => 'On-site',
            ],
            [
                'id' => 'il-002',
                'title' => 'UX Design Intern',
                'company' => 'InnovateLab',
                'city' => 'abuja',
                'type' => 'Hybrid',
            ],
            [
                'id' => 'rt-003',
                'title' => 'Data Analyst Intern',
                'company' => 'RemoteWorks',
                'city' => 'remote',
                'type' => 'Remote',
            ],
        ];

        $needle = strtolower(trim((string) $city));

        if ($needle === '') {
            return $all;
        }

        return array_values(array_filter($all, function (array $internship) use ($needle): bool {
            return str_contains((string) ($internship['city'] ?? ''), $needle);
        }));
    }

    public function postInternship(array $data): array
    {
        return [
            'id' => Str::uuid()->toString(),
            'title' => (string) ($data['title'] ?? ''),
            'location' => (string) ($data['location'] ?? ''),
            'duration' => (string) ($data['duration'] ?? ''),
            'description' => (string) ($data['description'] ?? ''),
            'status' => 'Submitted',
            'submittedAt' => now()->toDateTimeString(),
        ];
    }

    public function applyToInternship(int|string $internshipId, int $studentId, array $payload = []): array
    {
        return [
            'applicationId' => Str::uuid()->toString(),
            'internshipId' => $internshipId,
            'studentId' => $studentId,
            'status' => 'Applied',
            'submittedAt' => now()->toDateTimeString(),
            'payload' => $payload,
        ];
    }

    public function acceptApplication(int|string $applicationId): array
    {
        return [
            'applicationId' => $applicationId,
            'status' => 'Accepted',
            'updatedAt' => now()->toDateTimeString(),
        ];
    }

    public function rejectApplication(int|string $applicationId, ?string $reason = null): array
    {
        return [
            'applicationId' => $applicationId,
            'status' => 'Rejected',
            'reason' => $reason,
            'updatedAt' => now()->toDateTimeString(),
        ];
    }

    public function approveVerification(int|string $requestId): array
    {
        return [
            'requestId' => $requestId,
            'status' => 'Approved',
            'updatedAt' => now()->toDateTimeString(),
        ];
    }

    public function rejectVerification(int|string $requestId, ?string $reason = null): array
    {
        return [
            'requestId' => $requestId,
            'status' => 'Rejected',
            'reason' => $reason,
            'updatedAt' => now()->toDateTimeString(),
        ];
    }
}

