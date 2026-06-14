<?php

namespace Tests\Feature;

use App\Livewire\Company\PostInternship;
use App\Models\Internship;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CompanyPostInternshipTest extends TestCase
{
    use RefreshDatabase;

    public function test_company_can_render_the_redesigned_post_internship_page(): void
    {
        $user = User::factory()->create([
            'role' => 'company',
        ]);

        $user->companyProfile()->create([
            'company_name' => 'TechNova Solutions',
            'industry' => 'Technology',
            'location' => 'Douala, Cameroon',
        ]);

        $this->actingAs($user)
            ->get('/company/internships/create')
            ->assertOk()
            ->assertSee('Post New Internship')
            ->assertSee('Douala, Cameroon / Remote')
            ->assertSee('Publish Internship')
            ->assertSee('Onsite')
            ->assertSee('Hybrid')
            ->assertSee('Remote');
    }

    public function test_company_can_publish_an_internship_from_the_post_page(): void
    {
        $user = User::factory()->create([
            'role' => 'company',
        ]);

        $companyProfile = $user->companyProfile()->create([
            'company_name' => 'TechNova Solutions',
            'industry' => 'Technology',
            'location' => 'Yaounde, Cameroon',
        ]);

        Livewire::actingAs($user)
            ->test(PostInternship::class)
            ->set('internshipTitle', 'Frontend Developer Intern')
            ->set('department', 'Information Technology')
            ->set('location', 'Yaounde, Cameroon')
            ->set('type', 'Hybrid')
            ->set('durationInMonths', 4)
            ->set('description', 'Support the product team by building responsive interface features for students and supervisors.')
            ->set('educationLevel', 'Bachelor\'s Degree')
            ->set('otherRequirements', 'Must be available for weekly standups from our Yaounde office.')
            ->set('requiredSkills', ['Laravel', 'Tailwind CSS'])
            ->call('submit')
            ->assertHasNoErrors()
            ->assertRedirect(route('company.internships.index'));

        $this->assertDatabaseHas('internships', [
            'company_profile_id' => $companyProfile->id,
            'title' => 'Frontend Developer Intern',
            'department' => 'Information Technology',
            'location' => 'Yaounde, Cameroon',
            'type' => 'Hybrid',
            'duration' => '4 months',
            'education_level' => 'Bachelor\'s Degree',
            'status' => 'open',
        ]);

        $internship = Internship::query()->where('title', 'Frontend Developer Intern')->firstOrFail();

        $this->assertSame(['Laravel', 'Tailwind CSS'], $internship->required_skills);
        $this->assertSame('Must be available for weekly standups from our Yaounde office.', $internship->other_requirements);

        $this->actingAs($user)
            ->get('/company/internships')
            ->assertOk()
            ->assertSee('Frontend Developer Intern')
            ->assertSee('Published');
    }
}
