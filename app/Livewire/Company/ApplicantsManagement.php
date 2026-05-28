<?php

namespace App\Livewire\Company;

use App\Services\InternshipService;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class ApplicantsManagement extends Component
{
    public array $applicants = [];

    public function mount(): void
    {
        $this->applicants = [
            [
                'name' => 'Alice Johnson',
                'position' => 'Software Engineering Intern',
                'university' => 'University of Lagos',
                'status' => 'Applied',
            ],
            [
                'name' => 'Michael Brown',
                'position' => 'Marketing Intern',
                'university' => 'Covenant University',
                'status' => 'Under review',
            ],
            [
                'name' => 'Grace Okafor',
                'position' => 'UI/UX Design Intern',
                'university' => 'University of Ibadan',
                'status' => 'Interview',
            ],
        ];
    }

    public function accept(int $index): void
    {
        if (!isset($this->applicants[$index])) {
            return;
        }

        $result = app(InternshipService::class)->acceptApplication($index);
        $this->applicants[$index]['status'] = (string) ($result['status'] ?? 'Accepted');

        session()->flash('message', 'Accepted ' . $this->applicants[$index]['name'] . ' (stub).');
    }

    public function reject(int $index): void
    {
        if (!isset($this->applicants[$index])) {
            return;
        }

        $result = app(InternshipService::class)->rejectApplication($index);
        $this->applicants[$index]['status'] = (string) ($result['status'] ?? 'Rejected');

        session()->flash('message', 'Rejected ' . $this->applicants[$index]['name'] . ' (stub).');
    }

    public function render(): View
    {
        return view('livewire.company.applicants-management', [
            'title' => 'Applicants Management',
        ])->extends('layouts.dashboard')->section('content');
    }
}
