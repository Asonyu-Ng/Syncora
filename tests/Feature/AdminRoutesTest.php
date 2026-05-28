<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminRoutesTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_routes_require_authentication(): void
    {
        $this->get('/admin/users')->assertRedirect('/login');
    }

    public function test_admin_can_access_admin_module_pages(): void
    {
        $user = User::factory()->create([
            'role' => 'admin',
        ]);

        $this->actingAs($user)->get('/admin/dashboard')->assertOk();
        $this->actingAs($user)->get('/admin/users')->assertOk();
        $this->actingAs($user)->get('/admin/universities')->assertOk();
        $this->actingAs($user)->get('/admin/companies')->assertOk();
        $this->actingAs($user)->get('/admin/internships')->assertOk();
        $this->actingAs($user)->get('/admin/analytics')->assertOk();
        $this->actingAs($user)->get('/admin/reports')->assertOk();
        $this->actingAs($user)->get('/admin/notifications')->assertOk();
        $this->actingAs($user)->get('/admin/settings')->assertOk();
        $this->actingAs($user)->get('/admin/activity-logs')->assertOk();
    }

    public function test_non_admin_is_redirected_to_their_dashboard(): void
    {
        $user = User::factory()->create([
            'role' => 'student',
        ]);

        $this->actingAs($user)->get('/admin/users')->assertRedirect('/student/dashboard');
    }
}
