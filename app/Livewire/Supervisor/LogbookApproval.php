<?php

namespace App\Livewire\Supervisor;

use App\Services\LogbookService;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class LogbookApproval extends Component
{
    public array $logbooks = [];

    public function mount(): void
    {
        $this->logbooks = [
            ['student' => 'John Doe', 'week' => 'Week 5', 'hours' => 38, 'status' => 'Pending'],
            ['student' => 'Jane Smith', 'week' => 'Week 5', 'hours' => 40, 'status' => 'Pending'],
            ['student' => 'Bob Wilson', 'week' => 'Week 4', 'hours' => 28, 'status' => 'Pending'],
        ];
    }

    public function approve(int $index): void
    {
        if (!isset($this->logbooks[$index])) {
            return;
        }

        $result = app(LogbookService::class)->approveEntry($index, auth()->id() ?? 0);
        $this->logbooks[$index]['status'] = (string) ($result['status'] ?? 'Approved');
    }

    public function reject(int $index): void
    {
        if (!isset($this->logbooks[$index])) {
            return;
        }

        $result = app(LogbookService::class)->rejectEntry($index, auth()->id() ?? 0);
        $this->logbooks[$index]['status'] = (string) ($result['status'] ?? 'Rejected');
    }

    public function render(): View
    {
        return view('livewire.supervisor.logbook-approval', [
            'title' => 'Logbook Approval',
        ])->extends('layouts.dashboard')->section('content');
    }
}
