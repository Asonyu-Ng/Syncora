<?php

namespace App\Livewire\Admin;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class UniversitiesManagement extends Component
{
    public array $universities = [];

    public function mount(): void
    {
        $this->universities = [
            [
                'name' => 'University of Lagos',
                'city' => 'Lagos',
                'status' => 'Active',
            ],
            [
                'name' => 'University of Ibadan',
                'city' => 'Ibadan',
                'status' => 'Active',
            ],
            [
                'name' => 'Covenant University',
                'city' => 'Ota',
                'status' => 'Inactive',
            ],
        ];
    }

    public function toggle(int $index): void
    {
        if (!isset($this->universities[$index])) {
            return;
        }

        $this->universities[$index]['status'] = $this->universities[$index]['status'] === 'Active'
            ? 'Inactive'
            : 'Active';
    }

    public function render(): View
    {
        return view('livewire.admin.universities-management', [
            'title' => 'Universities Management',
        ])->extends('layouts.dashboard')->section('content');
    }
}
