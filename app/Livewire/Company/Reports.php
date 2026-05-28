<?php

namespace App\Livewire\Company;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class Reports extends Component
{
    public array $reports = [];

    public function mount(): void
    {
        $this->reports = [
            [
                'title' => 'Weekly Progress Summary',
                'intern' => 'John Doe',
                'createdAt' => '2026-05-20',
                'status' => 'Available',
            ],
            [
                'title' => 'Supervisor Feedback',
                'intern' => 'Jane Smith',
                'createdAt' => '2026-05-18',
                'status' => 'Available',
            ],
        ];
    }

    public function render(): View
    {
        return view('livewire.company.reports', [
            'title' => 'Reports',
        ])->extends('layouts.dashboard')->section('content');
    }
}

