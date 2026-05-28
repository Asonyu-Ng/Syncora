<?php

namespace App\Livewire\Supervisor;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class Dashboard extends Component
{
    public array $stats = [];
    public array $pendingLogbooks = [];
    public array $recentReports = [];

    public function mount(): void
    {
        $this->stats = [
            'students' => 14,
            'activeInternships' => 6,
            'pendingLogbooks' => 5,
            'pendingEvaluations' => 3,
        ];

        $this->pendingLogbooks = [
            ['student' => 'John Doe', 'week' => 'Week 5', 'submitted' => '2 hours ago'],
            ['student' => 'Jane Smith', 'week' => 'Week 5', 'submitted' => 'Yesterday'],
            ['student' => 'Bob Wilson', 'week' => 'Week 4', 'submitted' => '2 days ago'],
        ];

        $this->recentReports = [
            ['student' => 'Alice Brown', 'title' => 'Monthly Progress Report', 'time' => '1 hour ago'],
            ['student' => 'John Doe', 'title' => 'Weekly Summary', 'time' => 'Today'],
        ];
    }

    public function render(): View
    {
        return view('livewire.supervisor.dashboard', [
            'title' => 'Supervisor Dashboard',
        ])->extends('layouts.dashboard')->section('content');
    }
}
