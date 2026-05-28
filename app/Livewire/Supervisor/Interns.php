<?php

namespace App\Livewire\Supervisor;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class Interns extends Component
{
    public array $interns = [];

    public function mount(): void
    {
        $this->interns = [
            [
                'name' => 'John Doe',
                'company' => 'Tech Corp',
                'position' => 'Software Developer',
                'status' => 'Active',
                'progress' => 75,
            ],
            [
                'name' => 'Jane Smith',
                'company' => 'Innovation Labs',
                'position' => 'UX Designer',
                'status' => 'Active',
                'progress' => 60,
            ],
            [
                'name' => 'Bob Wilson',
                'company' => 'Data Systems Inc',
                'position' => 'Data Analyst',
                'status' => 'Needs Attention',
                'progress' => 45,
            ],
        ];
    }

    public function render(): View
    {
        return view('livewire.supervisor.interns', [
            'title' => 'Supervised Interns',
        ])->extends('layouts.dashboard')->section('content');
    }
}

