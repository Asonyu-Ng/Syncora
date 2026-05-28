<?php

namespace App\Livewire\Supervisor;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class Calendar extends Component
{
    public array $events = [];

    public function mount(): void
    {
        $this->events = [
            ['title' => 'Student check-in: John Doe', 'date' => '2026-06-03'],
            ['title' => 'Evaluation deadline', 'date' => '2026-06-07'],
            ['title' => 'Supervisor meeting', 'date' => '2026-06-10'],
        ];
    }

    public function render(): View
    {
        return view('livewire.supervisor.calendar', [
            'title' => 'Calendar',
        ])->extends('layouts.dashboard')->section('content');
    }
}
