<?php

namespace App\Jobs\Exports;

use App\Models\Logbook;
use Illuminate\Database\Eloquent\Builder;

class ExportLogbooksJob extends AbstractCsvExportJob
{
    protected function headers(): array
    {
        return [
            'logbook_id',
            'entry_date',
            'status',
            'student_name',
            'student_email',
            'internship_title',
            'company_name',
            'approved_by',
            'approved_at',
            'content',
        ];
    }

    protected function writeRows($handle): void
    {
        $query = Logbook::query()
            ->with([
                'studentProfile.user',
                'internship.companyProfile',
                'approvedBy',
            ]);

        $supervisorProfileId = (int) ($this->filters['supervisor_profile_id'] ?? 0);

        if ($supervisorProfileId > 0) {
            $query->whereHas('internship', fn (Builder $builder): Builder => $builder->where('supervisor_profile_id', $supervisorProfileId));
        }

        if (isset($this->filters['internship_id']) && $this->filters['internship_id'] !== '') {
            $query->where('internship_id', (int) $this->filters['internship_id']);
        }

        if (isset($this->filters['statuses']) && is_array($this->filters['statuses']) && $this->filters['statuses'] !== []) {
            $statuses = array_values(array_filter(array_map('strval', $this->filters['statuses']), fn (string $value): bool => $value !== ''));
            if ($statuses !== []) {
                $query->whereIn('status', $statuses);
            }
        }

        if (isset($this->filters['status']) && $this->filters['status'] !== '') {
            $query->where('status', (string) $this->filters['status']);
        }

        if (isset($this->filters['from']) && $this->filters['from'] !== '') {
            $query->whereDate('entry_date', '>=', (string) $this->filters['from']);
        }

        if (isset($this->filters['to']) && $this->filters['to'] !== '') {
            $query->whereDate('entry_date', '<=', (string) $this->filters['to']);
        }

        if (isset($this->filters['q']) && trim((string) $this->filters['q']) !== '') {
            $q = trim((string) $this->filters['q']);

            $query->where(function (Builder $builder) use ($q): void {
                $builder->where('content', 'like', '%' . addcslashes($q, "\\%_") . '%')
                    ->orWhereHas('studentProfile.user', fn (Builder $user): Builder => $user->where('name', 'like', '%' . addcslashes($q, "\\%_") . '%'))
                    ->orWhereHas('internship', fn (Builder $internship): Builder => $internship->where('title', 'like', '%' . addcslashes($q, "\\%_") . '%'));
            });
        }

        $query->orderBy('id')->chunk(500, function ($logbooks) use ($handle): void {
            foreach ($logbooks as $logbook) {
                fputcsv($handle, [
                    $logbook->id,
                    $logbook->entry_date?->format('Y-m-d'),
                    (string) $logbook->status,
                    (string) ($logbook->studentProfile?->user?->name ?? ''),
                    (string) ($logbook->studentProfile?->user?->email ?? ''),
                    (string) ($logbook->internship?->title ?? ''),
                    (string) ($logbook->internship?->companyProfile?->company_name ?? ''),
                    (string) ($logbook->approvedBy?->name ?? ''),
                    $logbook->approved_at?->format('Y-m-d H:i:s'),
                    (string) ($logbook->content ?? ''),
                ]);
            }
        });
    }
}
