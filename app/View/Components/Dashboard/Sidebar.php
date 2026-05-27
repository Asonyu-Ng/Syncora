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

        $isDashboardActive = request()->url() === $dashboard || request()->fullUrlIs($dashboard);

        return [
            [
                'label' => 'Dashboard',
                'icon' => 'home',
                'href' => $dashboard,
                'active' => $isDashboardActive,
            ],
            [
                'label' => 'All Dashboards',
                'icon' => 'users',
                'href' => '/__dashboards',
                'active' => request()->is('__dashboards'),
            ],
        ];
    }

    public function render()
    {
        return view('components.dashboard.sidebar');
    }
}
