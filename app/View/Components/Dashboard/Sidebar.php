<?php

namespace App\View\Components\Dashboard;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\View\Component;

class Sidebar extends Component
{
    public string $role;
    public array $navigationItems = [];

    public function __construct()
    {
        $this->role = $this->resolveRole();
        $this->navigationItems = $this->buildNavigation($this->role);
    }

    protected function resolveRole(): string
    {
        $user = Auth::user();

        if ($user && isset($user->role) && $user->role) {
            return (string) $user->role;
        }

        $segment = request()->segment(1);
        if (in_array($segment, ['admin', 'student', 'supervisor', 'company'], true)) {
            return $segment;
        }

        $as = request()->query('as');
        if (is_string($as) && in_array($as, ['admin', 'student', 'supervisor', 'company'], true)) {
            return $as;
        }

        return 'student';
    }

    protected function routeUrl(string $name, string $fallback): string
    {
        return Route::has($name) ? route($name) : $fallback;
    }

    protected function buildNavigation(string $role): array
    {
        $dashboard = match ($role) {
            'admin' => $this->routeUrl('admin.dashboard', '/admin/dashboard'),
            'student' => $this->routeUrl('student.dashboard', '/student/dashboard'),
            'supervisor' => $this->routeUrl('supervisor.dashboard', '/supervisor/dashboard'),
            'company' => $this->routeUrl('company.dashboard', '/company/dashboard'),
            default => $this->routeUrl('dashboard', '/dashboard'),
        };

        $isDashboardActive = match ($role) {
            'admin' => request()->routeIs('admin.dashboard'),
            'student' => request()->routeIs('student.dashboard'),
            'supervisor' => request()->routeIs('supervisor.dashboard'),
            'company' => request()->routeIs('company.dashboard'),
            default => request()->routeIs('dashboard') || request()->url() === $dashboard || request()->fullUrlIs($dashboard),
        };

        $items = [
            [
                'label' => 'Dashboard',
                'icon' => 'home',
                'href' => $dashboard,
                'active' => $isDashboardActive,
            ],
        ];

        if ($role === 'student') {
            $items = array_merge($items, [
                [
                    'label' => 'Internship Search',
                    'icon' => 'briefcase',
                    'href' => $this->routeUrl('student.internships.search', '/student/internships'),
                    'active' => request()->routeIs('student.internships.*'),
                ],
                [
                    'label' => 'Applications',
                    'icon' => 'document',
                    'href' => $this->routeUrl('student.applications.index', '/student/applications'),
                    'active' => request()->routeIs('student.applications.*'),
                ],
                [
                    'label' => 'Task Board',
                    'icon' => 'check-circle',
                    'href' => $this->routeUrl('student.tasks.board', '/student/tasks'),
                    'active' => request()->routeIs('student.tasks.*'),
                ],
                [
                    'label' => 'Logbook',
                    'icon' => 'clock',
                    'href' => $this->routeUrl('student.logbook.index', '/student/logbook'),
                    'active' => request()->routeIs('student.logbook.*'),
                ],
                [
                    'label' => 'AI Reports',
                    'icon' => 'chart-bar',
                    'href' => $this->routeUrl('student.reports.ai', '/student/ai-reports'),
                    'active' => request()->routeIs('student.reports.*'),
                ],
                [
                    'label' => 'Profile',
                    'icon' => 'user',
                    'href' => $this->routeUrl('student.profile', '/student/profile'),
                    'active' => request()->routeIs('student.profile'),
                ],
                [
                    'label' => 'Settings',
                    'icon' => 'cog',
                    'href' => $this->routeUrl('student.settings', '/student/settings'),
                    'active' => request()->routeIs('student.settings'),
                ],
            ]);
        }

        if ($role === 'company') {
            $items = array_merge($items, [
                [
                    'label' => 'Internships',
                    'icon' => 'briefcase',
                    'href' => $this->routeUrl('company.internships.index', '/company/internships'),
                    'active' => request()->routeIs('company.internships.*'),
                ],
                [
                    'label' => 'Applicants',
                    'icon' => 'document',
                    'href' => $this->routeUrl('company.applicants.index', '/company/applicants'),
                    'active' => request()->routeIs('company.applicants.*'),
                ],
                [
                    'label' => 'Active Interns',
                    'icon' => 'users',
                    'href' => $this->routeUrl('company.interns.index', '/company/interns'),
                    'active' => request()->routeIs('company.interns.*'),
                ],
                [
                    'label' => 'Tasks',
                    'icon' => 'check-circle',
                    'href' => $this->routeUrl('company.tasks.index', '/company/tasks'),
                    'active' => request()->routeIs('company.tasks.*'),
                ],
                [
                    'label' => 'Evaluations',
                    'icon' => 'chart-bar',
                    'href' => $this->routeUrl('company.evaluations.index', '/company/evaluations'),
                    'active' => request()->routeIs('company.evaluations.*'),
                ],
                [
                    'label' => 'Reports',
                    'icon' => 'document',
                    'href' => $this->routeUrl('company.reports.index', '/company/reports'),
                    'active' => request()->routeIs('company.reports.*'),
                ],
                [
                    'label' => 'Profile',
                    'icon' => 'user',
                    'href' => $this->routeUrl('company.profile', '/company/profile'),
                    'active' => request()->routeIs('company.profile'),
                ],
                [
                    'label' => 'Settings',
                    'icon' => 'cog',
                    'href' => $this->routeUrl('company.settings', '/company/settings'),
                    'active' => request()->routeIs('company.settings'),
                ],
            ]);
        }

        if ($role === 'supervisor') {
            $items = array_merge($items, [
                [
                    'label' => 'Students',
                    'icon' => 'users',
                    'href' => $this->routeUrl('supervisor.students.index', '/supervisor/students'),
                    'active' => request()->routeIs('supervisor.students.*'),
                ],
                [
                    'label' => 'Tasks',
                    'icon' => 'check-circle',
                    'href' => $this->routeUrl('supervisor.tasks.index', '/supervisor/tasks'),
                    'active' => request()->routeIs('supervisor.tasks.*'),
                ],
                [
                    'label' => 'Logbooks',
                    'icon' => 'clock',
                    'href' => $this->routeUrl('supervisor.logbooks.index', '/supervisor/logbooks'),
                    'active' => request()->routeIs('supervisor.logbooks.*'),
                ],
                [
                    'label' => 'Evaluations',
                    'icon' => 'chart-bar',
                    'href' => $this->routeUrl('supervisor.evaluations.index', '/supervisor/evaluations'),
                    'active' => request()->routeIs('supervisor.evaluations.*'),
                ],
                [
                    'label' => 'Monitoring',
                    'icon' => 'briefcase',
                    'href' => $this->routeUrl('supervisor.monitoring.index', '/supervisor/monitoring'),
                    'active' => request()->routeIs('supervisor.monitoring.*'),
                ],
                [
                    'label' => 'Reports',
                    'icon' => 'document',
                    'href' => $this->routeUrl('supervisor.reports.index', '/supervisor/reports'),
                    'active' => request()->routeIs('supervisor.reports.*'),
                ],
                [
                    'label' => 'Calendar',
                    'icon' => 'clock',
                    'href' => $this->routeUrl('supervisor.calendar', '/supervisor/calendar'),
                    'active' => request()->routeIs('supervisor.calendar'),
                ],
                [
                    'label' => 'Profile',
                    'icon' => 'user',
                    'href' => $this->routeUrl('supervisor.profile', '/supervisor/profile'),
                    'active' => request()->routeIs('supervisor.profile'),
                ],
                [
                    'label' => 'Settings',
                    'icon' => 'cog',
                    'href' => $this->routeUrl('supervisor.settings', '/supervisor/settings'),
                    'active' => request()->routeIs('supervisor.settings'),
                ],
            ]);
        }

        $items[] = [
            'label' => 'All Dashboards',
            'icon' => 'users',
            'href' => '/__dashboards',
            'active' => request()->is('__dashboards'),
        ];

        return $items;
    }

    public function render()
    {
        return view('components.dashboard.sidebar');
    }
}
