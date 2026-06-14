<?php

namespace App\Livewire\Company;

use App\Models\Internship;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class InternshipManagement extends Component
{
    public function render(): View
    {
        $companyProfileId = auth()->user()?->companyProfile?->id;

        $internships = Internship::query()
            ->withCount('applications')
            ->where('company_profile_id', $companyProfileId)
            ->latest()
            ->get()
            ->map(function (Internship $internship): array {
                return [
                    'title' => $internship->title,
                    'location' => $internship->location ?: 'Cameroon / Remote',
                    'applications' => $internship->applications_count,
                    'status' => $internship->status === 'open' ? 'Published' : ucfirst((string) $internship->status),
                ];
            })
            ->all();

        return view('livewire.company.internship-management', [
            'title' => 'Internship Management',
            'internships' => $internships,
        ])->extends('layouts.dashboard')->section('content');
    }
}
