<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;

class Admin extends Component
{
    public array $stats = [];
    public array $registrationData = [];
    public array $activities = [];
    public array $quickActions = [];
    public array $systemHealth = [];
    public array $internshipStats = [];

    public function mount()
    {
        $this->stats = [
            'totalUsers' => 1234,
            'userTrend' => '+12%',
            'totalInternships' => 89,
            'internshipTrend' => '+8%',
            'activeApplications' => 567,
            'applicationTrend' => '-3%',
            'pendingVerifications' => 23,
        ];

        $this->registrationData = [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
            'values' => [120, 145, 132, 168, 195, 210, 245],
        ];

        $this->activities = [
            [
                'icon' => 'user',
                'title' => 'John Doe registered as Student',
                'time' => '2 minutes ago',
                'type' => 'registration',
            ],
            [
                'icon' => 'briefcase',
                'title' => 'New internship posted: Software Developer',
                'time' => '15 minutes ago',
                'type' => 'internship',
            ],
            [
                'icon' => 'shield-check',
                'title' => 'Verification approved for Jane Smith',
                'time' => '1 hour ago',
                'type' => 'verification',
            ],
            [
                'icon' => 'document-text',
                'title' => 'Application submitted for Marketing Intern',
                'time' => '2 hours ago',
                'type' => 'application',
            ],
            [
                'icon' => 'check-circle',
                'title' => 'Task completed: Code Review',
                'time' => '3 hours ago',
                'type' => 'task',
            ],
            [
                'icon' => 'user',
                'title' => 'Sarah Connor completed profile',
                'time' => '4 hours ago',
                'type' => 'registration',
            ],
            [
                'icon' => 'clock',
                'title' => 'Weekly report submitted by Bob Wilson',
                'time' => '5 hours ago',
                'type' => 'report',
            ],
        ];

        $this->internshipStats = [
            'open' => 45,
            'closed' => 30,
            'filled' => 14,
        ];

        $this->systemHealth = [
            [
                'name' => 'Database',
                'status' => 'online',
                'detail' => 'Connected',
                'color' => 'green',
            ],
            [
                'name' => 'API',
                'status' => 'operational',
                'detail' => 'All systems normal',
                'color' => 'green',
            ],
            [
                'name' => 'Cache',
                'status' => 'active',
                'detail' => 'Redis 8.0',
                'color' => 'green',
            ],
            [
                'name' => 'Storage',
                'status' => '67% used',
                'detail' => '134 GB / 200 GB',
                'color' => 'yellow',
            ],
        ];

        $this->quickActions = [
            [
                'icon' => 'user-plus',
                'label' => 'Add User',
                'href' => '#',
                'description' => 'Create new user account',
            ],
            [
                'icon' => 'plus-circle',
                'label' => 'Create Internship',
                'href' => '#',
                'description' => 'Post new internship',
            ],
            [
                'icon' => 'chart-bar',
                'label' => 'View Reports',
                'href' => '#',
                'description' => 'Analytics & insights',
            ],
            [
                'icon' => 'shield-check',
                'label' => 'Manage Verifications',
                'href' => '#',
                'description' => 'Review pending requests',
            ],
            [
                'icon' => 'cog',
                'label' => 'System Settings',
                'href' => '#',
                'description' => 'Configure application',
            ],
            [
                'icon' => 'question-mark-circle',
                'label' => 'Help & Support',
                'href' => '#',
                'description' => 'Get assistance',
            ],
        ];
    }

    public function getMaxRegistrationValue()
    {
        return max($this->registrationData['values']);
    }

    public function getActivityIconColor($type)
    {
        return match ($type) {
            'registration' => 'bg-blue-100 text-blue-600',
            'internship' => 'bg-green-100 text-green-600',
            'verification' => 'bg-purple-100 text-purple-600',
            'application' => 'bg-yellow-100 text-yellow-600',
            'task' => 'bg-indigo-100 text-indigo-600',
            'report' => 'bg-gray-100 text-gray-600',
            default => 'bg-gray-100 text-gray-600',
        };
    }

    public function render()
    {
        return view('livewire.dashboard.admin')
            ->layout('layouts.dashboard', [
                'title' => 'Admin Dashboard',
            ]);
    }
}

