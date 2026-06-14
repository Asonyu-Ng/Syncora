<?php

namespace Tests\Feature;

use App\Jobs\Exports\ExportLogbooksJob;
use App\Livewire\Supervisor\LogbookApproval;
use App\Models\CompanyProfile;
use App\Models\Internship;
use App\Models\Logbook;
use App\Models\StudentProfile;
use App\Models\SupervisorProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Bus;
use Livewire\Livewire;
use Tests\TestCase;

class SupervisorLogbookApprovalTest extends TestCase
{
    use RefreshDatabase;

    public function test_supervisor_can_approve_submitted_logbook(): void
    {
        $supervisor = User::factory()->create(['role' => 'supervisor']);
        $supervisorProfile = SupervisorProfile::create(['user_id' => $supervisor->id]);

        $logbook = $this->createLogbookForSupervisor($supervisorProfile->id, status: 'submitted');

        Livewire::actingAs($supervisor)
            ->test(LogbookApproval::class)
            ->call('approve', $logbook->id)
            ->assertHasNoErrors();

        $this->assertDatabaseHas('logbooks', [
            'id' => $logbook->id,
            'status' => 'approved',
            'approved_by_user_id' => $supervisor->id,
        ]);

        $this->assertNotNull(Logbook::query()->whereKey($logbook->id)->value('approved_at'));
    }

    public function test_supervisor_can_return_submitted_logbook(): void
    {
        $supervisor = User::factory()->create(['role' => 'supervisor']);
        $supervisorProfile = SupervisorProfile::create(['user_id' => $supervisor->id]);

        $logbook = $this->createLogbookForSupervisor($supervisorProfile->id, status: 'submitted');

        Livewire::actingAs($supervisor)
            ->test(LogbookApproval::class)
            ->call('returnEntry', $logbook->id)
            ->assertHasNoErrors();

        $this->assertDatabaseHas('logbooks', [
            'id' => $logbook->id,
            'status' => 'returned',
            'approved_by_user_id' => null,
            'approved_at' => null,
        ]);
    }

    public function test_export_dispatches_job_with_current_filters(): void
    {
        Bus::fake();

        $supervisor = User::factory()->create(['role' => 'supervisor']);
        $supervisorProfile = SupervisorProfile::create(['user_id' => $supervisor->id]);

        $logbook = $this->createLogbookForSupervisor($supervisorProfile->id, status: 'approved');

        Livewire::actingAs($supervisor)
            ->test(LogbookApproval::class)
            ->set('tab', 'reviewed')
            ->set('internship', (string) $logbook->internship_id)
            ->set('search', 'keyword')
            ->call('export');

        Bus::assertDispatched(ExportLogbooksJob::class, function (ExportLogbooksJob $job) use ($supervisorProfile, $logbook): bool {
            return $job->requestedByUserId === $supervisorProfile->user_id
                && ($job->filters['supervisor_profile_id'] ?? null) === $supervisorProfile->id
                && ($job->filters['internship_id'] ?? null) === (string) $logbook->internship_id
                && ($job->filters['q'] ?? null) === 'keyword'
                && ($job->filters['statuses'] ?? null) === ['approved', 'returned']
                && $job->queue === 'exports';
        });
    }

    private function createLogbookForSupervisor(int $supervisorProfileId, string $status = 'submitted'): Logbook
    {
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
            'supervisor_profile_id' => $supervisorProfileId,
            'title' => 'Internship',
            'location' => 'Remote',
            'type' => 'Remote',
            'duration' => '12 weeks',
            'description' => 'Description',
            'status' => 'open',
        ]);

        $student = User::factory()->create(['role' => 'student']);
        $studentProfile = StudentProfile::create(['user_id' => $student->id]);

        return Logbook::create([
            'internship_id' => $internship->id,
            'student_profile_id' => $studentProfile->id,
            'entry_date' => now()->toDateString(),
            'content' => 'This is a keyword entry.',
            'status' => $status,
        ]);
    }
}

