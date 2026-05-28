<?php

namespace App\Livewire\Supervisor;

use App\Services\InternshipService;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Verifications extends Component
{
    public array $requests = [];

    public function mount(): void
    {
        $this->requests = [
            [
                'student' => 'John Doe',
                'type' => 'Completion Certificate',
                'submitted_at' => '2 hours ago',
                'status' => 'Pending',
            ],
            [
                'student' => 'Jane Smith',
                'type' => 'Weekly Log',
                'submitted_at' => '5 hours ago',
                'status' => 'Pending',
            ],
            [
                'student' => 'Bob Wilson',
                'type' => 'Progress Report',
                'submitted_at' => '1 day ago',
                'status' => 'Pending',
            ],
        ];
    }

    public function approve(int $index): void
    {
        if (!isset($this->requests[$index])) {
            return;
        }

        $result = app(InternshipService::class)->approveVerification($index);
        $this->requests[$index]['status'] = (string) ($result['status'] ?? 'Approved');
    }

    public function reject(int $index): void
    {
        if (!isset($this->requests[$index])) {
            return;
        }

        $result = app(InternshipService::class)->rejectVerification($index);
        $this->requests[$index]['status'] = (string) ($result['status'] ?? 'Rejected');
    }

    public function render(): View
    {
        return view('livewire.supervisor.verifications', [
            'title' => 'Verification Requests',
        ])->extends('layouts.dashboard')->section('content');
    }
}
