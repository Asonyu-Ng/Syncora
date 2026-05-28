<?php

namespace App\Livewire\Company;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class Profile extends Component
{
    public array $company = [];

    public function mount(): void
    {
        $this->company = [
            'name' => 'TechCorp Inc.',
            'email' => 'hr@techcorp.example',
            'website' => 'https://techcorp.example',
            'location' => 'Lagos, NG',
            'profileCompletion' => 70,
        ];
    }

    public function render(): View
    {
        return view('livewire.company.profile', [
            'title' => 'Company Profile',
        ])->extends('layouts.dashboard')->section('content');
    }
}

