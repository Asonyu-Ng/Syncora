<?php

namespace App\View\Components\Dashboard;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\View\Component;

class Navbar extends Component
{
    public int $notificationCount = 0;
    public array $notifications = [];
    public string $currentPage = '';

    public function __construct()
    {
        $this->currentPage = $this->resolveCurrentPage();
        $this->notifications = $this->getMockNotifications();
        $this->notificationCount = collect($this->notifications)->where('read', false)->count();
    }

    public function getUserName(): string
    {
        return Auth::user()?->name ?? 'User';
    }

    public function getUserEmail(): string
    {
        return Auth::user()?->email ?? 'user@example.com';
    }

    public function getUserInitials(): string
    {
        $name = $this->getUserName();
        $names = explode(' ', trim($name));

        if (count($names) >= 2) {
            return strtoupper($names[0][0] . end($names)[0]);
        }

        return strtoupper($name[0]);
    }

    public function getUserAvatarColor(): string
    {
        $name = $this->getUserName();
        $colors = [
            'from-blue-500 to-indigo-600',
            'from-green-500 to-emerald-600',
            'from-purple-500 to-pink-600',
            'from-orange-500 to-red-600',
            'from-teal-500 to-cyan-600',
        ];

        $hash = crc32($name);
        $index = abs($hash) % count($colors);

        return $colors[$index];
    }

    protected function resolveCurrentPage(): string
    {
        $routeName = Route::current()?->getName() ?? '';

        if ($routeName) {
            $segments = [
                'admin.dashboard' => 'Admin Dashboard',
                'student.dashboard' => 'Student Dashboard',
                'supervisor.dashboard' => 'Supervisor Dashboard',
                'company.dashboard' => 'Company Dashboard',
            ];

            foreach ($segments as $key => $title) {
                if ($routeName === $key) {
                    return $title;
                }
            }
        }

        $segment = request()->segment(1);
        return match ($segment) {
            'admin' => 'Admin Dashboard',
            'student' => 'Student Dashboard',
            'supervisor' => 'Supervisor Dashboard',
            'company' => 'Company Dashboard',
            default => 'Dashboard',
        };
    }

    protected function getMockNotifications(): array
    {
        return [
            [
                'id' => 1,
                'title' => 'New Application Received',
                'description' => 'John Smith applied for Software Developer position',
                'time' => '2 minutes ago',
                'read' => false,
                'icon' => 'document-text',
            ],
            [
                'id' => 2,
                'title' => 'Verification Pending',
                'description' => '3 documents awaiting verification',
                'time' => '15 minutes ago',
                'read' => false,
                'icon' => 'shield-check',
            ],
            [
                'id' => 3,
                'title' => 'Task Completed',
                'description' => 'Weekly report submitted by Alice Johnson',
                'time' => '1 hour ago',
                'read' => true,
                'icon' => 'check-circle',
            ],
        ];
    }

    public function render()
    {
        return view('components.dashboard.navbar');
    }
}

