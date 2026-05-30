<?php

namespace Tests\Feature;

use App\Livewire\Student\InternshipSearch;
use App\Models\Application;
use App\Models\CompanyProfile;
use App\Models\Internship;
use App\Models\SavedSearch;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class StudentInternshipSearchLivewireTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_creates_student_profile_on_mount(): void
    {
        $user = User::factory()->create(['role' => 'student']);

        $this->assertDatabaseMissing('student_profiles', [
            'user_id' => $user->id,
        ]);

        Livewire::actingAs($user)
            ->test(InternshipSearch::class)
            ->assertOk();

        $this->assertDatabaseHas('student_profiles', [
            'user_id' => $user->id,
        ]);
    }

    public function test_it_can_toggle_saved_internship(): void
    {
        $user = User::factory()->create(['role' => 'student']);
        $internship = $this->createOpenInternship();

        Livewire::actingAs($user)
            ->test(InternshipSearch::class)
            ->call('toggleBookmark', $internship->id);

        $profileId = $user->refresh()->studentProfile->id;

        $this->assertDatabaseHas('saved_internships', [
            'student_profile_id' => $profileId,
            'internship_id' => $internship->id,
        ]);

        Livewire::actingAs($user)
            ->test(InternshipSearch::class)
            ->call('toggleBookmark', $internship->id);

        $this->assertDatabaseMissing('saved_internships', [
            'student_profile_id' => $profileId,
            'internship_id' => $internship->id,
        ]);
    }

    public function test_it_can_apply_and_prevent_duplicates(): void
    {
        $user = User::factory()->create(['role' => 'student']);
        $internship = $this->createOpenInternship();

        Livewire::actingAs($user)
            ->test(InternshipSearch::class)
            ->call('applyNow', $internship->id)
            ->call('applyNow', $internship->id);

        $profileId = $user->refresh()->studentProfile->id;

        $this->assertDatabaseHas('applications', [
            'student_profile_id' => $profileId,
            'internship_id' => $internship->id,
        ]);

        $this->assertSame(
            1,
            Application::query()
                ->where('student_profile_id', $profileId)
                ->where('internship_id', $internship->id)
                ->count()
        );
    }

    public function test_it_can_save_search_payload(): void
    {
        $user = User::factory()->create(['role' => 'student']);

        Livewire::actingAs($user)
            ->test(InternshipSearch::class)
            ->set('keywords', 'Laravel')
            ->set('location', 'Remote')
            ->set('savedSearchName', 'Remote Laravel')
            ->call('saveSearch')
            ->assertHasNoErrors();

        $profileId = $user->refresh()->studentProfile->id;

        $this->assertDatabaseHas('saved_searches', [
            'student_profile_id' => $profileId,
            'name' => 'Remote Laravel',
        ]);

        $search = SavedSearch::query()
            ->where('student_profile_id', $profileId)
            ->where('name', 'Remote Laravel')
            ->firstOrFail();

        $this->assertSame('Laravel', $search->payload['keywords'] ?? null);
        $this->assertSame('Remote', $search->payload['location'] ?? null);
    }

    public function test_pagination_preserves_filters_across_pages(): void
    {
        $user = User::factory()->create(['role' => 'student']);
        $this->createOpenInternship(title: 'Laravel Internship 1');
        $this->createOpenInternship(title: 'Laravel Internship 2');
        $this->createOpenInternship(title: 'Laravel Internship 3');
        $this->createOpenInternship(title: 'Laravel Internship 4');
        $this->createOpenInternship(title: 'Laravel Internship 5');
        $this->createOpenInternship(title: 'Laravel Internship 6');
        $this->createOpenInternship(title: 'Laravel Internship 7');
        $this->createOpenInternship(title: 'Laravel Internship 8');
        $this->createOpenInternship(title: 'Laravel Internship 9');
        $this->createOpenInternship(title: 'Laravel Internship 10');
        $this->createOpenInternship(title: 'Laravel Internship 11');
        $other = $this->createOpenInternship(title: 'Something Else');
        $other->update([
            'description' => "Category: Design\n\nTags: Figma\n\nDesign things.",
        ]);

        Livewire::actingAs($user)
            ->test(InternshipSearch::class)
            ->set('keywords', 'Laravel')
            ->call('search')
            ->call('gotoPage', 2, 'page')
            ->assertSee('Laravel Internship 11')
            ->assertDontSee('Something Else');
    }

    private function createOpenInternship(string $title = 'Backend Internship'): Internship
    {
        $companyUser = User::factory()->create(['role' => 'company']);

        $companyProfile = CompanyProfile::create([
            'user_id' => $companyUser->id,
            'company_name' => 'TechCorp',
            'industry' => 'Software',
            'website' => 'https://example.test',
            'location' => 'Remote',
            'description' => 'Company description',
        ]);

        return Internship::create([
            'company_profile_id' => $companyProfile->id,
            'title' => $title,
            'location' => 'Remote',
            'type' => 'Remote',
            'duration' => '12 weeks',
            'description' => "Category: Software Engineering\n\nTags: Laravel, PHP\n\nBuild features.",
            'status' => 'open',
        ]);
    }
}
