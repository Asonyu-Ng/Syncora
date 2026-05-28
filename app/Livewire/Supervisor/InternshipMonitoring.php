<?php

namespace App\Livewire\Supervisor;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class InternshipMonitoring extends Component
{
    public array $internships = [];

    public function mount(): void
    {
        $this->internships = [
            [
                'student' => 'John Doe',
                'company' => 'Tech Corp',
                'position' => 'Software Developer',
                'progress' => '75%',
                'status' => 'On track',
            ],
            [
                'student' => 'Jane Smith',
                'company' => 'Innovation Labs',
                'position' => 'UX Designer',
                'progress' => '60%',
                'status' => 'On track',
            ],
            [
                'student' => 'Bob Wilson',
                'company' => 'Data Systems Inc',
                'position' => 'Data Analyst',
                'progress' => '45%',
                'status' => 'Needs attention',
            ],
        ];
    }

    public function render(): View
    {
        return view('livewire.supervisor.internship-monitoring', [
            'title' => 'Internship Monitoring',
        ])->extends('layouts.dashboard')->section('content');
    }
}
