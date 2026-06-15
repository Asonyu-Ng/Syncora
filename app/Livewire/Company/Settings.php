<?php

namespace App\Livewire\Company;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class Settings extends Component
{
    public bool $emailNotifications = true;
    public bool $weeklyDigest = false;

    public function save(): void
    {
        session()->flash('message', 'Company settings updated.');
    }

    public function render(): View
    {
        return view('livewire.company.settings', [
            'title' => 'Company Settings',
        ])->extends('layouts.dashboard')->section('content');
    }
}
