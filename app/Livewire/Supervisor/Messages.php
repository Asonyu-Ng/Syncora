<?php

namespace App\Livewire\Supervisor;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class Messages extends Component
{
    public array $threads = [];

    public function mount(): void
    {
        $this->threads = [
            [
                'student' => 'John Doe',
                'preview' => 'Question about task requirements and API integration details.',
                'time' => '1 hour ago',
                'unread' => true,
            ],
            [
                'student' => 'Jane Smith',
                'preview' => 'Request for feedback on submitted wireframes.',
                'time' => '3 hours ago',
                'unread' => false,
            ],
            [
                'student' => 'Alice Brown',
                'preview' => 'Clarification needed on cloud architecture assignment.',
                'time' => 'Yesterday',
                'unread' => true,
            ],
        ];
    }

    public function markAsRead(int $index): void
    {
        if (!isset($this->threads[$index])) {
            return;
        }

        $this->threads[$index]['unread'] = false;
    }

    public function render(): View
    {
        return view('livewire.supervisor.messages', [
            'title' => 'Messages',
        ])->extends('layouts.dashboard')->section('content');
    }
}

