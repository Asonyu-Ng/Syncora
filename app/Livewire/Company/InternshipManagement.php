<?php

namespace App\Livewire\Company;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class InternshipManagement extends Component
{
    public array $internships = [];

    public function mount(): void
    {
        $this->internships = [
            [
                'title' => 'Software Engineering Intern',
                'location' => 'Lagos, NG',
                'applications' => 24,
                'status' => 'Active',
            ],
            [
                'title' => 'UI/UX Design Intern',
                'location' => 'Remote',
                'applications' => 11,
                'status' => 'Active',
            ],
            [
                'title' => 'Data Analyst Intern',
                'location' => 'Abuja, NG',
                'applications' => 7,
                'status' => 'Draft',
            ],
        ];
    }

    public function render(): View
    {
        return view('livewire.company.internship-management', [
            'title' => 'Internship Management',
        ])->extends('layouts.dashboard')->section('content');
    }
}

