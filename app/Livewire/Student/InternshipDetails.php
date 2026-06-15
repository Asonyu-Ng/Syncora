<?php

namespace App\Livewire\Student;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;
use Livewire\Component;

class InternshipDetails extends Component
{
    public string $internship;
    public array $details = [];

    public function mount(string $internship): void
    {
        $this->internship = $internship;

        $this->details = [
            'id' => $internship,
            'title' => 'Software Development Intern',
            'company' => 'TechCorp Inc.',
            'city' => 'Lagos',
            'type' => 'On-site',
            'duration' => '12 weeks',
            'description' => 'Explore internship details, requirements, and what you need to prepare before applying.',
            'requirements' => [
                'Basic PHP/Laravel knowledge',
                'Willingness to learn',
                'Communication skills',
            ],
        ];
    }

    public function render(): View
    {
        $dashboardHref = Route::has('student.dashboard') ? route('student.dashboard') : '/student/dashboard';
        $internshipsHref = Route::has('student.internships.search') ? route('student.internships.search') : '/student/internships';

        return view('livewire.student.internship-details', [
            'title' => 'Internship Details',
            'breadcrumbs' => [
                ['label' => 'Dashboards', 'href' => '/__dashboards'],
                ['label' => 'Student Dashboard', 'href' => $dashboardHref],
                ['label' => 'Internships', 'href' => $internshipsHref],
                ['label' => 'Internship Details', 'href' => null],
            ],
        ])->extends('layouts.dashboard')->section('content');
    }
}
