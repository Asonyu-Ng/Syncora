<?php

namespace App\Livewire\Admin;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class InternshipsMonitoring extends Component
{
    public array $internships = [];

    public function mount(): void
    {
        $this->internships = [
            [
                'title' => 'Software Developer Intern',
                'company' => 'TechCorp Inc.',
                'location' => 'Lagos',
                'status' => 'Open',
                'applications' => 45,
            ],
            [
                'title' => 'UI/UX Design Intern',
                'company' => 'Innovation Labs',
                'location' => 'Remote',
                'status' => 'Open',
                'applications' => 32,
            ],
            [
                'title' => 'Data Analyst Intern',
                'company' => 'Data Systems Inc.',
                'location' => 'Abuja',
                'status' => 'Closed',
                'applications' => 18,
            ],
        ];
    }

    public function render(): View
    {
        return view('livewire.admin.internships-monitoring', [
            'title' => 'Internships Monitoring',
        ])->extends('layouts.dashboard')->section('content');
    }
}
