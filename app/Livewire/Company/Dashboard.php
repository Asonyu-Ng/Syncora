<?php

namespace App\Livewire\Company;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class Dashboard extends Component
{
    public array $stats = [];
    public array $internProgress = [];
    public array $recentApplicants = [];

    public function mount(): void
    {
        $this->stats = [
            'activeInterns' => 6,
            'openRoles' => 3,
            'newApplicants' => 18,
            'pendingEvaluations' => 2,
        ];

        $this->internProgress = [
            [
                'name' => 'John Doe',
                'role' => 'Software Engineering Intern',
                'progress' => 72,
                'status' => 'On track',
            ],
            [
                'name' => 'Jane Smith',
                'role' => 'UX Design Intern',
                'progress' => 55,
                'status' => 'On track',
            ],
            [
                'name' => 'Bob Wilson',
                'role' => 'Data Analyst Intern',
                'progress' => 41,
                'status' => 'Needs attention',
            ],
        ];

        $this->recentApplicants = [
            [
                'name' => 'Alice Johnson',
                'position' => 'Software Engineering Intern',
                'time' => '2 hours ago',
                'stage' => 'Applied',
            ],
            [
                'name' => 'Michael Brown',
                'position' => 'Marketing Intern',
                'time' => '1 day ago',
                'stage' => 'Under review',
            ],
        ];
    }

    public function render(): View
    {
        return view('livewire.company.dashboard', [
            'title' => 'Company Dashboard',
        ])->extends('layouts.dashboard')->section('content');
    }
}

