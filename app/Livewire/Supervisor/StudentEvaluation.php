<?php

namespace App\Livewire\Supervisor;

use App\Services\EvaluationService;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class StudentEvaluation extends Component
{
    public array $evaluations = [];
    public string $studentName = '';
    public string $score = '';
    public string $notes = '';

    public function mount(): void
    {
        $this->evaluations = [
            [
                'student' => 'John Doe',
                'score' => '8/10',
                'date' => '2026-05-01',
                'status' => 'Submitted',
            ],
            [
                'student' => 'Jane Smith',
                'score' => 'Pending',
                'date' => '2026-05-15',
                'status' => 'Draft',
            ],
        ];
    }

    public function submit(): void
    {
        $student = trim($this->studentName);
        $score = trim($this->score);
        $notes = trim($this->notes) !== '' ? trim($this->notes) : null;

        if ($student !== '' && $score !== '') {
            $evaluation = app(EvaluationService::class)->submitEvaluation(auth()->id() ?? 0, $student, $score, $notes);

            $this->evaluations = array_merge([
                [
                    'student' => (string) ($evaluation['subject'] ?? $student),
                    'score' => (string) ($evaluation['score'] ?? $score),
                    'date' => now()->toDateString(),
                    'status' => (string) ($evaluation['status'] ?? 'Submitted'),
                ],
            ], $this->evaluations);
        }

        $this->studentName = '';
        $this->score = '';
        $this->notes = '';
    }

    public function render(): View
    {
        return view('livewire.supervisor.student-evaluation', [
            'title' => 'Student Evaluation',
        ])->extends('layouts.dashboard')->section('content');
    }
}
