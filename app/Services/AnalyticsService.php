<?php

namespace App\Services;

class AnalyticsService
{
    public function getAdminKpis(): array
    {
        return [
            [
                'label' => 'New Users (30d)',
                'value' => 482,
                'trend' => '+9%',
            ],
            [
                'label' => 'Applications (30d)',
                'value' => 1204,
                'trend' => '+4%',
            ],
            [
                'label' => 'Active Internships',
                'value' => 67,
                'trend' => '+2%',
            ],
            [
                'label' => 'Verification Queue',
                'value' => 14,
                'trend' => '-18%',
            ],
        ];
    }

    public function getTrafficSources(): array
    {
        return [
            ['label' => 'Direct', 'value' => 42],
            ['label' => 'Universities', 'value' => 31],
            ['label' => 'Referrals', 'value' => 19],
            ['label' => 'Search', 'value' => 8],
        ];
    }

    public function aggregate(array $filters = []): array
    {
        return [
            'filters' => $filters,
            'generatedAt' => now()->toDateTimeString(),
            'totals' => [
                'users' => 0,
                'internships' => 0,
                'applications' => 0,
            ],
        ];
    }
}

