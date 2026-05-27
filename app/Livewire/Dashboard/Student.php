<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;

class Student extends Component
{
    public array $user;
    public array $activeInternship;
    public array $tasks;
    public array $hoursThisWeek;
    public array $applications;
    public array $deadlines;
    public array $notifications;
    public int $hoursThisMonth;

    public function mount()
    {
        $this->user = [
            'name' => 'John Doe',
            'email' => 'john.doe@student.edu'
        ];

        $this->activeInternship = [
            'company' => 'TechCorp Inc.',
            'position' => 'Software Development Intern',
            'startDate' => '2026-01-15',
            'endDate' => '2026-04-15',
            'progress' => 45,
            'supervisor' => 'Dr. Sarah Johnson'
        ];

        $this->tasks = [
            [
                'title' => 'Complete API documentation',
                'due' => 'Tomorrow',
                'priority' => 'high'
            ],
            [
                'title' => 'Code review for feature X',
                'due' => 'In 3 days',
                'priority' => 'medium'
            ],
            [
                'title' => 'Write unit tests',
                'due' => 'Next week',
                'priority' => 'low'
            ],
            [
                'title' => 'Update README',
                'due' => 'Next week',
                'priority' => 'low'
            ]
        ];

        $this->hoursThisWeek = [
            'logged' => 32,
            'target' => 40,
            'byDay' => [8, 8, 6, 8, 2]
        ];

        $this->applications = [
            [
                'company' => 'TechCorp Inc.',
                'position' => 'Software Development Intern',
                'status' => 'accepted',
                'applied' => 'Jan 15, 2026'
            ],
            [
                'company' => 'InnovateLab',
                'position' => 'UX Design Intern',
                'status' => 'review',
                'applied' => 'Feb 1, 2026'
            ],
            [
                'company' => 'BigTech Co',
                'position' => 'Data Analyst',
                'status' => 'rejected',
                'applied' => 'Jan 20, 2026'
            ]
        ];

        $this->deadlines = [
            [
                'task' => 'API Documentation',
                'time' => 'Tomorrow',
                'urgency' => 'urgent'
            ],
            [
                'task' => 'Code Review',
                'time' => 'In 3 days',
                'urgency' => 'soon'
            ],
            [
                'task' => 'Unit Tests',
                'time' => 'Next week',
                'urgency' => 'later'
            ],
            [
                'task' => 'Project Presentation',
                'time' => 'Next week',
                'urgency' => 'later'
            ]
        ];

        $this->notifications = [
            [
                'title' => 'Task assigned: Update documentation',
                'time' => '2 hours ago',
                'unread' => true
            ],
            [
                'title' => 'Logbook entry approved by supervisor',
                'time' => '5 hours ago',
                'unread' => true
            ],
            [
                'title' => 'New message from Dr. Johnson',
                'time' => '1 day ago',
                'unread' => true
            ],
            [
                'title' => 'Verification submitted successfully',
                'time' => '2 days ago',
                'unread' => false
            ],
            [
                'title' => 'Application status updated',
                'time' => '3 days ago',
                'unread' => false
            ]
        ];

        $this->hoursThisMonth = 128;
    }

    public function getWeekDays(): array
    {
        return ['Mon', 'Tue', 'Wed', 'Thu', 'Fri'];
    }

    public function getWeekProgress(): int
    {
        return (int) (($this->hoursThisWeek['logged'] / $this->hoursThisWeek['target']) * 100);
    }

    public function getStatusBadgeClass(string $status): string
    {
        return match ($status) {
            'accepted' => 'bg-green-100 text-green-800',
            'review' => 'bg-yellow-100 text-yellow-800',
            'rejected' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    public function getStatusLabel(string $status): string
    {
        return match ($status) {
            'accepted' => 'Accepted',
            'review' => 'Under Review',
            'rejected' => 'Rejected',
            default => 'Unknown'
        };
    }

    public function getPriorityBadgeClass(string $priority): string
    {
        return match ($priority) {
            'high' => 'bg-red-100 text-red-800',
            'medium' => 'bg-yellow-100 text-yellow-800',
            'low' => 'bg-gray-100 text-gray-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    public function getDeadlineIconColor(string $urgency): string
    {
        return match ($urgency) {
            'urgent' => 'text-red-600',
            'soon' => 'text-yellow-600',
            'later' => 'text-gray-600',
            default => 'text-gray-600'
        };
    }

    public function render()
    {
        return view('livewire.dashboard.student')
            ->layout('layouts.dashboard', [
                'title' => 'Student Dashboard'
            ]);
    }
}

