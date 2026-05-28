<?php

namespace App\Livewire\Supervisor;

use App\Services\TaskService;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class TaskAssignment extends Component
{
    public string $taskTitle = '';
    public string $student = '';
    public array $tasks = [];

    public function mount(): void
    {
        $this->tasks = [
            ['title' => 'Weekly check-in', 'student' => 'John Doe', 'status' => 'Assigned'],
            ['title' => 'Submit week 5 logbook', 'student' => 'Jane Smith', 'status' => 'In progress'],
        ];
    }

    public function createTask(): void
    {
        $title = trim($this->taskTitle);
        $student = trim($this->student);

        if ($title === '' || $student === '') {
            return;
        }

        $task = app(TaskService::class)->assignTask($title, $student, auth()->id());

        $this->tasks = array_merge([
            [
                'title' => (string) ($task['title'] ?? $title),
                'student' => (string) ($task['assignee'] ?? $student),
                'status' => (string) ($task['status'] ?? 'Assigned'),
            ],
        ], $this->tasks);

        $this->taskTitle = '';
        $this->student = '';
    }

    public function render(): View
    {
        return view('livewire.supervisor.task-assignment', [
            'title' => 'Task Assignment',
        ])->extends('layouts.dashboard')->section('content');
    }
}
