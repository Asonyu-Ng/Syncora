<?php

namespace App\Livewire\Student;

use App\Models\StudentProfile;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Livewire\Attributes\Url;
use Livewire\Component;

class Profile extends Component
{
    #[Url]
    public string $tab = 'profile';

    public string $name = '';

    public string $phone = '';

    public string $address = '';

    public string $bio = '';

    public string $university = '';

    public string $department = '';

    public string $level = '';

    public function mount(): void
    {
        $user = auth()->user();

        $profile = $user?->studentProfile()->firstOrCreate();

        $this->name = (string) ($user?->name ?? '');
        $this->phone = (string) ($profile?->phone ?? '');
        $this->address = (string) ($profile?->address ?? '');
        $this->bio = (string) ($profile?->bio ?? '');
        $this->university = (string) ($profile?->university ?? '');
        $this->department = (string) ($profile?->department ?? '');
        $this->level = (string) ($profile?->level ?? '');
    }

    public function updatedTab(): void
    {
        $allowed = collect($this->tabs())->pluck('key')->all();

        if (! in_array($this->tab, $allowed, true)) {
            $this->tab = 'profile';
        }
    }

    public function openEditProfile(): void
    {
        $this->dispatch('open-modal', 'student-profile-edit');
    }

    public function saveProfile(): void
    {
        $this->validate([
            'name' => ['required', 'string', 'max:120'],
            'phone' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string', 'max:5000'],
            'university' => ['nullable', 'string', 'max:255'],
            'department' => ['nullable', 'string', 'max:255'],
            'level' => ['nullable', 'string', 'max:50'],
        ]);

        $user = auth()->user();

        $user->forceFill([
            'name' => trim($this->name),
        ])->save();

        StudentProfile::query()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'phone' => trim($this->phone) !== '' ? trim($this->phone) : null,
                'address' => trim($this->address) !== '' ? trim($this->address) : null,
                'bio' => trim($this->bio) !== '' ? trim($this->bio) : null,
                'university' => trim($this->university) !== '' ? trim($this->university) : null,
                'department' => trim($this->department) !== '' ? trim($this->department) : null,
                'level' => trim($this->level) !== '' ? trim($this->level) : null,
            ],
        );

        $this->dispatch('close-modal', 'student-profile-edit');
    }

    public function render(): View
    {
        $user = auth()->user();
        $profile = $user?->studentProfile;

        return view('livewire.student.profile', [
            'title' => 'Profile',
            'tabs' => $this->tabs(),
            'profileCard' => $this->profileCard($user, $profile),
            'aboutCard' => $this->aboutCard($profile),
            'contactCard' => $this->contactCard($user, $profile),
            'socialCard' => $this->socialCard($user),
            'academicSummary' => $this->academicSummary($profile),
            'completion' => $this->profileCompletion($user, $profile),
        ])->extends('layouts.dashboard')->section('content');
    }

    private function tabs(): array
    {
        return [
            ['key' => 'profile', 'label' => 'Profile Information'],
            ['key' => 'academic', 'label' => 'Academic Information'],
            ['key' => 'documents', 'label' => 'Documents'],
            ['key' => 'preferences', 'label' => 'Preferences'],
        ];
    }

    private function profileCard($user, ?StudentProfile $profile): array
    {
        $createdAt = $user?->created_at instanceof Carbon ? $user->created_at : null;

        return [
            'name' => $user?->name ?? 'Student',
            'email' => $user?->email,
            'phone' => $profile?->phone,
            'location' => $profile?->address,
            'matricule' => $user?->matricule,
            'member_since' => $createdAt?->format('M j, Y'),
            'status' => 'Active',
        ];
    }

    private function aboutCard(?StudentProfile $profile): array
    {
        $bio = trim((string) ($profile?->bio ?? ''));

        return [
            'title' => 'About Me',
            'body' => $bio !== '' ? $bio : 'Add a short bio to help supervisors and companies understand your goals and strengths.',
            'empty' => $bio === '',
        ];
    }

    private function contactCard($user, ?StudentProfile $profile): array
    {
        return [
            'email' => $user?->email,
            'phone' => $profile?->phone,
            'alternative_email' => null,
            'address' => $profile?->address,
        ];
    }

    private function socialCard($user): array
    {
        $name = (string) ($user?->name ?? 'student');
        $slug = Str::of($name)->lower()->replace(' ', '')->replace('-', '')->__toString();
        $slug = $slug !== '' ? $slug : 'student';

        return [
            'linkedin' => 'linkedin.com/in/' . $slug,
            'github' => 'github.com/' . $slug,
            'twitter' => 'twitter.com/' . $slug,
        ];
    }

    private function academicSummary(?StudentProfile $profile): array
    {
        $year = (int) Carbon::now()->format('Y');
        $month = (int) Carbon::now()->format('n');
        $startYear = $month >= 9 ? $year : $year - 1;

        return [
            'institution' => $profile?->university,
            'faculty' => null,
            'department' => $profile?->department,
            'level' => $profile?->level,
            'academic_year' => $startYear . '/' . ($startYear + 1),
        ];
    }

    private function profileCompletion($user, ?StudentProfile $profile): array
    {
        $items = [
            [
                'label' => 'Personal Information',
                'done' => trim((string) ($user?->name ?? '')) !== '' && trim((string) ($user?->email ?? '')) !== '',
            ],
            [
                'label' => 'Academic Information',
                'done' => trim((string) ($profile?->university ?? '')) !== '' && trim((string) ($profile?->department ?? '')) !== '' && trim((string) ($profile?->level ?? '')) !== '',
            ],
            [
                'label' => 'Contact Information',
                'done' => trim((string) ($profile?->phone ?? '')) !== '' && trim((string) ($profile?->address ?? '')) !== '',
            ],
            [
                'label' => 'Profile Picture',
                'done' => false,
            ],
            [
                'label' => 'Documents',
                'done' => false,
            ],
            [
                'label' => 'Preferences',
                'done' => false,
            ],
        ];

        $done = (int) collect($items)->where('done', true)->count();
        $total = (int) count($items);
        $raw = $total > 0 ? (int) round(($done / $total) * 100) : 0;
        $percent = (int) (round($raw / 5) * 5);
        $percent = max(0, min(100, $percent));

        return [
            'percent' => $percent,
            'items' => $items,
            'style' => 'conic-gradient(#4F46E5 0% ' . $percent . '%, #E2E8F0 ' . $percent . '% 100%)',
        ];
    }
}
