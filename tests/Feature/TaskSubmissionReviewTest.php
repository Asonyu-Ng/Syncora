<?php

namespace Tests\Feature;

use App\Livewire\Company\TaskAssignment as CompanyTaskAssignment;
use App\Livewire\Supervisor\TaskAssignment as SupervisorTaskAssignment;
use App\Models\CompanyProfile;
use App\Models\Internship;
use App\Models\StudentProfile;
use App\Models\SupervisorProfile;
use App\Models\Task;
use App\Models\TaskSubmission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Livewire\Livewire;
use Tests\TestCase;

class TaskSubmissionReviewTest extends TestCase
{
    use RefreshDatabase;

    public function test_supervisor_task_screen_only_shows_supervised_tasks(): void
    {
        $supervisor = User::factory()->create(['role' => 'supervisor']);
        $supervisorProfile = SupervisorProfile::create(['user_id' => $supervisor->id]);

        $visibleTask = $this->createTaskForActors($this->createCompanyActor(), $supervisorProfile, 'Visible supervisor task');
        $hiddenTask = $this->createTaskForActors($this->createCompanyActor(), SupervisorProfile::create([
            'user_id' => User::factory()->create(['role' => 'supervisor'])->id,
        ]), 'Hidden supervisor task');

        Livewire::actingAs($supervisor)
            ->test(SupervisorTaskAssignment::class)
            ->assertSee($visibleTask->title)
            ->assertDontSee($hiddenTask->title);
    }

    public function test_company_task_screen_only_shows_company_tasks(): void
    {
        $company = User::factory()->create(['role' => 'company']);
        $companyProfile = CompanyProfile::create([
            'user_id' => $company->id,
            'company_name' => 'Visible Company',
        ]);

        $visibleTask = $this->createTaskForActors($companyProfile, $this->createSupervisorActor(), 'Visible company task');
        $hiddenTask = $this->createTaskForActors(CompanyProfile::create([
            'user_id' => User::factory()->create(['role' => 'company'])->id,
            'company_name' => 'Hidden Company',
        ]), $this->createSupervisorActor(), 'Hidden company task');

        Livewire::actingAs($company)
            ->test(CompanyTaskAssignment::class)
            ->assertSee($visibleTask->title)
            ->assertDontSee($hiddenTask->title);
    }

    public function test_supervisor_can_mark_latest_submission_reviewed_with_feedback(): void
    {
        $supervisor = User::factory()->create(['role' => 'supervisor']);
        $supervisorProfile = SupervisorProfile::create(['user_id' => $supervisor->id]);
        $task = $this->createTaskForActors($this->createCompanyActor(), $supervisorProfile, 'Supervisor review task');

        $submission = TaskSubmission::create([
            'task_id' => $task->id,
            'student_profile_id' => $task->student_profile_id,
            'status' => 'pending',
            'update_text' => 'Attached the completed API evidence and summary.',
            'submitted_at' => Carbon::now()->subHour(),
        ]);

        Livewire::actingAs($supervisor)
            ->test(SupervisorTaskAssignment::class)
            ->call('selectTask', $task->id)
            ->set('reviewerFeedback', 'Approved after checking the evidence and summary.')
            ->call('markSubmissionReviewed')
            ->assertHasNoErrors()
            ->assertSee('Submission marked as reviewed.');

        $submission->refresh();

        $this->assertSame('reviewed', $submission->status);
        $this->assertSame($supervisor->id, $submission->reviewed_by_user_id);
        $this->assertSame('Approved after checking the evidence and summary.', $submission->reviewer_feedback);
        $this->assertNotNull($submission->reviewed_at);
    }

    public function test_company_can_request_rework_with_feedback(): void
    {
        $company = User::factory()->create(['role' => 'company']);
        $companyProfile = CompanyProfile::create([
            'user_id' => $company->id,
            'company_name' => 'Reviewing Company',
        ]);
        $task = $this->createTaskForActors($companyProfile, $this->createSupervisorActor(), 'Company review task');

        $submission = TaskSubmission::create([
            'task_id' => $task->id,
            'student_profile_id' => $task->student_profile_id,
            'status' => 'pending',
            'update_text' => 'Submitted the first draft and supporting screenshots.',
            'submitted_at' => Carbon::now()->subHour(),
        ]);

        Livewire::actingAs($company)
            ->test(CompanyTaskAssignment::class)
            ->call('selectTask', $task->id)
            ->set('reviewerFeedback', 'Please add customer-facing screenshots and test notes.')
            ->call('markSubmissionForRework')
            ->assertHasNoErrors()
            ->assertSee('Submission sent back for rework.');

        $submission->refresh();

        $this->assertSame('rework', $submission->status);
        $this->assertSame($company->id, $submission->reviewed_by_user_id);
        $this->assertSame('Please add customer-facing screenshots and test notes.', $submission->reviewer_feedback);
        $this->assertNotNull($submission->reviewed_at);
    }

    private function createTaskForActors(
        CompanyProfile $companyProfile,
        SupervisorProfile $supervisorProfile,
        string $title
    ): Task {
        $student = User::factory()->create(['role' => 'student']);
        $studentProfile = StudentProfile::create([
            'user_id' => $student->id,
            'department' => 'Software Engineering',
        ]);

        $internship = Internship::create([
            'company_profile_id' => $companyProfile->id,
            'supervisor_profile_id' => $supervisorProfile->id,
            'title' => $title . ' Internship',
            'location' => 'Remote',
            'type' => 'Remote',
            'duration' => '12 weeks',
            'description' => 'Internship description',
            'status' => 'open',
        ]);

        return Task::create([
            'internship_id' => $internship->id,
            'student_profile_id' => $studentProfile->id,
            'assigned_by_user_id' => $supervisorProfile->user_id ?? $companyProfile->user_id,
            'title' => $title,
            'description' => 'Review the submitted work package.',
            'status' => 'in_progress',
            'due_at' => Carbon::now()->addDays(3),
        ]);
    }

    private function createCompanyActor(): CompanyProfile
    {
        $company = User::factory()->create(['role' => 'company']);

        return CompanyProfile::create([
            'user_id' => $company->id,
            'company_name' => 'Example Company ' . $company->id,
            'industry' => 'Software',
            'website' => 'https://example.test',
            'location' => 'Remote',
            'description' => 'Company profile for testing',
        ]);
    }

    private function createSupervisorActor(): SupervisorProfile
    {
        $supervisor = User::factory()->create(['role' => 'supervisor']);

        return SupervisorProfile::create([
            'user_id' => $supervisor->id,
            'department' => 'Computer Science',
            'position' => 'Lecturer',
        ]);
    }
}
