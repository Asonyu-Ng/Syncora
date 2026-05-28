<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompanyRoutesTest extends TestCase
{
    use RefreshDatabase;

    public function test_company_routes_require_authentication(): void
    {
        $this->get('/company/dashboard')->assertRedirect('/login');
    }

    public function test_company_can_access_company_module_pages(): void
    {
        $user = User::factory()->create([
            'role' => 'company',
        ]);

        $this->actingAs($user)->get('/company/dashboard')->assertOk();
        $this->actingAs($user)->get('/company/internships')->assertOk();
        $this->actingAs($user)->get('/company/internships/create')->assertOk();
        $this->actingAs($user)->get('/company/applicants')->assertOk();
        $this->actingAs($user)->get('/company/interns')->assertOk();
        $this->actingAs($user)->get('/company/tasks')->assertOk();
        $this->actingAs($user)->get('/company/evaluations')->assertOk();
        $this->actingAs($user)->get('/company/reports')->assertOk();
        $this->actingAs($user)->get('/company/profile')->assertOk();
        $this->actingAs($user)->get('/company/settings')->assertOk();
    }

    public function test_non_company_is_redirected_to_their_dashboard(): void
    {
        $user = User::factory()->create([
            'role' => 'student',
        ]);

        $this->actingAs($user)->get('/company/dashboard')->assertRedirect('/student/dashboard');
    }
}

