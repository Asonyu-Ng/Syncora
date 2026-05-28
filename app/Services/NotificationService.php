<?php

namespace App\Services;

use Illuminate\Support\Str;

class NotificationService
{
    public function sendAnnouncement(string $audience, string $subject, string $message, ?int $senderId = null): array
    {
        return [
            'id' => Str::uuid()->toString(),
            'audience' => $audience,
            'subject' => $subject,
            'message' => $message,
            'senderId' => $senderId,
            'time' => now()->format('Y-m-d H:i'),
        ];
    }

    public function markAsRead(int $userId, int|string $notificationId): bool
    {
        return true;
    }

    public function listForUser(int $userId): array
    {
        return [
            [
                'id' => 'nt-001',
                'subject' => 'Maintenance window scheduled',
                'read' => false,
                'time' => '2026-05-20 09:00',
            ],
        ];
    }
}

