<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();
        $currentRole = $this->resolveRole($request);

        if (!$user) {
            if (Route::has('login')) {
                return redirect()->route('login');
            }

            abort(403);
        }

        if (!empty($roles) && $currentRole && !in_array($currentRole, $roles, true)) {
            return redirect()->to($this->getDashboardUrl($currentRole));
        }

        if (!empty($roles) && !$currentRole) {
            abort(403);
        }

        return $next($request);
    }

    protected function getDashboardUrl(?string $role): string
    {
        return match ($role) {
            'admin' => Route::has('admin.dashboard') ? route('admin.dashboard') : '/admin/dashboard',
            'student' => Route::has('student.dashboard') ? route('student.dashboard') : '/student/dashboard',
            'supervisor' => Route::has('supervisor.dashboard') ? route('supervisor.dashboard') : '/supervisor/dashboard',
            'company' => Route::has('company.dashboard') ? route('company.dashboard') : '/company/dashboard',
            default => Route::has('dashboard') ? route('dashboard') : '/dashboard',
        };
    }

    protected function resolveRole(Request $request): ?string
    {
        $user = $request->user();

        if ($user && isset($user->role) && $user->role) {
            return (string) $user->role;
        }

        $segment = $request->segment(1);
        if (in_array($segment, ['admin', 'student', 'supervisor', 'company'], true)) {
            return $segment;
        }

        $as = $request->query('as');
        if (is_string($as) && in_array($as, ['admin', 'student', 'supervisor', 'company'], true)) {
            return $as;
        }

        return null;
    }
}
