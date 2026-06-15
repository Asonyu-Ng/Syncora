<?php

namespace App\Livewire\Company;

use App\Models\User;
use App\Services\InternshipService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;
use Livewire\Component;

class PostInternship extends Component
{
    public string $internshipTitle = '';
    public string $department = '';
    public string $location = '';
    public string $type = 'Onsite';
    public int $durationInMonths = 3;
    public string $description = '';
    public string $educationLevel = '';
    public string $otherRequirements = '';
    public array $requiredSkills = [];
    public string $skillInput = '';

    public array $typeOptions = [
        'Onsite',
        'Hybrid',
        'Remote',
    ];

    public array $educationLevelOptions = [
        'Higher National Diploma (HND)',
        'Bachelor\'s Degree',
        'Master\'s Degree',
        'Vocational Training',
        'Any Tertiary Level',
    ];

    protected function rules(): array
    {
        return [
            'internshipTitle' => ['required', 'string', 'max:255'],
            'department' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'type' => ['required', Rule::in($this->typeOptions)],
            'durationInMonths' => ['required', 'integer', 'min:1', 'max:5'],
            'description' => ['required', 'string', 'max:1000'],
            'educationLevel' => ['required', Rule::in($this->educationLevelOptions)],
            'otherRequirements' => ['nullable', 'string', 'max:500'],
            'requiredSkills' => ['required', 'array', 'min:1'],
            'requiredSkills.*' => ['string', 'max:50'],
        ];
    }

    public function addSkill(): void
    {
        $skill = trim($this->skillInput);

        if ($skill === '') {
            return;
        }

        $normalized = mb_strtolower($skill);
        $existing = collect($this->requiredSkills)
            ->map(static fn (string $value): string => mb_strtolower($value))
            ->all();

        if (! in_array($normalized, $existing, true)) {
            $this->requiredSkills[] = $skill;
        }

        $this->skillInput = '';
    }

    public function removeSkill(int $index): void
    {
        if (! isset($this->requiredSkills[$index])) {
            return;
        }

        unset($this->requiredSkills[$index]);
        $this->requiredSkills = array_values($this->requiredSkills);
    }

    public function submit()
    {
        $this->addSkill();
        $validated = $this->validate();

        /** @var User|null $user */
        $user = auth()->user();
        $companyProfile = $user?->companyProfile;

        abort_unless($companyProfile, 403);

        $internship = app(InternshipService::class)->postInternship($companyProfile, [
            'title' => $validated['internshipTitle'],
            'department' => $validated['department'],
            'location' => $validated['location'],
            'type' => $validated['type'],
            'duration_in_months' => $validated['durationInMonths'],
            'description' => $validated['description'],
            'education_level' => $validated['educationLevel'],
            'other_requirements' => $validated['otherRequirements'],
            'required_skills' => $validated['requiredSkills'],
        ]);

        session()->flash('message', '"' . $internship->title . '" was published successfully.');

        return redirect()->route('company.internships.index');
    }

    public function cancel()
    {
        return redirect()->route('company.internships.index');
    }

    public function render(): View
    {
        $dashboardHref = Route::has('company.dashboard') ? route('company.dashboard') : '/company/dashboard';
        $internshipsHref = Route::has('company.internships.index') ? route('company.internships.index') : '/company/internships';

        return view('livewire.company.post-internship', [
            'title' => 'Post New Internship',
            'breadcrumbs' => [
                ['label' => 'Dashboards', 'href' => '/__dashboards'],
                ['label' => 'Company Dashboard', 'href' => $dashboardHref],
                ['label' => 'Internships', 'href' => $internshipsHref],
                ['label' => 'Post New Internship', 'href' => null],
            ],
        ])->extends('layouts.dashboard')->section('content');
    }
}
