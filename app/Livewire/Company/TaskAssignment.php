<?php

namespace App\Livewire\Company;

use App\Services\TaskService;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class TaskAssignment extends Component
{
    public array $tasks = [];
    public string $taskTitle = '';
    public string $assignee = '';

    public function mount(): void
    {
        $this->tasks = [
            [
                'title' => 'Set up development environment',
                'assignee' => 'John Doe',
                'status' => 'In progress',
            ],
            [
                'title' => 'Design onboarding flow',
                'assignee' => 'Jane Smith',
                'status' => 'Pending',
            ],
        ];
    }

    public function createTask(): void
    {
        $title = trim($this->taskTitle);
        $assignee = trim($this->assignee);

        if ($title === '' || $assignee === '') {
            return;
        }

        $task = app(TaskService::class)->assignTask($title, $assignee, auth()->id());

        array_unshift($this->tasks, [
            'title' => (string) ($task['title'] ?? $title),
            'assignee' => (string) ($task['assignee'] ?? $assignee),
            'status' => (string) ($task['status'] ?? 'Assigned'),
        ]);

        session()->flash('message', 'Task assignment submitted (stub).');
        $this->taskTitle = '';
        $this->assignee = '';
    }

    public function render(): View
    {
        return view('livewire.company.task-assignment', [
            'title' => 'Task Assignment',
        ])->extends('layouts.dashboard')->section('content');
    }
}
