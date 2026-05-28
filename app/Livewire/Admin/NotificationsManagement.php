<?php

namespace App\Livewire\Admin;

use App\Services\NotificationService;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class NotificationsManagement extends Component
{
    public string $audience = 'all';
    public string $subject = '';
    public string $message = '';

    public array $sent = [];

    public function mount(): void
    {
        $this->sent = [
            [
                'subject' => 'Maintenance window scheduled',
                'audience' => 'all',
                'time' => '2026-05-20 09:00',
            ],
            [
                'subject' => 'New internship season kickoff',
                'audience' => 'students',
                'time' => '2026-05-10 12:30',
            ],
        ];
    }

    public function send(): void
    {
        if (trim($this->subject) === '' || trim($this->message) === '') {
            return;
        }

        $sent = app(NotificationService::class)->sendAnnouncement(
            $this->audience,
            $this->subject,
            $this->message,
            auth()->id()
        );

        array_unshift($this->sent, [
            'subject' => (string) ($sent['subject'] ?? $this->subject),
            'audience' => (string) ($sent['audience'] ?? $this->audience),
            'time' => (string) ($sent['time'] ?? now()->format('Y-m-d H:i')),
        ]);

        $this->subject = '';
        $this->message = '';
    }

    public function render(): View
    {
        return view('livewire.admin.notifications-management', [
            'title' => 'Notifications Management',
        ])->extends('layouts.dashboard')->section('content');
    }
}
