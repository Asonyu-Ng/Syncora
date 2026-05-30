<?php

namespace Tests\Feature;

use App\Livewire\Student\TaskBoard;
use App\Models\CompanyProfile;
use App\Models\Internship;
use App\Models\StudentProfile;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
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
