<?php

namespace App\Livewire\Student;

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
            'name' => $user?->name ?? 'Student',
            'email' => $user?->email ?? 'student@example.com',
            'role' => $user?->role ?? 'student',
        ];
    }

    public function render(): View
    {
        return view('livewire.student.profile', [
            'title' => 'Profile',
        ])->extends('layouts.dashboard')->section('content');
    }
}

