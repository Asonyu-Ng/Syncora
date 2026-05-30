<?php

namespace Tests\Feature;

use App\Models\CompanyProfile;
use App\Models\Internship;
use App\Models\User;
use App\Services\InternshipService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InternshipServiceSearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_returns_a_paginator_with_computed_fields(): void
    {
        $companyUser = User::factory()->create(['role' => 'company']);

        $companyProfile = CompanyProfile::create([
            'user_id' => $companyUser->id,
            'company_name' => 'TechCorp',
            'industry' => 'Software',
            'website' => 'https://example.test',
            'location' => 'Lagos, Nigeria',
            'description' => 'Company description',
        ]);

        $internship = Internship::create([
            'company_profile_id' => $companyProfile->id,
            'title' => 'Backend Engineering Intern',
            'location' => 'Lagos, Nigeria',
            'type' => 'On-site',
            'duration' => '3–6 months',
            'description' => "Category: Software Engineering\n\nTags: PHP, Laravel, MySQL\n\nBuild features.",
            'status' => 'open',
        ]);
        $internship->forceFill([
            'created_at' => now()->subDay(),
            'updated_at' => now()->subDay(),
        ])->save();

        $paginator = app(InternshipService::class)->searchInternships([
            'keywords' => 'Laravel',
        ]);

        $this->assertInstanceOf(LengthAwarePaginator::class, $paginator);

        $items = $paginator->items();
        $this->assertCount(1, $items);
        $this->assertSame('TechCorp', $items[0]['company_name']);
        $this->assertSame('Software Engineering', $items[0]['category']);
        $this->assertSame(['PHP', 'Laravel', 'MySQL'], $items[0]['tags']);
    }

    public function test_it_filters_by_posted_within_and_sorts_newest_first_by_default(): void
    {
        $companyUser = User::factory()->create(['role' => 'company']);

        $companyProfile = CompanyProfile::create([
            'user_id' => $companyUser->id,
            'company_name' => 'InnovateLab',
            'industry' => 'Software',
            'website' => 'https://example.test',
            'location' => 'Abuja, Nigeria',
            'description' => 'Company description',
        ]);

        $old = Internship::create([
            'company_profile_id' => $companyProfile->id,
            'title' => 'Old Internship',
            'location' => 'Abuja, Nigeria',
            'type' => 'Hybrid',
            'duration' => '1–3 months',
            'description' => "Category: Design\n\nTags: Figma, UX\n\nDesign stuff.",
            'status' => 'open',
        ]);
        $old->forceFill([
            'created_at' => now()->subDays(20),
            'updated_at' => now()->subDays(20),
        ])->save();

        $new = Internship::create([
            'company_profile_id' => $companyProfile->id,
            'title' => 'New Internship',
            'location' => 'Remote',
            'type' => 'Remote',
            'duration' => '6–12 months',
            'description' => "Category: Data & Analytics\n\nTags: SQL, Python\n\nAnalyze data.",
            'status' => 'open',
        ]);
        $new->forceFill([
            'created_at' => now()->subDays(2),
            'updated_at' => now()->subDays(2),
        ])->save();

        $paginator = app(InternshipService::class)->searchInternships([
            'postedWithin' => '7d',
        ]);

        $items = $paginator->items();
        $this->assertCount(1, $items);
        $this->assertSame($new->id, $items[0]['id']);

        $all = app(InternshipService::class)->searchInternships();
        $allItems = $all->items();
        $this->assertSame($new->id, $allItems[0]['id']);
        $this->assertSame($old->id, $allItems[1]['id']);
    }
}
