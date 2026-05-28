<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleBasedAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_each_role_can_only_access_its_own_area(): void
    {
        $routesByRole = [
            'admin' => '/admin/users',
            'student' => '/student/dashboard',
            'supervisor' => '/supervisor/dashboard',
            'company' => '/company/dashboard',
        ];

        foreach (array_keys($routesByRole) as $role) {
            $user = User::factory()->create([
                'role' => $role,
            ]);

            $expectedDashboard = "/{$role}/dashboard";

            foreach ($routesByRole as $targetRole => $uri) {
                if ($targetRole === $role) {
                    $this->actingAs($user)->get($uri)->assertOk();
                    continue;
                }

                $this->actingAs($user)->get($uri)->assertRedirect($expectedDashboard);
            }
        }
    }
}
