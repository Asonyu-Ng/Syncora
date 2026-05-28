<?php

namespace App\Livewire\Student;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class Settings extends Component
{
    public bool $emailNotifications = true;
    public bool $weeklySummary = true;

    public function save(): void
    {
    }

    public function render(): View
    {
        return view('livewire.student.settings', [
            'title' => 'Settings',
        ])->extends('layouts.dashboard')->section('content');
    }
}

