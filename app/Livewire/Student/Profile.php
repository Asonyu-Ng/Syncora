<?php

namespace App\Livewire\Student;

use App\Models\StudentProfile;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Livewire\Attributes\Url;
use Livewire\Component;

class Profile extends Component
{
    #[Url]
    public string $tab = 'profile';

    public string $name = '';

    public string $email = '';

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
        $this->email = (string) ($user?->email ?? '');
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

    public function openEditAcademicInfo(): void
    {
        $this->dispatch('open-modal', 'student-profile-edit');
    }

    public function saveProfile(): void
    {
        $this->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . auth()->id()],
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
            'email' => trim($this->email),
        ]);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

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

        $academic = $this->academicDetails($user, $profile);
        $dashboardHref = Route::has('student.dashboard') ? route('student.dashboard') : '/student/dashboard';
        $profileHref = Route::has('student.profile') ? route('student.profile') : '/student/profile';
        $tabLabel = collect($this->tabs())->firstWhere('key', $this->tab)['label'] ?? null;
        $breadcrumbs = [
            ['label' => 'Dashboards', 'href' => '/__dashboards'],
            ['label' => 'Student Dashboard', 'href' => $dashboardHref],
            ['label' => 'My Profile', 'href' => $this->tab === 'profile' ? null : $profileHref],
        ];

        if ($this->tab !== 'profile' && $tabLabel) {
            $breadcrumbs[] = ['label' => $tabLabel, 'href' => null];
        }

        return view('livewire.student.profile', [
            'title' => 'My Profile',
            'breadcrumbs' => $breadcrumbs,
            'tabs' => $this->tabs(),
            'profileCard' => $this->profileCard($user, $profile),
            'aboutCard' => $this->aboutCard($profile),
            'contactCard' => $this->contactCard($user, $profile),
            'socialCard' => $this->socialCard($user),
            'academicSummary' => $this->academicSummary($profile),
            'academicDetails' => $academic,
            'academicSidebar' => $this->academicSidebar($academic),
            'academicAchievements' => $this->academicAchievements(),
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

    private function academicDetails($user, ?StudentProfile $profile): array
    {
        $year = (int) Carbon::now()->format('Y');
        $month = (int) Carbon::now()->format('n');
        $startYear = $month >= 9 ? $year : $year - 1;

        $levelRaw = trim((string) ($profile?->level ?? ''));
        $digits = (int) preg_replace('/\D+/', '', $levelRaw);
        $academicLevel = $digits >= 100 ? (int) floor($digits / 100) : null;
        $academicLevel = $academicLevel !== null && $academicLevel > 0 ? $academicLevel : null;

        $entryYear = $academicLevel !== null ? (string) ($startYear - ($academicLevel - 1)) . '/' . (string) ($startYear - ($academicLevel - 1) + 1) : null;
        $expectedGrad = $academicLevel !== null ? (string) ($startYear + (4 - $academicLevel)) : null;

        $department = $profile?->department;
        $faculty = null;

        if ($department) {
            $faculty = str_contains(Str::lower($department), 'science') ? 'Faculty of Science' : 'Faculty of Science';
        }

        return [
            'institution' => $profile?->university,
            'faculty' => $faculty,
            'department' => $department,
            'program' => $department ? 'Bachelor of Science in ' . $department : null,
            'level' => $profile?->level,
            'matricule' => $user?->matricule,
            'academic_year' => $startYear . '/' . ($startYear + 1),
            'entry_year' => $entryYear,
            'cgpa' => '3.68 / 4.00',
            'cgpa_badge' => 'Good',
            'expected_graduation' => $expectedGrad,
        ];
    }

    private function academicSidebar(array $academicDetails): array
    {
        $creditsEarned = 76;
        $coursesCompleted = 18;
        $creditsRequired = 180;
        $creditsCompleted = 129;
        $progress = $creditsRequired > 0 ? (int) round(($creditsCompleted / $creditsRequired) * 100) : 0;

        return [
            'total_credit_units_earned' => $creditsEarned,
            'cgpa' => $academicDetails['cgpa'] ?? null,
            'academic_standing' => 'Good',
            'class' => 'Second Class Upper',
            'total_courses_completed' => $coursesCompleted,
            'progress_percent' => $progress,
            'progress_label' => $creditsCompleted . ' of ' . $creditsRequired . ' Credit Units Completed',
            'progress_style' => 'width: ' . max(0, min(100, $progress)) . '%',
        ];
    }

    private function academicAchievements(): array
    {
        return [
            [
                'title' => 'Dean’s List',
                'body' => 'Awarded for academic excellence in 2023/2024',
                'year' => '2024',
                'tone' => 'warning',
            ],
            [
                'title' => 'Programming Contest',
                'body' => '1st Position – UBa Coding Challenge',
                'year' => '2023',
                'tone' => 'info',
            ],
            [
                'title' => 'Best Final Year Project',
                'body' => 'Faculty of Science Award',
                'year' => '2023',
                'tone' => 'primary',
            ],
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
