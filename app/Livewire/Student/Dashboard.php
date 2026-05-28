<?php

namespace App\Livewire\Student;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class Dashboard extends Component
{
    public array $stats = [];
    public array $activities = [];

    public function mount(): void
    {
        $this->stats = [
            'activeInternship' => 'TechCorp Inc.',
            'pendingTasks' => 4,
            'hoursThisWeek' => 32,
            'applications' => 3,
        ];

        $this->activities = [
            [
                'title' => 'Logbook entry submitted',
                'time' => '2 hours ago',
                'type' => 'logbook',
            ],
            [
                'title' => 'Task assigned: API documentation',
                'time' => '1 day ago',
                'type' => 'task',
            ],
            [
                'title' => 'Application status updated',
                'time' => '3 days ago',
                'type' => 'application',
            ],
        ];
    }

    public function render(): View
    {
        return view('livewire.student.dashboard', [
            'title' => 'Student Dashboard',
        ])->extends('layouts.dashboard')->section('content');
    }
}

