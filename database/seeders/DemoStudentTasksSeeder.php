<?php

namespace Database\Seeders;

use App\Models\Internship;
use App\Models\StudentProfile;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class DemoStudentTasksSeeder extends Seeder
{
    public function run(): void
    {
        if (app()->environment('production')) {
            return;
        }

        $user = User::query()
            ->where('role', 'student')
            ->where('email', 'student@syncora.test')
            ->first()
            ?? User::query()->where('role', 'student')->first();

        if (! $user) {
            return;
        }

        $profile = StudentProfile::query()->firstOrCreate([
            'user_id' => $user->id,
        ]);

        if (Task::query()->where('student_profile_id', $profile->id)->exists()) {
            return;
        }

        $internships = Internship::query()
            ->select(['id', 'title'])
            ->orderBy('id')
            ->limit(12)
            ->get();

        if ($internships->isEmpty()) {
            return;
        }

        $assignedById = User::query()
            ->whereIn('role', ['supervisor', 'company', 'admin'])
            ->value('id');

        $faker = fake();
        $now = Carbon::now();

        $templates = [
            'Review onboarding checklist for :internship',
            'Prepare weekly progress update for :internship',
            'Submit logbook entry for :internship',
            'Implement the next feature milestone for :internship',
            'Schedule a check-in with your supervisor for :internship',
            'Read project documentation for :internship',
            'Fix assigned bugs for :internship',
            'Draft end-of-week recap for :internship',
            'Complete code review notes for :internship',
            'Update your internship report outline for :internship',
        ];

        $plan = [
            ['status' => 'todo', 'count' => 6, 'due' => [-5, -2, 1, 3, 7, 14]],
            ['status' => 'in_progress', 'count' => 4, 'due' => [-3, 2, 5, 9]],
            ['status' => 'completed', 'count' => 5, 'due' => [-14, -10, -6, -2, 4]],
        ];

        $cursor = 0;

        foreach ($plan as $entry) {
            for ($i = 0; $i < $entry['count']; $i++) {
                $internship = $internships[$cursor % $internships->count()];
                $cursor++;

                $titleTemplate = $faker->randomElement($templates);
                $title = str_replace(':internship', $internship->title, $titleTemplate);

                $dueOffset = $entry['due'][$i % count($entry['due'])];
                $dueAt = $now->copy()->addDays($dueOffset)->setTime(17, 0);

                $status = $entry['status'];
                $completedAt = $status === 'completed'
                    ? $dueAt->copy()->addHours($faker->numberBetween(1, 24))
                    : null;

                Task::create([
                    'internship_id' => $internship->id,
                    'student_profile_id' => $profile->id,
                    'assigned_by_user_id' => $assignedById,
                    'title' => $title,
                    'description' => $faker->boolean(70) ? $faker->sentence(14) : null,
                    'status' => $status,
                    'due_at' => $dueAt,
                    'completed_at' => $completedAt,
                ]);
            }
        }
    }
}

