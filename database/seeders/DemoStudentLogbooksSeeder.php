<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\Internship;
use App\Models\Logbook;
use App\Models\StudentProfile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class DemoStudentLogbooksSeeder extends Seeder
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

        $supervisor = User::query()->where('role', 'supervisor')->first();

        if (! $supervisor) {
            $supervisor = User::create([
                'name' => 'Supervisor User',
                'email' => 'supervisor@syncora.test',
                'password' => Hash::make('password'),
                'role' => 'supervisor',
                'email_verified_at' => now(),
            ]);
        }

        $application = Application::query()
            ->with('internship')
            ->where('student_profile_id', $profile->id)
            ->where('status', 'accepted')
            ->orderByDesc('decided_at')
            ->orderByDesc('updated_at')
            ->first();

        $internship = $application?->internship
            ?? Internship::query()->whereNotNull('supervisor_profile_id')->first()
            ?? Internship::query()->first();

        if (! $internship) {
            return;
        }

        if (! $application) {
            Application::updateOrCreate(
                [
                    'student_profile_id' => $profile->id,
                    'internship_id' => $internship->id,
                ],
                [
                    'status' => 'accepted',
                    'decided_at' => Carbon::now()->subDays(10),
                ],
            );
        }

        $faker = fake();
        $today = Carbon::now()->startOfDay();

        $plan = [
            ['status' => 'approved', 'count' => 8],
            ['status' => 'submitted', 'count' => 2],
            ['status' => 'draft', 'count' => 2],
            ['status' => 'returned', 'count' => 1],
        ];

        $titles = [
            'Implemented user authentication system',
            'Build dashboard UI components',
            'Database design and setup',
            'Project requirement analysis',
            'Setup development environment',
            'Wrote API documentation',
            'Refactored internship search UI',
            'Fixed pagination and layout issues',
            'Prepared weekly progress report',
            'Reviewed supervisor feedback',
            'Updated logbook formatting',
            'Added unit tests for features',
            'Optimized database queries',
        ];

        $cursor = 0;
        $offsetDays = 0;

        foreach ($plan as $entry) {
            for ($i = 0; $i < $entry['count']; $i++) {
                $title = $titles[$cursor % count($titles)];
                $cursor++;

                $date = $today->copy()->subDays($offsetDays);
                $offsetDays++;

                $body = implode("\n\n", [
                    $faker->sentence(),
                    $faker->paragraphs(2, true),
                    'Tools: ' . implode(', ', $faker->randomElements(['Laravel', 'Livewire', 'Tailwind', 'MySQL', 'Git', 'PHPUnit'], $faker->numberBetween(2, 4))),
                ]);

                $payload = $title . "\n\n" . $body;

                $attributes = [
                    'internship_id' => $internship->id,
                    'student_profile_id' => $profile->id,
                    'entry_date' => $date->toDateString(),
                ];

                $values = [
                    'content' => $payload,
                    'status' => $entry['status'],
                    'approved_by_user_id' => null,
                    'approved_at' => null,
                    'created_at' => $date->copy()->addHours(10),
                    'updated_at' => $date->copy()->addHours(10),
                ];

                if ($entry['status'] === 'approved') {
                    $values['approved_by_user_id'] = $supervisor->id;
                    $values['approved_at'] = $date->copy()->addHours(16);
                }

                Logbook::updateOrCreate($attributes, $values);
            }
        }
    }
}

