<?php

namespace Database\Seeders;

use App\Models\CompanyProfile;
use App\Models\Internship;
use App\Models\StudentProfile;
use App\Models\SupervisorProfile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DemoInternshipsSeeder extends Seeder
{
    public function run(): void
    {
        if (app()->environment('production')) {
            return;
        }

        $faker = fake();

        $studentUsers = User::query()->where('role', 'student')->get();

        foreach ($studentUsers as $user) {
            StudentProfile::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'university' => $faker->randomElement([
                        'University of Lagos',
                        'University of Abuja',
                        'University of Nairobi',
                        'University of Ghana',
                        'University of Cape Town',
                    ]),
                    'department' => $faker->randomElement([
                        'Computer Science',
                        'Information Systems',
                        'Software Engineering',
                        'Data Science',
                        'Business Administration',
                    ]),
                    'level' => $faker->randomElement(['100', '200', '300', '400', '500']),
                    'phone' => $faker->phoneNumber(),
                    'address' => $faker->streetAddress(),
                    'bio' => $faker->paragraphs(asText: true),
                ],
            );
        }

        $companyUser = User::query()->where('role', 'company')->first();

        if (! $companyUser) {
            $companyUser = User::create([
                'name' => 'Company User',
                'email' => 'company@syncora.test',
                'password' => Hash::make('password'),
                'role' => 'company',
                'email_verified_at' => now(),
            ]);
        }

        $supervisorUser = User::query()->where('role', 'supervisor')->first();

        if (! $supervisorUser) {
            $supervisorUser = User::create([
                'name' => 'Supervisor User',
                'email' => 'supervisor@syncora.test',
                'password' => Hash::make('password'),
                'role' => 'supervisor',
                'email_verified_at' => now(),
            ]);
        }

        $companyProfile = CompanyProfile::updateOrCreate(
            ['user_id' => $companyUser->id],
            [
                'company_name' => $faker->randomElement(['TechCorp', 'InnovateLab', 'CloudNine', 'FinEdge', 'GreenGrid']),
                'industry' => $faker->randomElement(['Software', 'FinTech', 'HealthTech', 'EdTech', 'Energy']),
                'website' => $faker->url(),
                'location' => $faker->randomElement(['Lagos, Nigeria', 'Abuja, Nigeria', 'Nairobi, Kenya', 'Accra, Ghana']),
                'description' => $faker->paragraphs(asText: true),
            ],
        );

        $supervisorProfile = SupervisorProfile::updateOrCreate(
            ['user_id' => $supervisorUser->id],
            [
                'university' => $faker->randomElement([
                    'University of Lagos',
                    'University of Abuja',
                    'University of Nairobi',
                    'University of Ghana',
                ]),
                'department' => $faker->randomElement(['Computer Science', 'Information Systems', 'Engineering']),
                'phone' => $faker->phoneNumber(),
                'office_location' => $faker->randomElement(['Main Campus', 'Tech Park', 'Innovation Hub']),
                'bio' => $faker->paragraphs(asText: true),
            ],
        );

        $tagsByCategory = [
            'Software Engineering' => ['PHP', 'Laravel', 'MySQL', 'REST APIs', 'Git', 'Testing'],
            'Data & Analytics' => ['Python', 'SQL', 'Power BI', 'Pandas', 'ETL', 'Statistics'],
            'Product' => ['User Research', 'PRDs', 'Roadmaps', 'Analytics', 'A/B Testing', 'Stakeholder Mgmt'],
            'Design' => ['Figma', 'UI Design', 'Design Systems', 'Prototyping', 'Accessibility', 'UX Research'],
            'Marketing' => ['SEO', 'Content', 'Google Analytics', 'Email', 'Social Media', 'Copywriting'],
            'Cybersecurity' => ['OWASP', 'Threat Modeling', 'SIEM', 'Linux', 'Network Security', 'Incident Response'],
            'Finance' => ['Excel', 'Forecasting', 'Accounting', 'FP&A', 'Reconciliation', 'Reporting'],
        ];

        $titlesByCategory = [
            'Software Engineering' => [
                'Backend Engineering Intern (Laravel)',
                'Full-Stack Engineering Intern',
                'QA Automation Intern',
                'Mobile Engineering Intern',
            ],
            'Data & Analytics' => [
                'Data Analyst Intern',
                'Business Intelligence Intern',
                'Data Engineering Intern',
                'Machine Learning Intern',
            ],
            'Product' => [
                'Product Management Intern',
                'Product Operations Intern',
                'Growth Product Intern',
            ],
            'Design' => [
                'UI/UX Design Intern',
                'Product Design Intern',
                'UX Research Intern',
            ],
            'Marketing' => [
                'Digital Marketing Intern',
                'Content Marketing Intern',
                'Growth Marketing Intern',
            ],
            'Cybersecurity' => [
                'Cybersecurity Analyst Intern',
                'Security Engineering Intern',
            ],
            'Finance' => [
                'Finance Analyst Intern',
                'FP&A Intern',
            ],
        ];

        $locations = [
            'Lagos, Nigeria',
            'Abuja, Nigeria',
            'Port Harcourt, Nigeria',
            'Nairobi, Kenya',
            'Accra, Ghana',
            'Kigali, Rwanda',
            'Cape Town, South Africa',
            'Remote',
        ];

        $types = ['On-site', 'Hybrid', 'Remote'];
        $durations = ['1–3 months', '3–6 months', '6–12 months'];

        $targetCount = 30;

        if (Internship::query()->count() >= $targetCount) {
            return;
        }

        for ($i = 0; $i < $targetCount; $i++) {
            $category = $faker->randomElement(array_keys($tagsByCategory));
            $title = $faker->randomElement($titlesByCategory[$category]);
            $type = $faker->randomElement($types);
            $duration = $faker->randomElement($durations);
            $location = $type === 'Remote' ? 'Remote' : $faker->randomElement(array_values(array_filter($locations, fn (string $l): bool => $l !== 'Remote')));
            $tags = collect($tagsByCategory[$category])->shuffle()->take($faker->numberBetween(3, 6))->values()->all();

            $createdAt = Carbon::now()
                ->subDays($faker->numberBetween(0, 60))
                ->subHours($faker->numberBetween(0, 23));

            $startDate = Carbon::now()->addDays($faker->numberBetween(14, 75));
            $months = match ($duration) {
                '1–3 months' => 3,
                '3–6 months' => 6,
                default => 12,
            };
            $endDate = $startDate->copy()->addMonths($months);

            $body = $faker->randomElement([
                'Join a cross-functional team and ship features that improve real user workflows.',
                'Work closely with engineers and product to deliver a polished, production-ready experience.',
                'Own a scoped project from discovery to delivery with support from a dedicated mentor.',
            ]);

            $description = implode("\n\n", [
                'Category: ' . $category,
                'Tags: ' . implode(', ', $tags),
                $body,
                'What you will do: build small-to-medium features, write tests, and collaborate in code reviews.',
                'Requirements: strong communication, curiosity, and comfort learning new tools quickly.',
            ]);

            Internship::updateOrCreate(
                [
                    'company_profile_id' => $companyProfile->id,
                    'title' => $title . ' — ' . Str::upper(Str::random(4)),
                ],
                [
                    'supervisor_profile_id' => $faker->boolean(60) ? $supervisorProfile->id : null,
                    'location' => $location,
                    'type' => $type,
                    'duration' => $duration,
                    'description' => $description,
                    'start_date' => $startDate->toDateString(),
                    'end_date' => $endDate->toDateString(),
                    'status' => $faker->boolean(85) ? 'open' : 'closed',
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ],
            );
        }
    }
}

