<?php

namespace App\Livewire\Supervisor;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class ReportsReview extends Component
{
    public array $reports = [];

    public function mount(): void
    {
        $this->reports = [
            ['student' => 'John Doe', 'title' => 'Weekly Summary', 'submitted' => '2026-05-20', 'status' => 'Pending'],
            ['student' => 'Jane Smith', 'title' => 'Monthly Progress Report', 'submitted' => '2026-05-18', 'status' => 'Reviewed'],
            ['student' => 'Bob Wilson', 'title' => 'Final Report Draft', 'submitted' => '2026-05-10', 'status' => 'Pending'],
        ];
    }

    public function render(): View
    {
        return view('livewire.supervisor.reports-review', [
            'title' => 'Reports Review',
        ])->extends('layouts.dashboard')->section('content');
    }
}
