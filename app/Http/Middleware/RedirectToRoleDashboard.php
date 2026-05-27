<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class RedirectToRoleDashboard
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user) {
            if (Route::has('login')) {
                return redirect()->route('login');
            }

            return redirect()->to('/__dashboards');
        }

        $roleRoute = match ($user->role ?? null) {
            'admin' => 'admin.dashboard',
            'student' => 'student.dashboard',
            'supervisor' => 'supervisor.dashboard',
            'company' => 'company.dashboard',
            default => null,
        };

        if ($roleRoute && Route::has($roleRoute)) {
            return redirect()->route($roleRoute);
        }

        return redirect()->to('/__dashboards');
    }
}

