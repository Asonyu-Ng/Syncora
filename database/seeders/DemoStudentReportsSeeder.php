<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\Internship;
use App\Models\Report;
use App\Models\StudentProfile;
use App\Models\User;
use App\Services\ReportService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class DemoStudentReportsSeeder extends Seeder
{
    public function run(): void
    {
        if (app()->environment('production')) {
            return;
        }

        $student = User::query()
            ->where('role', 'student')
            ->where('email', 'student@syncora.test')
            ->first()
            ?? User::query()->where('role', 'student')->first();

        if (! $student) {
            return;
        }

        $profile = StudentProfile::query()->firstOrCreate([
            'user_id' => $student->id,
        ]);

        $application = Application::query()
            ->with(['internship.companyProfile'])
            ->where('student_profile_id', $profile->id)
            ->where('status', 'accepted')
            ->orderByDesc('decided_at')
            ->first();

        $internship = $application?->internship
            ?? Internship::query()->with('companyProfile')->first();

        if (! $internship) {
            return;
        }

        $templates = [
            ['type' => 'final', 'name' => 'Final Internship Report', 'days' => 4],
            ['type' => 'monthly', 'name' => 'Monthly Progress Report - April', 'days' => 30],
            ['type' => 'technical', 'name' => 'Technical Implementation Report', 'days' => 49],
            ['type' => 'monthly', 'name' => 'Monthly Progress Report - March', 'days' => 80],
        ];

        foreach ($templates as $entry) {
            $generatedAt = Carbon::now()->subDays((int) $entry['days']);
            $periodStart = $generatedAt->copy()->subDays(14);
            $periodEnd = $generatedAt->copy();

            $content = app(ReportService::class)->generateStudentReportFromContext([
                'report_type' => $entry['name'],
                'student_name' => $student->name,
                'internship_title' => $internship->title,
                'company_name' => $internship->companyProfile?->company_name ?? '',
                'period_label' => $periodStart->format('M j, Y') . ' - ' . $periodEnd->format('M j, Y'),
                'logbooks' => [],
                'tasks' => [],
                'skills' => [],
            ]);

            Report::updateOrCreate(
                [
                    'user_id' => $student->id,
                    'student_profile_id' => $profile->id,
                    'internship_id' => $internship->id,
                    'name' => $entry['name'],
                ],
                [
                    'type' => $entry['type'],
                    'status' => 'ready',
                    'content' => $content,
                    'generated_at' => $generatedAt,
                    'created_at' => $generatedAt,
                    'updated_at' => $generatedAt,
                ],
            );
        }
    }
}

