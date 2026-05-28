<?php

namespace App\Livewire\Admin;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class ActivityLogs extends Component
{
    public array $logs = [];

    public function mount(): void
    {
        $this->logs = [
            [
                'time' => '2026-05-28 08:05',
                'actor' => 'admin@syncora.test',
                'action' => 'Updated system settings',
                'ip' => '127.0.0.1',
            ],
            [
                'time' => '2026-05-27 16:42',
                'actor' => 'company@syncora.test',
                'action' => 'Posted internship: Software Developer Intern',
                'ip' => '127.0.0.1',
            ],
            [
                'time' => '2026-05-27 12:18',
                'actor' => 'student@syncora.test',
                'action' => 'Submitted application',
                'ip' => '127.0.0.1',
            ],
        ];
    }

    public function render(): View
    {
        return view('livewire.admin.activity-logs', [
            'title' => 'Activity Logs',
        ])->extends('layouts.dashboard')->section('content');
    }
}
