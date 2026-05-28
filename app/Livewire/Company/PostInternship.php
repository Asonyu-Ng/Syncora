<?php

namespace App\Livewire\Company;

use App\Services\InternshipService;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class PostInternship extends Component
{
    public string $title = '';
    public string $location = '';
    public string $duration = '';
    public string $description = '';

    public function submit(): void
    {
        $title = trim($this->title);
        $location = trim($this->location);
        $duration = trim($this->duration);
        $description = trim($this->description);

        if ($title === '' || $location === '' || $duration === '' || $description === '') {
            return;
        }

        $posted = app(InternshipService::class)->postInternship([
            'title' => $title,
            'location' => $location,
            'duration' => $duration,
            'description' => $description,
        ]);

        session()->flash('message', 'Internship post submitted (stub): ' . ($posted['title'] ?? $title));

        $this->title = '';
        $this->location = '';
        $this->duration = '';
        $this->description = '';
    }

    public function render(): View
    {
        return view('livewire.company.post-internship', [
            'title' => 'Post Internship',
        ])->extends('layouts.dashboard')->section('content');
    }
}
