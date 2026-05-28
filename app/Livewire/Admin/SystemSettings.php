<?php

namespace App\Livewire\Admin;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class SystemSettings extends Component
{
    public array $settings = [];

    public function mount(): void
    {
        $this->settings = [
            [
                'key' => 'registration_enabled',
                'label' => 'Enable registrations',
                'value' => true,
            ],
            [
                'key' => 'maintenance_mode',
                'label' => 'Maintenance mode',
                'value' => false,
            ],
            [
                'key' => 'require_email_verification',
                'label' => 'Require email verification',
                'value' => true,
            ],
        ];
    }

    public function toggle(string $key): void
    {
        foreach ($this->settings as $index => $setting) {
            if (($setting['key'] ?? null) !== $key) {
                continue;
            }

            $this->settings[$index]['value'] = !(bool) ($this->settings[$index]['value'] ?? false);
            break;
        }
    }

    public function render(): View
    {
        return view('livewire.admin.system-settings', [
            'title' => 'System Settings',
        ])->extends('layouts.dashboard')->section('content');
    }
}
