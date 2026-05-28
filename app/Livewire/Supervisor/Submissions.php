<?php

namespace App\Livewire\Supervisor;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class Submissions extends Component
{
    public array $submissions = [];

    public function mount(): void
    {
        $this->submissions = [
            [
                'student' => 'John Doe',
                'type' => 'Logbook Entry',
                'detail' => 'Week 3 Logbook',
                'submitted_at' => 'Yesterday 4:30 PM',
            ],
            [
                'student' => 'Alice Brown',
                'type' => 'Task',
                'detail' => 'API Documentation',
                'submitted_at' => 'Today 9:15 AM',
            ],
            [
                'student' => 'Jane Smith',
                'type' => 'Weekly Report',
                'detail' => 'Week 4 Report',
                'submitted_at' => 'Today 2:00 PM',
            ],
        ];
    }

    public function render(): View
    {
        return view('livewire.supervisor.submissions', [
            'title' => 'Recent Submissions',
        ])->extends('layouts.dashboard')->section('content');
    }
}

