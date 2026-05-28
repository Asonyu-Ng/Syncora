<?php

namespace App\Livewire\Admin;

use App\Services\ReportService;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class ReportsManagement extends Component
{
    public array $reports = [];

    public function mount(): void
    {
        $this->reports = [
            [
                'name' => 'Monthly Platform Summary',
                'type' => 'System',
                'generated' => '2026-05-01',
                'status' => 'Ready',
            ],
            [
                'name' => 'Internship Completion Breakdown',
                'type' => 'Analytics',
                'generated' => '2026-05-15',
                'status' => 'Ready',
            ],
            [
                'name' => 'Pending Verifications Export',
                'type' => 'Compliance',
                'generated' => '2026-05-26',
                'status' => 'Queued',
            ],
        ];
    }

    public function regenerate(int $index): void
    {
        if (!isset($this->reports[$index])) {
            return;
        }

        $name = (string) ($this->reports[$index]['name'] ?? '');
        $result = app(ReportService::class)->regenerateReport($name, auth()->id());

        $this->reports[$index]['status'] = (string) ($result['status'] ?? 'Queued');
    }

    public function render(): View
    {
        return view('livewire.admin.reports-management', [
            'title' => 'Reports Management',
        ])->extends('layouts.dashboard')->section('content');
    }
}
