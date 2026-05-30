<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\Internship;
use App\Models\StudentProfile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class DemoStudentApplicationsSeeder extends Seeder
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

        $internships = Internship::query()
            ->select(['id'])
            ->orderBy('id')
            ->limit(20)
            ->get();

        if ($internships->count() < 10) {
            return;
        }

        $faker = fake();
        $now = Carbon::now();

        $plan = [
            ['status' => 'pending', 'count' => 3],
            ['status' => 'under_review', 'count' => 2],
            ['status' => 'accepted', 'count' => 2],
            ['status' => 'rejected', 'count' => 2],
            ['status' => 'withdrawn', 'count' => 1],
        ];

        $cursor = 0;

        foreach ($plan as $entry) {
            for ($i = 0; $i < $entry['count']; $i++) {
                $internshipId = $internships[$cursor]->id;
                $cursor++;

                $createdAt = $now->copy()->subDays($faker->numberBetween(1, 45));
                $status = $entry['status'];

                $decidedAt = in_array($status, ['accepted', 'rejected'], true)
                    ? $createdAt->copy()->addDays($faker->numberBetween(2, 14))
                    : null;

                Application::updateOrCreate(
                    [
                        'student_profile_id' => $profile->id,
                        'internship_id' => $internshipId,
                    ],
                    [
                        'status' => $status,
                        'cover_letter' => $faker->boolean(70) ? $faker->paragraphs(asText: true) : null,
                        'payload' => [
                            'source' => $faker->randomElement(['search', 'recommendation', 'company_page']),
                            'notes' => $faker->boolean(40) ? $faker->sentence() : null,
                        ],
                        'decided_at' => $decidedAt,
                        'created_at' => $createdAt,
                        'updated_at' => $createdAt,
                    ],
                );
            }
        }
    }
}

