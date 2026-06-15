<?php

namespace App\Livewire\Student;

use App\Models\Application;
use App\Models\Internship;
use App\Models\SavedInternship;
use App\Models\SavedSearch;
use App\Models\StudentProfile;
use App\Services\InternshipService;
use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class InternshipSearch extends Component
{
    use WithPagination;

    #[Url]
    public string $keywords = '';

    #[Url]
    public string $category = '';

    #[Url]
    public string $location = '';

    #[Url]
    public string $type = '';

    #[Url]
    public string $duration = '';

    #[Url]
    public string $postedWithin = '';

    #[Url]
    public string $sort = 'newest';

    #[Url]
    public int $perPage = 10;

    public bool $searched = false;

    public string $savedSearchName = '';

    public function search(): void
    {
        $this->searched = true;
        $this->resetPage();
    }

    public function mount(): void
    {
        $this->ensureStudentProfile();
        $this->searched = true;
    }

    public function openSaveSearchModal(): void
    {
        $this->savedSearchName = $this->savedSearchName !== '' ? $this->savedSearchName : $this->defaultSavedSearchName();
        $this->dispatch('open-modal', 'save-search');
    }

    public function saveSearch(): void
    {
        $this->validate([
            'savedSearchName' => ['required', 'string', 'max:191'],
        ]);

        $profile = $this->ensureStudentProfile();

        SavedSearch::updateOrCreate(
            [
                'student_profile_id' => $profile->id,
                'name' => $this->savedSearchName,
            ],
            [
                'payload' => $this->currentSearchPayload(),
            ]
        );

        session()->flash('message', 'Search saved.');
        $this->dispatch('close-modal', 'save-search');
    }

    public function toggleBookmark(int $internshipId): void
    {
        $profile = $this->ensureStudentProfile();

        Internship::query()
            ->whereKey($internshipId)
            ->where('status', 'open')
            ->firstOrFail();

        $existing = SavedInternship::query()
            ->where('student_profile_id', $profile->id)
            ->where('internship_id', $internshipId)
            ->first();

        if ($existing) {
            $existing->delete();
            session()->flash('message', 'Removed from saved internships.');
            return;
        }

        SavedInternship::query()->firstOrCreate([
            'student_profile_id' => $profile->id,
            'internship_id' => $internshipId,
        ]);

        session()->flash('message', 'Saved internship.');
    }

    public function applyNow(int $internshipId): void
    {
        $profile = $this->ensureStudentProfile();

        Internship::query()
            ->whereKey($internshipId)
            ->where('status', 'open')
            ->firstOrFail();

        try {
            $application = Application::query()->firstOrCreate(
                [
                    'student_profile_id' => $profile->id,
                    'internship_id' => $internshipId,
                ],
                [
                    'status' => 'applied',
                ]
            );
        } catch (QueryException $e) {
            if (! $this->isUniqueConstraintViolation($e)) {
                report($e);
                session()->flash('message', 'Unable to submit application right now. Please try again.');
                return;
            }

            $application = Application::query()
                ->where('student_profile_id', $profile->id)
                ->where('internship_id', $internshipId)
                ->first();

            if (! $application) {
                session()->flash('message', 'Unable to submit application right now. Please try again.');
                return;
            }
        }

        if ($application?->wasRecentlyCreated) {
            session()->flash('message', 'Application submitted.');
            return;
        }

        session()->flash('message', 'You have already applied for this internship.');
    }

    public function render(): View
    {
        $profile = $this->ensureStudentProfile();

        $results = app(InternshipService::class)->searchInternships([
            'keywords' => $this->keywords,
            'category' => $this->category,
            'location' => $this->location,
            'type' => $this->type,
            'duration' => $this->duration,
            'postedWithin' => $this->postedWithin !== '' ? $this->postedWithin : null,
            'sort' => $this->sort,
            'perPage' => $this->perPage,
            'page' => $this->getPage(),
        ]);

        $internshipIds = collect($results->items())
            ->pluck('id')
            ->filter()
            ->values()
            ->all();

        $savedInternshipIds = $internshipIds === []
            ? []
            : SavedInternship::query()
                ->where('student_profile_id', $profile->id)
                ->whereIn('internship_id', $internshipIds)
                ->pluck('internship_id')
                ->all();

        $appliedInternshipIds = $internshipIds === []
            ? []
            : Application::query()
                ->where('student_profile_id', $profile->id)
                ->whereIn('internship_id', $internshipIds)
                ->pluck('internship_id')
                ->all();

        $dashboardHref = Route::has('student.dashboard') ? route('student.dashboard') : '/student/dashboard';
        $searchHref = Route::has('student.internships.search') ? route('student.internships.search') : '/student/internships';

        return view('livewire.student.internship-search', [
            'title' => 'Internship Search',
            'breadcrumbs' => [
                ['label' => 'Dashboards', 'href' => '/__dashboards'],
                ['label' => 'Student Dashboard', 'href' => $dashboardHref],
                ['label' => 'Internships', 'href' => $searchHref],
                ['label' => 'Search', 'href' => null],
            ],
            'results' => $results,
            'savedInternshipIds' => $savedInternshipIds,
            'appliedInternshipIds' => $appliedInternshipIds,
        ])->extends('layouts.dashboard')->section('content');
    }

    private function ensureStudentProfile(): StudentProfile
    {
        $user = auth()->user();

        return $user->studentProfile()->firstOrCreate();
    }

    private function isUniqueConstraintViolation(QueryException $e): bool
    {
        $errorInfo = $e->errorInfo ?? [];
        $sqlState = $errorInfo[0] ?? null;
        $driverCode = $errorInfo[1] ?? null;
        $message = Str::lower($e->getMessage());

        if ($sqlState === '23505') {
            return true;
        }

        if ($sqlState === '23000' && in_array($driverCode, [1062, 19], true)) {
            return true;
        }

        if (str_contains($message, 'unique constraint') || str_contains($message, 'duplicate')) {
            return true;
        }

        return false;
    }

    private function currentSearchPayload(): array
    {
        return [
            'keywords' => $this->keywords,
            'category' => $this->category,
            'location' => $this->location,
            'type' => $this->type,
            'duration' => $this->duration,
            'postedWithin' => $this->postedWithin,
            'sort' => $this->sort,
            'perPage' => $this->perPage,
        ];
    }

    private function defaultSavedSearchName(): string
    {
        $parts = array_values(array_filter([
            $this->keywords !== '' ? $this->keywords : null,
            $this->location !== '' ? $this->location : null,
            $this->type !== '' ? $this->type : null,
        ]));

        $label = $parts !== [] ? implode(' · ', array_slice($parts, 0, 3)) : 'Internship search';

        return $label . ' · ' . now()->format('Y-m-d H:i');
    }
}
