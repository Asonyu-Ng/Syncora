<?php

namespace App\Livewire\Supervisor;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class Settings extends Component
{
    public bool $emailNotifications = true;
    public bool $weeklySummary = true;

    public function save(): void
    {
        session()->flash('message', 'Supervisor preferences updated.');
    }

    public function render(): View
    {
        return view('livewire.supervisor.settings', [
            'title' => 'Settings',
        ])->extends('layouts.dashboard')->section('content');
    }
}
