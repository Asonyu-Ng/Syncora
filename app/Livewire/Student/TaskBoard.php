<?php

namespace App\Livewire\Student;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class TaskBoard extends Component
{
    public array $columns = [];

    public function mount(): void
    {
        $this->columns = [
            'Todo' => [
                ['title' => 'Read internship onboarding docs', 'due' => 'Tomorrow'],
                ['title' => 'Set up local environment', 'due' => 'In 2 days'],
            ],
            'In Progress' => [
                ['title' => 'Implement feature stub', 'due' => 'This week'],
            ],
            'Done' => [
                ['title' => 'Submit weekly update', 'due' => 'Yesterday'],
            ],
        ];
    }

    public function render(): View
    {
        return view('livewire.student.task-board', [
            'title' => 'Task Board',
        ])->extends('layouts.dashboard')->section('content');
    }
}

