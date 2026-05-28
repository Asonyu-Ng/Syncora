<?php

namespace App\Livewire\Admin;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class UsersManagement extends Component
{
    public array $users = [];

    public function mount(): void
    {
        $this->users = [
            [
                'name' => 'Admin User',
                'email' => 'admin@syncora.test',
                'role' => 'admin',
                'status' => 'Active',
            ],
            [
                'name' => 'Student User',
                'email' => 'student@syncora.test',
                'role' => 'student',
                'status' => 'Active',
            ],
            [
                'name' => 'Company User',
                'email' => 'company@syncora.test',
                'role' => 'company',
                'status' => 'Suspended',
            ],
        ];
    }

    public function suspend(int $index): void
    {
        if (!isset($this->users[$index])) {
            return;
        }

        $this->users[$index]['status'] = 'Suspended';
    }

    public function activate(int $index): void
    {
        if (!isset($this->users[$index])) {
            return;
        }

        $this->users[$index]['status'] = 'Active';
    }

    public function render(): View
    {
        return view('livewire.admin.users-management', [
            'title' => 'Users Management',
        ])->extends('layouts.dashboard')->section('content');
    }
}
