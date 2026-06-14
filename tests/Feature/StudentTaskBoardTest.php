<?php

namespace Tests\Feature;

use App\Livewire\Student\TaskBoard;
use App\Models\CompanyProfile;
use App\Models\Internship;
use App\Models\StudentProfile;
use App\Models\Task;
use App\Models\TaskSubmission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Livewire\Livewire;
use Tests\TestCase;

class StudentTaskBoardTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_tasks_are_scoped_to_their_profile(): void
    {
        $student = User::factory()->create(['role' => 'student']);
        $otherStudent = User::factory()->create(['role' => 'student']);

        $internship = $this->createInternship();

        $studentProfile = StudentProfile::firstOrCreate(['user_id' => $student->id]);
        $otherProfile = StudentProfile::firstOrCreate(['user_id' => $otherStudent->id]);

        Task::create([
            'internship_id' => $internship->id,
            'student_profile_id' => $studentProfile->id,
            'title' => 'Student task',
            'status' => 'todo',
            'due_at' => Carbon::now()->addDays(2),
        ]);

        Task::create([
            'internship_id' => $internship->id,
            'student_profile_id' => $otherProfile->id,
            'title' => 'Other student task',
            'status' => 'todo',
            'due_at' => Carbon::now()->addDays(2),
        ]);

        Livewire::actingAs($student)
            ->test(TaskBoard::class)
            ->assertSee('Student task')
            ->assertDontSee('Other student task');
    }

    public function test_overdue_tab_filters_to_past_due_incomplete_tasks(): void
    {
        $student = User::factory()->create(['role' => 'student']);
        $profile = StudentProfile::firstOrCreate(['user_id' => $student->id]);
        $internship = $this->createInternship();

        Task::create([
            'internship_id' => $internship->id,
            'student_profile_id' => $profile->id,
            'title' => 'Overdue task',
            'status' => 'todo',
            'due_at' => Carbon::now()->subDays(1),
        ]);

        Task::create([
            'internship_id' => $internship->id,
            'student_profile_id' => $profile->id,
            'title' => 'Future task',
            'status' => 'todo',
            'due_at' => Carbon::now()->addDays(2),
        ]);

        Task::create([
            'internship_id' => $internship->id,
            'student_profile_id' => $profile->id,
            'title' => 'Completed past task',
            'status' => 'completed',
            'due_at' => Carbon::now()->subDays(5),
            'completed_at' => Carbon::now()->subDays(4),
        ]);

        Livewire::actingAs($student)
            ->test(TaskBoard::class)
            ->set('tab', 'overdue')
            ->assertViewHas('tasks', function ($tasks): bool {
                $titles = collect($tasks->items())->pluck('title')->all();

                return in_array('Overdue task', $titles, true)
                    && ! in_array('Future task', $titles, true)
                    && ! in_array('Completed past task', $titles, true);
            });
    }

    public function test_sorting_by_due_date_desc_changes_order(): void
    {
        $student = User::factory()->create(['role' => 'student']);
        $profile = StudentProfile::firstOrCreate(['user_id' => $student->id]);
        $internship = $this->createInternship();

        Task::create([
            'internship_id' => $internship->id,
            'student_profile_id' => $profile->id,
            'title' => 'Soon task',
            'status' => 'todo',
            'due_at' => Carbon::now()->addDays(1),
        ]);

        Task::create([
            'internship_id' => $internship->id,
            'student_profile_id' => $profile->id,
            'title' => 'Later task',
            'status' => 'todo',
            'due_at' => Carbon::now()->addDays(7),
        ]);

        Livewire::actingAs($student)
            ->test(TaskBoard::class)
            ->set('sort', 'due_desc')
            ->assertSeeInOrder(['Later task', 'Soon task']);
    }

    public function test_non_student_is_redirected_away_from_student_tasks_route(): void
    {
        $supervisor = User::factory()->create(['role' => 'supervisor']);

        $this->actingAs($supervisor)
            ->get(route('student.tasks.board'))
            ->assertRedirect(route('supervisor.dashboard'));
    }

    public function test_student_opens_task_submission_modal_from_submit_button(): void
    {
        $student = User::factory()->create(['role' => 'student']);
        $profile = StudentProfile::firstOrCreate(['user_id' => $student->id]);
        $internship = $this->createInternship();

        $task = Task::create([
            'internship_id' => $internship->id,
            'student_profile_id' => $profile->id,
            'title' => 'Ship dashboard refinements',
            'status' => 'todo',
            'due_at' => Carbon::now()->addDays(2),
        ]);

        Livewire::actingAs($student)
            ->test(TaskBoard::class)
            ->assertSee('Submit')
            ->assertDontSee('Choose Task')
            ->assertDontSee('Written Update')
            ->call('openSubmitModal')
            ->assertSet('showSubmitModal', true)
            ->assertSet('submissionTaskId', $task->id)
            ->assertSee('Choose Task')
            ->assertSee('Written Update')
            ->assertSee('Evidence Files');
    }

    public function test_student_can_submit_task_update_with_evidence_files(): void
    {
        Storage::fake('public');

        $student = User::factory()->create(['role' => 'student']);
        $profile = StudentProfile::firstOrCreate(['user_id' => $student->id]);
        $internship = $this->createInternship();

        $task = Task::create([
            'internship_id' => $internship->id,
            'student_profile_id' => $profile->id,
            'title' => 'API integration',
            'status' => 'todo',
            'due_at' => Carbon::now()->addDays(3),
        ]);

        $file = UploadedFile::fake()->create('evidence.pdf', 200, 'application/pdf');

        Livewire::actingAs($student)
            ->test(TaskBoard::class)
            ->call('openSubmitModal')
            ->set('submissionTaskId', $task->id)
            ->set('submissionUpdate', 'Completed the API integration and attached the response samples.')
            ->set('submissionFiles', [$file])
            ->call('submitTaskUpdate')
            ->assertHasNoErrors()
            ->assertSet('showSubmitModal', false)
            ->assertSee('Task update submitted successfully.');

        $submission = TaskSubmission::query()->where('task_id', $task->id)->first();

        $this->assertNotNull($submission);
        $this->assertSame('pending', $submission->status);
        $this->assertSame($profile->id, $submission->student_profile_id);
        $this->assertCount(1, $submission->attachments ?? []);
        $this->assertNotEmpty($submission->attachments[0]['path'] ?? null);
        Storage::disk('public')->assertExists($submission->attachments[0]['path']);

        $this->assertSame('in_progress', $task->fresh()->status);
    }

    public function test_duplicate_selected_evidence_files_are_only_stored_once(): void
    {
        Storage::fake('public');

        $student = User::factory()->create(['role' => 'student']);
        $profile = StudentProfile::firstOrCreate(['user_id' => $student->id]);
        $internship = $this->createInternship();

        $task = Task::create([
            'internship_id' => $internship->id,
            'student_profile_id' => $profile->id,
            'title' => 'Submit duplicate-safe evidence',
            'status' => 'in_progress',
            'due_at' => Carbon::now()->addDays(3),
        ]);

        $file = UploadedFile::fake()->create('evidence.txt', 20, 'text/plain');

        Livewire::actingAs($student)
            ->test(TaskBoard::class)
            ->call('openSubmitModal', $task->id)
            ->set('submissionUpdate', 'Resubmitted the same supporting file after clarifying the API flow.')
            ->set('submissionFiles', [$file, $file])
            ->call('submitTaskUpdate')
            ->assertHasNoErrors()
            ->assertSee('Task update submitted successfully.');

        $submission = TaskSubmission::query()->where('task_id', $task->id)->first();

        $this->assertNotNull($submission);
        $this->assertCount(1, $submission->attachments ?? []);
        Storage::disk('public')->assertExists($submission->attachments[0]['path']);
    }

    public function test_task_board_shows_submission_history_and_feedback(): void
    {
        $student = User::factory()->create(['role' => 'student']);
        $reviewer = User::factory()->create(['role' => 'supervisor']);
        $profile = StudentProfile::firstOrCreate(['user_id' => $student->id]);
        $internship = $this->createInternship();

        $task = Task::create([
            'internship_id' => $internship->id,
            'student_profile_id' => $profile->id,
            'title' => 'Prepare deployment notes',
            'status' => 'in_progress',
            'due_at' => Carbon::now()->addDays(4),
        ]);

        TaskSubmission::create([
            'task_id' => $task->id,
            'student_profile_id' => $profile->id,
            'status' => 'reviewed',
            'update_text' => 'Initial deployment checklist and screenshots shared.',
            'reviewer_feedback' => 'Looks good. Please add rollback details.',
            'reviewed_by_user_id' => $reviewer->id,
            'submitted_at' => Carbon::now()->subDay(),
            'reviewed_at' => Carbon::now()->subHours(20),
        ]);

        TaskSubmission::create([
            'task_id' => $task->id,
            'student_profile_id' => $profile->id,
            'status' => 'rework',
            'update_text' => 'Added rollback notes but logs are still missing.',
            'reviewer_feedback' => 'Needs more test coverage evidence.',
            'reviewed_by_user_id' => $reviewer->id,
            'submitted_at' => Carbon::now()->subHours(2),
            'reviewed_at' => Carbon::now()->subHour(),
        ]);

        Livewire::actingAs($student)
            ->test(TaskBoard::class)
            ->call('selectTask', $task->id)
            ->assertSee('Submission History')
            ->assertSee('Rework')
            ->assertSee('Reviewed')
            ->assertSee('Needs more test coverage evidence.')
            ->assertSee('Looks good. Please add rollback details.');
    }

    public function test_student_can_resubmit_without_overwriting_previous_submission(): void
    {
        $student = User::factory()->create(['role' => 'student']);
        $profile = StudentProfile::firstOrCreate(['user_id' => $student->id]);
        $internship = $this->createInternship();

        $task = Task::create([
            'internship_id' => $internship->id,
            'student_profile_id' => $profile->id,
            'title' => 'Finalize onboarding guide',
            'status' => 'in_progress',
            'due_at' => Carbon::now()->addDays(5),
        ]);

        TaskSubmission::create([
            'task_id' => $task->id,
            'student_profile_id' => $profile->id,
            'status' => 'rework',
            'update_text' => 'First draft submitted for review.',
            'reviewer_feedback' => 'Please add screenshots.',
            'submitted_at' => Carbon::now()->subDay(),
            'reviewed_at' => Carbon::now()->subHours(23),
        ]);

        Livewire::actingAs($student)
            ->test(TaskBoard::class)
            ->call('openSubmitModal', $task->id)
            ->set('submissionUpdate', 'Added screenshots and clarified each onboarding step.')
            ->call('submitTaskUpdate')
            ->assertHasNoErrors()
            ->assertSee('Task update submitted successfully.');

        $submissions = TaskSubmission::query()
            ->where('task_id', $task->id)
            ->orderBy('submitted_at')
            ->get();

        $this->assertCount(2, $submissions);
        $this->assertSame('First draft submitted for review.', $submissions[0]->update_text);
        $this->assertSame('Added screenshots and clarified each onboarding step.', $submissions[1]->update_text);
        $this->assertSame('pending', $submissions[1]->status);
    }

    public function test_student_cannot_submit_update_for_another_students_task(): void
    {
        $student = User::factory()->create(['role' => 'student']);
        $otherStudent = User::factory()->create(['role' => 'student']);
        StudentProfile::firstOrCreate(['user_id' => $student->id]);
        $otherProfile = StudentProfile::firstOrCreate(['user_id' => $otherStudent->id]);
        $internship = $this->createInternship();

        $task = Task::create([
            'internship_id' => $internship->id,
            'student_profile_id' => $otherProfile->id,
            'title' => 'Other student task',
            'status' => 'todo',
            'due_at' => Carbon::now()->addDays(2),
        ]);

        $this->expectException(ModelNotFoundException::class);

        Livewire::actingAs($student)
            ->test(TaskBoard::class)
            ->set('submissionTaskId', $task->id)
            ->set('submissionUpdate', 'This should not be accepted because I do not own the task.')
            ->call('submitTaskUpdate');
    }

    public function test_student_task_update_requires_written_update(): void
    {
        $student = User::factory()->create(['role' => 'student']);
        $profile = StudentProfile::firstOrCreate(['user_id' => $student->id]);
        $internship = $this->createInternship();

        $task = Task::create([
            'internship_id' => $internship->id,
            'student_profile_id' => $profile->id,
            'title' => 'Write summary',
            'status' => 'todo',
            'due_at' => Carbon::now()->addDays(1),
        ]);

        Livewire::actingAs($student)
            ->test(TaskBoard::class)
            ->call('openSubmitModal', $task->id)
            ->set('submissionUpdate', 'short')
            ->call('submitTaskUpdate')
            ->assertHasErrors(['submissionUpdate' => ['min']]);

        $this->assertDatabaseCount('task_submissions', 0);
    }

    private function createInternship(): Internship
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
            'title' => 'Backend Internship',
            'location' => 'Remote',
            'type' => 'Remote',
            'duration' => '12 weeks',
            'description' => "Category: Software Engineering\n\nTags: Laravel, PHP\n\nBuild features.",
            'status' => 'open',
        ]);
    }
}
