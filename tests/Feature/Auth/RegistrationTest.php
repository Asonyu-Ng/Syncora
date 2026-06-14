<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered_with_role_specific_sections(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
        $response->assertSee('Syncora');
        $response->assertSee('Create a Syncora account that matches how you manage internships.');
        $response->assertSee('Student');
        $response->assertSee('Supervisor');
        $response->assertSee('Company');
        $response->assertSee('Create your Syncora account');
        $response->assertSee('Start your onboarding');
        $response->assertSee('Choose your workspace');
        $response->assertSee('Create Student Account');
        $response->assertSee('Role-aware onboarding');
        $response->assertSee('data-role-field-group="student"', false);
        $response->assertSee('data-role-field-group="supervisor"', false);
        $response->assertSee('data-role-field-group="company"', false);
        $response->assertSee('id="student-name"', false);
        $response->assertSee('id="supervisor-position"', false);
        $response->assertSee('id="company-location"', false);
        $response->assertDontSee('<x-text-input', false);
        $response->assertDontSee('Matricule');
        $response->assertDontSee('value="admin"', false);
    }

    public function test_student_registration_persists_student_profile_fields(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test Student',
            'email' => 'student@example.com',
            'role' => 'student',
            'institution' => 'University of Lagos',
            'department' => 'Computer Science',
            'password' => $this->registrationPassword(),
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard', absolute: false));

        $user = User::query()->where('email', 'student@example.com')->firstOrFail();

        $this->assertSame('student', $user->role);
        $this->assertSame('Test Student', $user->name);
        $this->assertNull($user->matricule);

        $this->assertDatabaseHas('student_profiles', [
            'user_id' => $user->id,
            'university' => 'University of Lagos',
            'department' => 'Computer Science',
        ]);
    }

    public function test_student_registration_requires_department(): void
    {
        $response = $this->from('/register')->post('/register', [
            'name' => 'Test Student',
            'email' => 'student@example.com',
            'role' => 'student',
            'institution' => 'University of Lagos',
            'password' => $this->registrationPassword(),
        ]);

        $response->assertRedirect('/register');
        $response->assertSessionHasErrors('department');
        $this->assertGuest();
    }

    public function test_supervisor_registration_requires_position(): void
    {
        $response = $this->from('/register')->post('/register', [
            'name' => 'Dr Ada',
            'email' => 'supervisor@example.com',
            'role' => 'supervisor',
            'institution' => 'University of Lagos',
            'department' => 'Engineering',
            'password' => $this->registrationPassword(),
        ]);

        $response->assertRedirect('/register');
        $response->assertSessionHasErrors('position');
        $this->assertGuest();
    }

    public function test_supervisor_registration_persists_supervisor_profile_fields(): void
    {
        $response = $this->post('/register', [
            'name' => 'Dr Ada',
            'email' => 'supervisor@example.com',
            'role' => 'supervisor',
            'institution' => 'University of Lagos',
            'position' => 'Internship Coordinator',
            'department' => 'Engineering',
            'password' => $this->registrationPassword(),
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard', absolute: false));

        $user = User::query()->where('email', 'supervisor@example.com')->firstOrFail();

        $this->assertSame('supervisor', $user->role);
        $this->assertSame('Dr Ada', $user->name);

        $this->assertDatabaseHas('supervisor_profiles', [
            'user_id' => $user->id,
            'university' => 'University of Lagos',
            'position' => 'Internship Coordinator',
            'department' => 'Engineering',
        ]);
    }

    public function test_company_registration_requires_location(): void
    {
        $response = $this->from('/register')->post('/register', [
            'company_name' => 'Syncora Labs',
            'email' => 'company@example.com',
            'role' => 'company',
            'industry_type' => 'Software',
            'password' => $this->registrationPassword(),
        ]);

        $response->assertRedirect('/register');
        $response->assertSessionHasErrors('company_location');
        $this->assertGuest();
    }

    public function test_company_registration_persists_company_profile_fields(): void
    {
        $response = $this->post('/register', [
            'company_name' => 'Syncora Labs',
            'email' => 'company@example.com',
            'role' => 'company',
            'industry_type' => 'Software',
            'company_location' => 'Lagos, Nigeria',
            'password' => $this->registrationPassword(),
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard', absolute: false));

        $user = User::query()->where('email', 'company@example.com')->firstOrFail();

        $this->assertSame('company', $user->role);
        $this->assertSame('Syncora Labs', $user->name);

        $this->assertDatabaseHas('company_profiles', [
            'user_id' => $user->id,
            'company_name' => 'Syncora Labs',
            'industry' => 'Software',
            'location' => 'Lagos, Nigeria',
        ]);
    }

    public function test_public_registration_cannot_create_admin_users(): void
    {
        $response = $this->post('/register', [
            'name' => 'Evil Admin',
            'email' => 'evil@example.com',
            'role' => 'admin',
            'password' => $this->registrationPassword(),
        ]);

        $response->assertSessionHasErrors('role');
        $this->assertGuest();
    }

    private function registrationPassword(): string
    {
        return 'Password123!';
    }
}
