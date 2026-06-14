<?php

namespace Tests\Feature;

use App\Jobs\Exports\ExportMonitoringJob;
use App\Livewire\Supervisor\InternshipMonitoring;
use App\Models\Application;
use App\Models\CompanyProfile;
use App\Models\Internship;
use App\Models\Logbook;
use App\Models\StudentProfile;
use App\Models\SupervisorProfile;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Bus;
use Livewire\Livewire;
use Tests\TestCase;

class SupervisorInternshipMonitoringTest extends TestCase
{
    use RefreshDatabase;

    public function test_supervisor_can_filter_students_by_activity_bucket(): void
    {
        $supervisor = User::factory()->create(['role' => 'supervisor']);
        $supervisorProfile = SupervisorProfile::create(['user_id' => $supervisor->id]);

        $companyUser = User::factory()->create(['role' => 'company']);
        $companyProfile = CompanyProfile::create([
            'user_id' => $companyUser->id,
            'company_name' => 'Company',
            'industry' => 'Software',
            'website' => 'https://example.test',
            'location' => 'Remote',
            'description' => 'Description',
        ]);

        $internship = Internship::create([
            'company_profile_id' => $companyProfile->id,
            'supervisor_profile_id' => $supervisorProfile->id,
            'title' => 'Internship',
            'location' => 'Remote',
            'type' => 'Remote',
            'duration' => '12 weeks',
            'description' => 'Description',
            'status' => 'open',
        ]);

        $studentActive = User::factory()->create(['role' => 'student', 'name' => 'Active Student']);
        $studentActiveProfile = StudentProfile::create(['user_id' => $studentActive->id]);

        Application::create([
            'internship_id' => $internship->id,
            'student_profile_id' => $studentActiveProfile->id,
            'status' => 'accepted',
        ]);

        Logbook::create([
            'internship_id' => $internship->id,
            'student_profile_id' => $studentActiveProfile->id,
            'entry_date' => Carbon::now()->subDay()->toDateString(),
            'content' => 'Entry',
            'status' => 'submitted',
        ]);

        $studentInactive = User::factory()->create(['role' => 'student', 'name' => 'Old Student']);
        $studentInactiveProfile = StudentProfile::create(['user_id' => $studentInactive->id]);

        Application::create([
            'internship_id' => $internship->id,
            'student_profile_id' => $studentInactiveProfile->id,
            'status' => 'accepted',
        ]);

        $task = Task::create([
            'internship_id' => $internship->id,
            'student_profile_id' => $studentInactiveProfile->id,
            'assigned_by_user_id' => $supervisor->id,
            'title' => 'Old Task',
            'description' => 'Description',
            'status' => 'todo',
            'due_at' => Carbon::now()->addDays(7),
            'completed_at' => null,
        ]);

        $task->forceFill([
            'created_at' => Carbon::now()->subDays(20),
            'updated_at' => Carbon::now()->subDays(20),
        ])->save();

        Livewire::actingAs($supervisor)
            ->test(InternshipMonitoring::class)
            ->set('status', '')
            ->assertViewHas('rows', function ($rows): bool {
                $names = collect($rows->items())->pluck('student_name')->all();

                return $rows->total() === 2
                    && in_array('Active Student', $names, true)
                    && in_array('Old Student', $names, true);
            })
            ->set('status', 'active')
            ->assertViewHas('rows', function ($rows): bool {
                $names = collect($rows->items())->pluck('student_name')->all();

                return $rows->total() === 1
                    && in_array('Active Student', $names, true)
                    && ! in_array('Old Student', $names, true);
            })
            ->set('status', 'not_active')
            ->assertViewHas('rows', function ($rows): bool {
                $names = collect($rows->items())->pluck('student_name')->all();

                return $rows->total() === 1
                    && in_array('Old Student', $names, true)
                    && ! in_array('Active Student', $names, true);
            });
    }

    public function test_export_dispatches_job_with_current_filters(): void
    {
        Bus::fake();

        $supervisor = User::factory()->create(['role' => 'supervisor']);
        $supervisorProfile = SupervisorProfile::create(['user_id' => $supervisor->id]);

        $companyUser = User::factory()->create(['role' => 'company']);
        $companyProfile = CompanyProfile::create([
            'user_id' => $companyUser->id,
            'company_name' => 'Company',
            'industry' => 'Software',
            'website' => 'https://example.test',
            'location' => 'Remote',
            'description' => 'Description',
        ]);

        $internship = Internship::create([
            'company_profile_id' => $companyProfile->id,
            'supervisor_profile_id' => $supervisorProfile->id,
            'title' => 'Internship',
            'location' => 'Remote',
            'type' => 'Remote',
            'duration' => '12 weeks',
            'description' => 'Description',
            'status' => 'open',
        ]);

        $student = User::factory()->create(['role' => 'student', 'name' => 'Export Student']);
        $studentProfile = StudentProfile::create(['user_id' => $student->id]);

        Application::create([
            'internship_id' => $internship->id,
            'student_profile_id' => $studentProfile->id,
            'status' => 'accepted',
        ]);

        Livewire::actingAs($supervisor)
            ->test(InternshipMonitoring::class)
            ->set('internship', (string) $internship->id)
            ->set('company', (string) $companyProfile->id)
            ->set('status', 'active')
            ->set('search', 'Export Student')
            ->call('export');

        Bus::assertDispatched(ExportMonitoringJob::class, function (ExportMonitoringJob $job) use ($supervisorProfile, $internship, $companyProfile): bool {
            return $job->requestedByUserId === $supervisorProfile->user_id
                && ($job->filters['supervisor_profile_id'] ?? null) === $supervisorProfile->id
                && ($job->filters['internship_id'] ?? null) === (string) $internship->id
                && ($job->filters['company_id'] ?? null) === (string) $companyProfile->id
                && ($job->filters['status_bucket'] ?? null) === 'active'
                && ($job->filters['q'] ?? null) === 'Export Student'
                && $job->queue === 'exports';
        });
    }
}
