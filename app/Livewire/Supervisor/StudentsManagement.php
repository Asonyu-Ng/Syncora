<?php

namespace App\Livewire\Supervisor;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class StudentsManagement extends Component
{
    public array $students = [];

    public function mount(): void
    {
        $this->students = [
            [
                'name' => 'John Doe',
                'matricule' => 'STU-001',
                'company' => 'Tech Corp',
                'status' => 'Active',
            ],
            [
                'name' => 'Jane Smith',
                'matricule' => 'STU-002',
                'company' => 'Innovation Labs',
                'status' => 'Active',
            ],
            [
                'name' => 'Bob Wilson',
                'matricule' => 'STU-003',
                'company' => 'Data Systems Inc',
                'status' => 'Needs Attention',
            ],
        ];
    }

    public function render(): View
    {
        return view('livewire.supervisor.students-management', [
            'title' => 'Students Management',
        ])->extends('layouts.dashboard')->section('content');
    }
}
