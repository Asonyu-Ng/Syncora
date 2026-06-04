<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ScaffoldedRoutesSmokeTest extends TestCase
{
    use RefreshDatabase;

    public function test_all_scaffolded_page_routes_render_without_errors(): void
    {
        $routesByRole = [
            'student' => [
                '/student/dashboard',
                '/student/internships',
                '/student/internships/1',
                '/student/applications',
                '/student/tasks',
                '/student/logbook',
                '/student/ai-reports',
                '/student/profile',
                '/student/settings',
            ],
            'supervisor' => [
                '/supervisor/dashboard',
                '/supervisor/students',
                '/supervisor/tasks',
                '/supervisor/logbooks',
                '/supervisor/evaluations',
                '/supervisor/monitoring',
                '/supervisor/reports',
                '/supervisor/calendar',
                '/supervisor/profile',
                '/supervisor/settings',
                '/supervisor/interns',
                '/supervisor/verifications',
                '/supervisor/submissions',
                '/supervisor/messages',
            ],
            'company' => [
                '/company/dashboard',
                '/company/internships',
                '/company/internships/create',
                '/company/applicants',
                '/company/interns',
                '/company/tasks',
                '/company/evaluations',
                '/company/reports',
                '/company/profile',
                '/company/settings',
            ],
            'admin' => [
                '/admin/dashboard',
                '/admin/users',
                '/admin/universities',
                '/admin/companies',
                '/admin/internships',
                '/admin/analytics',
                '/admin/reports',
                '/admin/notifications',
                '/admin/settings',
                '/admin/activity-logs',
            ],
        ];

        foreach ($routesByRole as $role => $routes) {
            $user = User::factory()->create([
                'role' => $role,
            ]);

            $this->actingAs($user)->get('/dashboard')->assertRedirect("/{$role}/dashboard");
            $this->actingAs($user)->get('/__dashboards')->assertOk();
            $this->actingAs($user)->get('/profile')->assertRedirect(match ($role) {
                'student' => '/student/profile',
                'supervisor' => '/supervisor/profile',
                'company' => '/company/profile',
                default => '/account',
            });
            if ($role === 'student') {
                $this->actingAs($user)->get('/account')->assertRedirect('/student/profile');
            } else {
                $this->actingAs($user)->get('/account')->assertOk();
            }

            foreach ($routes as $uri) {
                $this->actingAs($user)->get($uri)->assertOk();
            }
        }
    }
}
