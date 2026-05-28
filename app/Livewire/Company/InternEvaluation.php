<?php

namespace App\Livewire\Company;

use App\Services\EvaluationService;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class InternEvaluation extends Component
{
    public array $evaluations = [];
    public string $internName = '';
    public string $score = '';
    public string $notes = '';

    public function mount(): void
    {
        $this->evaluations = [
            [
                'intern' => 'John Doe',
                'score' => '8/10',
                'date' => '2026-05-01',
                'status' => 'Submitted',
            ],
            [
                'intern' => 'Jane Smith',
                'score' => 'Pending',
                'date' => '2026-05-15',
                'status' => 'Draft',
            ],
        ];
    }

    public function submit(): void
    {
        $intern = trim($this->internName);
        $score = trim($this->score);
        $notes = trim($this->notes) !== '' ? trim($this->notes) : null;

        if ($intern === '' || $score === '') {
            return;
        }

        $evaluation = app(EvaluationService::class)->submitEvaluation(auth()->id() ?? 0, $intern, $score, $notes);

        array_unshift($this->evaluations, [
            'intern' => (string) ($evaluation['subject'] ?? $intern),
            'score' => (string) ($evaluation['score'] ?? $score),
            'date' => now()->toDateString(),
            'status' => (string) ($evaluation['status'] ?? 'Submitted'),
        ]);

        session()->flash('message', 'Evaluation submitted (stub).');
        $this->internName = '';
        $this->score = '';
        $this->notes = '';
    }

    public function render(): View
    {
        return view('livewire.company.intern-evaluation', [
            'title' => 'Intern Evaluation',
        ])->extends('layouts.dashboard')->section('content');
    }
}
