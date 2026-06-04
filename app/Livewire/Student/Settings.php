<?php

namespace App\Livewire\Student;

use App\Models\StudentProfile;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Schema;
use Livewire\Attributes\Url;
use Livewire\Component;

class Settings extends Component
{
    #[Url]
    public string $tab = 'general';

    public bool $notifyApplicationUpdates = true;

    public bool $notifyTaskReminders = true;

    public bool $notifyLogbookUpdates = true;

    public bool $notifyAnnouncements = false;

    public string $privacyProfileVisibility = 'university_supervisors';

    public string $language = 'English';

    public string $timezone = 'UTC+1';

    public string $theme = 'system';

    public function mount(): void
    {
        $profile = $this->ensureStudentProfile();

        if (! $this->hasSettingsColumn()) {
            return;
        }

        $settings = (array) ($profile->settings ?? []);

        $this->notifyApplicationUpdates = (bool) ($settings['notifications']['application_updates'] ?? $this->notifyApplicationUpdates);
        $this->notifyTaskReminders = (bool) ($settings['notifications']['task_reminders'] ?? $this->notifyTaskReminders);
        $this->notifyLogbookUpdates = (bool) ($settings['notifications']['logbook_updates'] ?? $this->notifyLogbookUpdates);
        $this->notifyAnnouncements = (bool) ($settings['notifications']['announcements'] ?? $this->notifyAnnouncements);

        $this->privacyProfileVisibility = (string) ($settings['privacy']['profile_visibility'] ?? $this->privacyProfileVisibility);
        $this->language = (string) ($settings['region']['language'] ?? $this->language);
        $this->timezone = (string) ($settings['region']['timezone'] ?? $this->timezone);
        $this->theme = (string) ($settings['appearance']['theme'] ?? $this->theme);
    }

    public function updatedTab(): void
    {
        if (! in_array($this->tab, ['general', 'notifications', 'privacy', 'security', 'appearance'], true)) {
            $this->tab = 'general';
        }
    }

    public function updated($property): void
    {
        if (! in_array($property, [
            'notifyApplicationUpdates',
            'notifyTaskReminders',
            'notifyLogbookUpdates',
            'notifyAnnouncements',
            'privacyProfileVisibility',
            'language',
            'timezone',
            'theme',
        ], true)) {
            return;
        }

        $this->persist();
    }

    public function manageNotifications(): void
    {
        session()->flash('message', 'Notification settings saved.');
    }

    public function openSecurityAction(string $key): void
    {
        session()->flash('message', match ($key) {
            'two_factor' => 'Two-factor authentication is coming soon.',
            'sessions' => 'Active sessions view is coming soon.',
            default => 'Coming soon.',
        });
    }

    public function quickAction(string $key): void
    {
        session()->flash('message', match ($key) {
            'download_data' => 'Download is coming soon.',
            'deactivated' => 'Deactivated accounts view is coming soon.',
            'devices' => 'Connected devices view is coming soon.',
            'delete_account' => 'Delete account flow is coming soon.',
            default => 'Coming soon.',
        });
    }

    public function render(): View
    {
        $user = auth()->user();
        $profile = $this->ensureStudentProfile();

        return view('livewire.student.settings', [
            'title' => 'Settings',
            'tabs' => $this->tabs(),
            'profileCard' => [
                'name' => $user?->name,
                'email' => $user?->email,
                'phone' => $profile?->phone,
                'location' => $profile?->address,
            ],
            'privacyVisibilityOptions' => $this->privacyVisibilityOptions(),
            'languageOptions' => $this->languageOptions(),
            'timezoneOptions' => $this->timezoneOptions(),
            'themeOptions' => $this->themeOptions(),
        ])->extends('layouts.dashboard')->section('content');
    }

    private function ensureStudentProfile(): StudentProfile
    {
        $user = auth()->user();

        return $user->studentProfile()->firstOrCreate();
    }

    private function persist(): void
    {
        if (! $this->hasSettingsColumn()) {
            session()->flash('message', 'Settings storage is not available yet. Run `php artisan migrate` to enable it.');
            return;
        }

        $profile = $this->ensureStudentProfile();

        $profile->settings = [
            'notifications' => [
                'application_updates' => $this->notifyApplicationUpdates,
                'task_reminders' => $this->notifyTaskReminders,
                'logbook_updates' => $this->notifyLogbookUpdates,
                'announcements' => $this->notifyAnnouncements,
            ],
            'privacy' => [
                'profile_visibility' => $this->privacyProfileVisibility,
            ],
            'region' => [
                'language' => $this->language,
                'timezone' => $this->timezone,
            ],
            'appearance' => [
                'theme' => $this->theme,
            ],
        ];

        $profile->save();
    }

    private function hasSettingsColumn(): bool
    {
        return Schema::hasColumn('student_profiles', 'settings');
    }

    private function tabs(): array
    {
        return [
            ['key' => 'general', 'label' => 'General'],
            ['key' => 'notifications', 'label' => 'Notifications'],
            ['key' => 'privacy', 'label' => 'Privacy'],
            ['key' => 'security', 'label' => 'Security'],
            ['key' => 'appearance', 'label' => 'Appearance'],
        ];
    }

    private function privacyVisibilityOptions(): array
    {
        return [
            'university_supervisors' => 'Only University & Supervisors',
            'university_only' => 'Only University',
            'supervisors_only' => 'Only Supervisors',
            'private' => 'Private',
        ];
    }

    private function languageOptions(): array
    {
        return [
            'English' => 'English',
            'French' => 'French',
        ];
    }

    private function timezoneOptions(): array
    {
        return [
            'UTC' => 'UTC',
            'UTC+1' => 'UTC(+1) West Africa Time',
            'UTC-6' => 'UTC(-6) Central Time',
        ];
    }

    private function themeOptions(): array
    {
        return [
            'system' => 'System',
            'light' => 'Light',
            'dark' => 'Dark',
        ];
    }
}
