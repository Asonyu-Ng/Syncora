<?php

namespace App\Livewire\Supervisor;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Profile extends Component
{
    public array $user = [];

    public function mount(): void
    {
        $user = Auth::user();

        $this->user = [
            'name' => $user?->name ?? 'Supervisor',
            'email' => $user?->email ?? 'supervisor@example.com',
            'role' => $user?->role ?? 'supervisor',
        ];
    }

    public function render(): View
    {
        return view('livewire.supervisor.profile', [
            'title' => 'Profile',
        ])->extends('layouts.dashboard')->section('content');
    }
}
