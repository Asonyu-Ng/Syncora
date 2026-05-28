<?php

namespace App\Livewire\Student;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class Applications extends Component
{
    public array $applications = [];

    public function mount(): void
    {
        $this->applications = [
            [
                'company' => 'TechCorp Inc.',
                'position' => 'Software Development Intern',
                'status' => 'Accepted',
                'applied_on' => '2026-01-15',
            ],
            [
                'company' => 'InnovateLab',
                'position' => 'UX Design Intern',
                'status' => 'Under Review',
                'applied_on' => '2026-02-01',
            ],
            [
                'company' => 'BigTech Co',
                'position' => 'Data Analyst Intern',
                'status' => 'Rejected',
                'applied_on' => '2026-01-20',
            ],
        ];
    }

    public function render(): View
    {
        return view('livewire.student.applications', [
            'title' => 'Applications',
        ])->extends('layouts.dashboard')->section('content');
    }
}

