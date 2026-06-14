<?php

namespace App\Services;

use App\Models\CompanyProfile;
use App\Models\Internship;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class InternshipService
{
    public function searchInternships(array $payload = []): LengthAwarePaginator
    {
        $query = Internship::query()
            ->with('companyProfile')
            ->where('status', 'open');

        $keywords = trim((string) ($payload['keywords'] ?? ''));
        $category = trim((string) ($payload['category'] ?? ''));
        $location = trim((string) ($payload['location'] ?? ''));
        $type = trim((string) ($payload['type'] ?? ''));
        $duration = trim((string) ($payload['duration'] ?? ''));
        $postedWithin = $payload['postedWithin'] ?? null;

        if ($keywords !== '') {
            $tokens = preg_split('/\s+/', $keywords, flags: PREG_SPLIT_NO_EMPTY) ?: [];

            foreach ($tokens as $token) {
                $like = '%' . $this->escapeLike($token) . '%';

                $query->where(function (Builder $q) use ($like): void {
                    $q->where('title', 'like', $like)
                        ->orWhere('description', 'like', $like)
                        ->orWhereHas('companyProfile', function (Builder $q) use ($like): void {
                            $q->where('company_name', 'like', $like);
                        });
                });
            }
        }

        if ($category !== '') {
            $query->where('description', 'like', 'Category: ' . $this->escapeLike($category) . '%');
        }

        if ($location !== '') {
            $query->where('location', 'like', '%' . $this->escapeLike($location) . '%');
        }

        if ($type !== '') {
            $query->where('type', $type);
        }

        if ($duration !== '') {
            $query->where('duration', $duration);
        }

        $since = $this->parsePostedWithin($postedWithin);

        if ($since) {
            $query->where('created_at', '>=', $since);
        }

        [$sortField, $sortDirection] = $this->normalizeSort($payload['sort'] ?? null);
        $query->orderBy($sortField, $sortDirection);

        $perPage = (int) ($payload['perPage'] ?? 10);
        $perPage = max(1, min($perPage, 50));

        $page = isset($payload['page']) ? max(1, (int) $payload['page']) : null;

        $paginator = $page
            ? $query->paginate($perPage, ['*'], 'page', $page)
            : $query->paginate($perPage);

        $paginator->getCollection()->transform(function (Internship $internship): array {
            [$category, $tags] = $this->extractCategoryAndTags((string) $internship->description);

            return [
                'id' => $internship->id,
                'title' => (string) $internship->title,
                'company_name' => (string) ($internship->companyProfile?->company_name ?? ''),
                'location' => (string) ($internship->location ?? ''),
                'type' => (string) ($internship->type ?? ''),
                'duration' => (string) ($internship->duration ?? ''),
                'category' => $category,
                'tags' => $tags,
                'created_at' => $internship->created_at?->toDateTimeString(),
            ];
        });

        return $paginator;
    }

    public function postInternship(CompanyProfile $companyProfile, array $data): Internship
    {
        $durationInMonths = max(1, min(5, (int) ($data['duration_in_months'] ?? 1)));
        $skills = array_values(array_filter(
            array_map(
                static fn (mixed $skill): string => trim((string) $skill),
                is_array($data['required_skills'] ?? null) ? $data['required_skills'] : []
            ),
            static fn (string $skill): bool => $skill !== ''
        ));

        return Internship::query()->create([
            'company_profile_id' => $companyProfile->id,
            'title' => trim((string) ($data['title'] ?? '')),
            'department' => trim((string) ($data['department'] ?? '')),
            'location' => trim((string) ($data['location'] ?? '')),
            'type' => trim((string) ($data['type'] ?? '')),
            'duration' => $durationInMonths . ' month' . ($durationInMonths > 1 ? 's' : ''),
            'description' => trim((string) ($data['description'] ?? '')),
            'education_level' => trim((string) ($data['education_level'] ?? '')),
            'other_requirements' => trim((string) ($data['other_requirements'] ?? '')),
            'required_skills' => $skills,
            'status' => 'open',
        ]);
    }

    public function applyToInternship(int|string $internshipId, int $studentId, array $payload = []): array
    {
        return [
            'applicationId' => Str::uuid()->toString(),
            'internshipId' => $internshipId,
            'studentId' => $studentId,
            'status' => 'Applied',
            'submittedAt' => now()->toDateTimeString(),
            'payload' => $payload,
        ];
    }

    public function acceptApplication(int|string $applicationId): array
    {
        return [
            'applicationId' => $applicationId,
            'status' => 'Accepted',
            'updatedAt' => now()->toDateTimeString(),
        ];
    }

    public function rejectApplication(int|string $applicationId, ?string $reason = null): array
    {
        return [
            'applicationId' => $applicationId,
            'status' => 'Rejected',
            'reason' => $reason,
            'updatedAt' => now()->toDateTimeString(),
        ];
    }

    public function approveVerification(int|string $requestId): array
    {
        return [
            'requestId' => $requestId,
            'status' => 'Approved',
            'updatedAt' => now()->toDateTimeString(),
        ];
    }

    public function rejectVerification(int|string $requestId, ?string $reason = null): array
    {
        return [
            'requestId' => $requestId,
            'status' => 'Rejected',
            'reason' => $reason,
            'updatedAt' => now()->toDateTimeString(),
        ];
    }

    private function parsePostedWithin(mixed $value): ?Carbon
    {
        if ($value === null) {
            return null;
        }

        if (is_int($value) || (is_string($value) && ctype_digit($value))) {
            $days = max(0, (int) $value);

            return $days === 0 ? null : now()->subDays($days);
        }

        $normalized = strtolower(trim((string) $value));

        if ($normalized === '') {
            return null;
        }

        return match ($normalized) {
            '24h', '1d' => now()->subHours(24),
            '7d' => now()->subDays(7),
            '14d' => now()->subDays(14),
            '30d' => now()->subDays(30),
            '60d' => now()->subDays(60),
            default => null,
        };
    }

    private function normalizeSort(mixed $sort): array
    {
        if (is_array($sort)) {
            $field = strtolower((string) ($sort['field'] ?? 'created_at'));
            $direction = strtolower((string) ($sort['direction'] ?? 'desc'));
        } else {
            $field = strtolower((string) ($sort ?? 'newest'));
            $direction = 'desc';
        }

        if (in_array($field, ['newest', 'created_desc', 'created_at_desc', 'date_desc'], true)) {
            return ['created_at', 'desc'];
        }

        if (in_array($field, ['oldest', 'created_asc', 'created_at_asc', 'date_asc'], true)) {
            return ['created_at', 'asc'];
        }

        $allowedFields = ['created_at', 'title', 'location', 'type', 'duration'];
        $field = in_array($field, $allowedFields, true) ? $field : 'created_at';
        $direction = $direction === 'asc' ? 'asc' : 'desc';

        return [$field, $direction];
    }

    private function extractCategoryAndTags(string $description): array
    {
        $category = null;
        $tags = [];

        if (preg_match('/^Category:\s*(.+)$/m', $description, $match)) {
            $value = trim((string) ($match[1] ?? ''));
            $category = $value !== '' ? $value : null;
        }

        if (preg_match('/^Tags:\s*(.+)$/m', $description, $match)) {
            $tagsRaw = (string) ($match[1] ?? '');
            $tags = array_values(array_filter(array_map('trim', explode(',', $tagsRaw)), fn (string $tag): bool => $tag !== ''));
        }

        return [$category, $tags];
    }

    private function escapeLike(string $value): string
    {
        return addcslashes($value, "\\%_");
    }
}
