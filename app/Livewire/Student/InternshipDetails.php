<?php

namespace App\Livewire\Student;

use Illuminate\Contracts\View\View;
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
            'description' => 'Read-only internship details stub. Real data will come from the internship domain model.',
            'requirements' => [
                'Basic PHP/Laravel knowledge',
                'Willingness to learn',
                'Communication skills',
            ],
        ];
    }

    public function render(): View
    {
        return view('livewire.student.internship-details', [
            'title' => 'Internship Details',
        ])->extends('layouts.dashboard')->section('content');
    }
}

