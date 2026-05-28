<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentRoutesTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_routes_require_authentication(): void
    {
        $this->get('/student/dashboard')->assertRedirect('/login');
    }

    public function test_student_can_access_student_module_pages(): void
    {
        $user = User::factory()->create([
            'role' => 'student',
        ]);

        $this->actingAs($user)->get('/student/dashboard')->assertOk();
        $this->actingAs($user)->get('/student/internships')->assertOk();
        $this->actingAs($user)->get('/student/internships/1')->assertOk();
        $this->actingAs($user)->get('/student/applications')->assertOk();
        $this->actingAs($user)->get('/student/tasks')->assertOk();
        $this->actingAs($user)->get('/student/logbook')->assertOk();
        $this->actingAs($user)->get('/student/ai-reports')->assertOk();
        $this->actingAs($user)->get('/student/profile')->assertOk();
        $this->actingAs($user)->get('/student/settings')->assertOk();
    }

    public function test_non_student_is_redirected_to_their_dashboard(): void
    {
        $user = User::factory()->create([
            'role' => 'supervisor',
        ]);

        $this->actingAs($user)->get('/student/dashboard')->assertRedirect('/supervisor/dashboard');
    }
}
