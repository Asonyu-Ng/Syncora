<?php

namespace Tests\Feature;

use App\Livewire\Student\AiReportGenerator;
use App\Models\Application;
use App\Models\CompanyProfile;
use App\Models\Internship;
use App\Models\Logbook;
use App\Models\Report;
use App\Models\StudentProfile;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Livewire\Livewire;
use Tests\TestCase;

class StudentAiReportGeneratorTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_can_generate_a_report_and_it_is_persisted(): void
    {
        $student = User::factory()->create(['role' => 'student']);
        $profile = StudentProfile::firstOrCreate(['user_id' => $student->id]);
        $internship = $this->createInternship();

        Application::create([
            'student_profile_id' => $profile->id,
            'internship_id' => $internship->id,
            'status' => 'accepted',
            'decided_at' => Carbon::now()->subDays(10),
        ]);

        Logbook::create([
            'internship_id' => $internship->id,
            'student_profile_id' => $profile->id,
            'entry_date' => Carbon::now()->subDays(2)->toDateString(),
            'content' => "Built authentication flow\n\nTools: Laravel, Livewire\n\nImplemented login and middleware.",
            'status' => 'submitted',
        ]);

        Task::create([
            'internship_id' => $internship->id,
            'student_profile_id' => $profile->id,
            'title' => 'Implement dashboard',
            'status' => 'completed',
            'completed_at' => Carbon::now()->subDays(1),
        ]);

        Livewire::actingAs($student)
            ->test(AiReportGenerator::class)
            ->set('internshipId', $internship->id)
            ->set('reportType', 'final')
            ->set('periodStart', Carbon::now()->subDays(14)->toDateString())
            ->set('periodEnd', Carbon::now()->toDateString())
            ->call('generateReport')
            ->assertDispatched('open-modal', 'ai-report-preview');

        $this->assertTrue(Report::query()
            ->where('student_profile_id', $profile->id)
            ->where('internship_id', $internship->id)
            ->where('type', 'final')
            ->exists());
    }

    public function test_student_only_sees_their_own_reports(): void
    {
        $student = User::factory()->create(['role' => 'student']);
        $otherStudent = User::factory()->create(['role' => 'student']);

        $profile = StudentProfile::firstOrCreate(['user_id' => $student->id]);
        $otherProfile = StudentProfile::firstOrCreate(['user_id' => $otherStudent->id]);

        $internship = $this->createInternship();

        Report::create([
            'user_id' => $student->id,
            'student_profile_id' => $profile->id,
            'internship_id' => $internship->id,
            'name' => 'Student Report',
            'type' => 'final',
            'status' => 'ready',
            'content' => 'Student content',
            'generated_at' => Carbon::now(),
        ]);

        Report::create([
            'user_id' => $otherStudent->id,
            'student_profile_id' => $otherProfile->id,
            'internship_id' => $internship->id,
            'name' => 'Other Report',
            'type' => 'final',
            'status' => 'ready',
            'content' => 'Other content',
            'generated_at' => Carbon::now(),
        ]);

        Livewire::actingAs($student)
            ->test(AiReportGenerator::class)
            ->assertSee('Student Report')
            ->assertDontSee('Other Report');
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

