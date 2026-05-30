<?php

namespace Tests\Feature;

use App\Livewire\Student\LogbookSubmission;
use App\Models\Application;
use App\Models\CompanyProfile;
use App\Models\Internship;
use App\Models\Logbook;
use App\Models\StudentProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Livewire\Livewire;
use Tests\TestCase;

class StudentLogbookSubmissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_logbook_entries_are_scoped_to_their_profile(): void
    {
        $student = User::factory()->create(['role' => 'student']);
        $otherStudent = User::factory()->create(['role' => 'student']);

        $internship = $this->createInternship();

        $studentProfile = StudentProfile::firstOrCreate(['user_id' => $student->id]);
        $otherProfile = StudentProfile::firstOrCreate(['user_id' => $otherStudent->id]);

        Logbook::create([
            'internship_id' => $internship->id,
            'student_profile_id' => $studentProfile->id,
            'entry_date' => Carbon::now()->subDays(1)->toDateString(),
            'content' => "Student entry\n\nDid work.",
            'status' => 'draft',
        ]);

        Logbook::create([
            'internship_id' => $internship->id,
            'student_profile_id' => $otherProfile->id,
            'entry_date' => Carbon::now()->subDays(2)->toDateString(),
            'content' => "Other entry\n\nDid work.",
            'status' => 'draft',
        ]);

        Livewire::actingAs($student)
            ->test(LogbookSubmission::class)
            ->assertSee('Student entry')
            ->assertDontSee('Other entry');
    }

    public function test_drafts_tab_filters_to_draft_entries(): void
    {
        $student = User::factory()->create(['role' => 'student']);
        $profile = StudentProfile::firstOrCreate(['user_id' => $student->id]);

        $internship = $this->createInternship();

        Logbook::create([
            'internship_id' => $internship->id,
            'student_profile_id' => $profile->id,
            'entry_date' => Carbon::now()->subDays(1)->toDateString(),
            'content' => "Draft entry\n\nDraft body.",
            'status' => 'draft',
        ]);

        Logbook::create([
            'internship_id' => $internship->id,
            'student_profile_id' => $profile->id,
            'entry_date' => Carbon::now()->subDays(2)->toDateString(),
            'content' => "Approved entry\n\nApproved body.",
            'status' => 'approved',
        ]);

        Livewire::actingAs($student)
            ->test(LogbookSubmission::class)
            ->set('tab', 'draft')
            ->assertSee('Draft entry')
            ->assertDontSee('Approved entry');
    }

    public function test_student_can_create_and_submit_a_logbook_entry(): void
    {
        $student = User::factory()->create(['role' => 'student']);
        $profile = StudentProfile::firstOrCreate(['user_id' => $student->id]);
        $internship = $this->createInternship();

        Application::create([
            'student_profile_id' => $profile->id,
            'internship_id' => $internship->id,
            'status' => 'accepted',
            'decided_at' => Carbon::now()->subDays(7),
        ]);

        $date = Carbon::now()->subDay()->toDateString();

        Livewire::actingAs($student)
            ->test(LogbookSubmission::class)
            ->set('entryDate', $date)
            ->set('entryTitle', 'My new entry')
            ->set('entryBody', 'Worked on the logbook UI.')
            ->call('saveEntry');

        $this->assertTrue(Logbook::query()
            ->where('student_profile_id', $profile->id)
            ->where('internship_id', $internship->id)
            ->whereDate('entry_date', $date)
            ->where('status', 'draft')
            ->exists());

        $logbookId = (int) Logbook::query()
            ->where('student_profile_id', $profile->id)
            ->where('internship_id', $internship->id)
            ->whereDate('entry_date', $date)
            ->value('id');

        Livewire::actingAs($student)
            ->test(LogbookSubmission::class)
            ->call('submitEntry', $logbookId);

        $this->assertSame('submitted', Logbook::query()->whereKey($logbookId)->value('status'));
    }

    private function createInternship(): Internship
    {
        $companyUser = User::factory()->create(['role' => 'company']);

        $companyProfile = CompanyProfile::create([
            'user_id' => $companyUser->id,
            'company_name' => 'TechNova Solutions',
            'industry' => 'Software',
            'website' => 'https://example.test',
            'location' => 'Remote',
            'description' => 'Company description',
        ]);

        return Internship::create([
            'company_profile_id' => $companyProfile->id,
            'title' => 'Web Development Intern',
            'location' => 'Remote',
            'type' => 'Remote',
            'duration' => '12 weeks',
            'description' => "Category: Software Engineering\n\nTags: Laravel, PHP\n\nBuild features.",
            'status' => 'open',
            'start_date' => Carbon::now()->subMonths(1)->toDateString(),
            'end_date' => Carbon::now()->addMonths(5)->toDateString(),
        ]);
    }
}
