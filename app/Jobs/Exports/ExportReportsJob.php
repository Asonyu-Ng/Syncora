<?php

namespace App\Jobs\Exports;

use App\Models\Report;
use Illuminate\Database\Eloquent\Builder;

class ExportReportsJob extends AbstractCsvExportJob
{
    protected function headers(): array
    {
        return [
            'report_id',
            'name',
            'type',
            'status',
            'student_name',
            'student_email',
            'internship_title',
            'company_name',
            'generated_at',
            'created_at',
            'content',
        ];
    }

    protected function writeRows($handle): void
    {
        $query = Report::query()
            ->with([
                'studentProfile.user',
                'internship.companyProfile',
            ]);

        $supervisorProfileId = (int) ($this->filters['supervisor_profile_id'] ?? 0);

        if ($supervisorProfileId > 0) {
            $query->whereHas('internship', fn (Builder $builder): Builder => $builder->where('supervisor_profile_id', $supervisorProfileId));
        }

        if (isset($this->filters['internship_id']) && $this->filters['internship_id'] !== '') {
            $query->where('internship_id', (int) $this->filters['internship_id']);
        }

        if (isset($this->filters['company_id']) && $this->filters['company_id'] !== '') {
            $companyId = (int) $this->filters['company_id'];
            $query->whereHas('internship', fn (Builder $builder): Builder => $builder->where('company_profile_id', $companyId));
        }

        if (isset($this->filters['status']) && $this->filters['status'] !== '') {
            $query->where('status', (string) $this->filters['status']);
        }

        if (isset($this->filters['type']) && $this->filters['type'] !== '') {
            $query->where('type', (string) $this->filters['type']);
        }

        if (isset($this->filters['from']) && $this->filters['from'] !== '') {
            $query->where(function (Builder $builder): void {
                $builder->whereDate('generated_at', '>=', (string) $this->filters['from'])
                    ->orWhereDate('created_at', '>=', (string) $this->filters['from']);
            });
        }

        if (isset($this->filters['to']) && $this->filters['to'] !== '') {
            $query->where(function (Builder $builder): void {
                $builder->whereDate('generated_at', '<=', (string) $this->filters['to'])
                    ->orWhereDate('created_at', '<=', (string) $this->filters['to']);
            });
        }

        if (isset($this->filters['q']) && trim((string) $this->filters['q']) !== '') {
            $q = trim((string) $this->filters['q']);

            $query->where(function (Builder $builder) use ($q): void {
                $builder->where('name', 'like', '%' . addcslashes($q, "\\%_") . '%')
                    ->orWhere('content', 'like', '%' . addcslashes($q, "\\%_") . '%')
                    ->orWhereHas('studentProfile.user', fn (Builder $user): Builder => $user->where('name', 'like', '%' . addcslashes($q, "\\%_") . '%'))
                    ->orWhereHas('internship', fn (Builder $internship): Builder => $internship->where('title', 'like', '%' . addcslashes($q, "\\%_") . '%'));
            });
        }

        $query->orderBy('id')->chunk(250, function ($reports) use ($handle): void {
            foreach ($reports as $report) {
                fputcsv($handle, [
                    $report->id,
                    (string) $report->name,
                    (string) ($report->type ?? ''),
                    (string) $report->status,
                    (string) ($report->studentProfile?->user?->name ?? ''),
                    (string) ($report->studentProfile?->user?->email ?? ''),
                    (string) ($report->internship?->title ?? ''),
                    (string) ($report->internship?->companyProfile?->company_name ?? ''),
                    $report->generated_at?->format('Y-m-d H:i:s'),
                    $report->created_at?->format('Y-m-d H:i:s'),
                    (string) ($report->content ?? ''),
                ]);
            }
        });
    }
}
