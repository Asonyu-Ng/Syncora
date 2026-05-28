<?php

namespace App\Livewire\Admin;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class CompaniesManagement extends Component
{
    public array $companies = [];

    public function mount(): void
    {
        $this->companies = [
            [
                'name' => 'TechCorp Inc.',
                'industry' => 'Software',
                'status' => 'Verified',
            ],
            [
                'name' => 'Innovation Labs',
                'industry' => 'Design',
                'status' => 'Pending',
            ],
            [
                'name' => 'Data Systems Inc.',
                'industry' => 'Analytics',
                'status' => 'Verified',
            ],
        ];
    }

    public function verify(int $index): void
    {
        if (!isset($this->companies[$index])) {
            return;
        }

        $this->companies[$index]['status'] = 'Verified';
    }

    public function render(): View
    {
        return view('livewire.admin.companies-management', [
            'title' => 'Companies Management',
        ])->extends('layouts.dashboard')->section('content');
    }
}
