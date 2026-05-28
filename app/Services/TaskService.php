<?php

namespace App\Services;

use Illuminate\Support\Str;

class TaskService
{
    public function assignTask(string $title, string $assigneeName, ?int $creatorId = null): array
    {
        return [
            'id' => Str::uuid()->toString(),
            'title' => $title,
            'assignee' => $assigneeName,
            'creatorId' => $creatorId,
            'status' => 'Assigned',
            'createdAt' => now()->toDateTimeString(),
        ];
    }

    public function markTaskComplete(int|string $taskId): array
    {
        return [
            'id' => $taskId,
            'status' => 'Completed',
            'updatedAt' => now()->toDateTimeString(),
        ];
    }

    public function listAssignedTasks(?int $userId = null): array
    {
        return [
            [
                'id' => 'task-001',
                'title' => 'Weekly check-in',
                'assignee' => 'John Doe',
                'status' => 'Assigned',
            ],
            [
                'id' => 'task-002',
                'title' => 'Submit week 5 logbook',
                'assignee' => 'Jane Smith',
                'status' => 'In progress',
            ],
        ];
    }
}

