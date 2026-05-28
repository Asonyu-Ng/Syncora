<?php

namespace App\Livewire\Student;

use App\Services\LogbookService;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class LogbookSubmission extends Component
{
    public string $date = '';
    public string $hours = '';
    public string $notes = '';

    public array $entries = [];

    public function mount(): void
    {
        $this->entries = [
            [
                'date' => '2026-05-25',
                'hours' => 6,
                'notes' => 'Worked on dashboard scaffolding.',
            ],
            [
                'date' => '2026-05-26',
                'hours' => 7,
                'notes' => 'Reviewed tasks and updated UI stubs.',
            ],
        ];
    }

    public function submit(): void
    {
        $date = trim($this->date);
        $hours = (int) $this->hours;
        $notes = trim($this->notes);

        if ($date === '' || $hours <= 0 || $notes === '') {
            return;
        }

        $entry = app(LogbookService::class)->submitEntry(auth()->id() ?? 0, $date, $hours, $notes);

        array_unshift($this->entries, [
            'date' => (string) ($entry['date'] ?? $date),
            'hours' => (int) ($entry['hours'] ?? $hours),
            'notes' => (string) ($entry['notes'] ?? $notes),
        ]);

        $this->date = '';
        $this->hours = '';
        $this->notes = '';
    }

    public function render(): View
    {
        return view('livewire.student.logbook-submission', [
            'title' => 'Logbook Submission',
        ])->extends('layouts.dashboard')->section('content');
    }
}
