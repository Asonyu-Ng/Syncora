<?php

namespace App\Livewire\Company;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class ActiveInterns extends Component
{
    public array $interns = [];

    public function mount(): void
    {
        $this->interns = [
            [
                'name' => 'John Doe',
                'role' => 'Software Engineering Intern',
                'startDate' => '2026-02-01',
                'progress' => 72,
            ],
            [
                'name' => 'Jane Smith',
                'role' => 'UX Design Intern',
                'startDate' => '2026-01-15',
                'progress' => 55,
            ],
            [
                'name' => 'Bob Wilson',
                'role' => 'Data Analyst Intern',
                'startDate' => '2026-03-10',
                'progress' => 41,
            ],
        ];
    }

    public function render(): View
    {
        return view('livewire.company.active-interns', [
            'title' => 'Active Interns',
        ])->extends('layouts.dashboard')->section('content');
    }
}

