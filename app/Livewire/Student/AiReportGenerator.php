<?php

namespace App\Livewire\Student;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class AiReportGenerator extends Component
{
    public string $prompt = '';
    public string $status = '';
    public string $generated = '';

    public function generate(): void
    {
        $prompt = trim($this->prompt);

        if ($prompt === '') {
            $this->status = 'Enter a prompt to generate a report.';
            return;
        }

        $this->status = 'Generating...';

        $result = null;

        if (class_exists(\App\Services\ReportService::class)) {
            $service = app(\App\Services\ReportService::class);

            if (method_exists($service, 'generateStudentReport')) {
                $result = $service->generateStudentReport($prompt);
            }
        }

        $this->generated = is_string($result) && $result !== ''
            ? $result
            : "Generated report stub for: {$prompt}\n\nThis is a placeholder output. Service integration will provide real content.";

        $this->status = 'Done';
    }

    public function render(): View
    {
        return view('livewire.student.ai-report-generator', [
            'title' => 'AI Report Generator',
        ])->extends('layouts.dashboard')->section('content');
    }
}

