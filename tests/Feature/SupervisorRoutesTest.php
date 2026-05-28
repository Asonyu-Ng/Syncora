<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SupervisorRoutesTest extends TestCase
{
    use RefreshDatabase;

    public function test_supervisor_routes_require_authentication(): void
    {
        $this->get('/supervisor/dashboard')->assertRedirect('/login');
    }

    public function test_supervisor_can_access_supervisor_module_pages(): void
    {
        $user = User::factory()->create([
            'role' => 'supervisor',
        ]);

        $this->actingAs($user)->get('/supervisor/dashboard')->assertOk();
        $this->actingAs($user)->get('/supervisor/students')->assertOk();
        $this->actingAs($user)->get('/supervisor/tasks')->assertOk();
        $this->actingAs($user)->get('/supervisor/logbooks')->assertOk();
        $this->actingAs($user)->get('/supervisor/evaluations')->assertOk();
        $this->actingAs($user)->get('/supervisor/monitoring')->assertOk();
        $this->actingAs($user)->get('/supervisor/reports')->assertOk();
        $this->actingAs($user)->get('/supervisor/calendar')->assertOk();
        $this->actingAs($user)->get('/supervisor/profile')->assertOk();
        $this->actingAs($user)->get('/supervisor/settings')->assertOk();

        $this->actingAs($user)->get('/supervisor/interns')->assertOk();
        $this->actingAs($user)->get('/supervisor/verifications')->assertOk();
        $this->actingAs($user)->get('/supervisor/submissions')->assertOk();
        $this->actingAs($user)->get('/supervisor/messages')->assertOk();
    }

    public function test_non_supervisor_is_redirected_to_their_dashboard(): void
    {
        $user = User::factory()->create([
            'role' => 'student',
        ]);

        $this->actingAs($user)->get('/supervisor/dashboard')->assertRedirect('/student/dashboard');
    }
}
