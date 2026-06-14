<?php

namespace App\Livewire\Concerns;

use App\Jobs\Exports\ExportLogbooksJob;
use App\Jobs\Exports\ExportMonitoringJob;
use App\Jobs\Exports\ExportReportsJob;
use App\Support\Exports\ExportNamer;

trait QueuesExports
{
    protected function queueExport(string $type, array $filters = [], ?string $message = null): ?array
    {
        $userId = (int) (auth()->id() ?? 0);

        if ($userId <= 0) {
            session()->flash('message', 'You must be signed in to export.');
            return null;
        }

        $naming = app(ExportNamer::class)->make($type, $userId, $filters);
        $queue = 'exports';

        $job = match ($type) {
            'logbooks' => ExportLogbooksJob::dispatch($userId, $filters, $naming['disk'], $naming['directory'], $naming['filename'])->onQueue($queue),
            'monitoring' => ExportMonitoringJob::dispatch($userId, $filters, $naming['disk'], $naming['directory'], $naming['filename'])->onQueue($queue),
            'reports' => ExportReportsJob::dispatch($userId, $filters, $naming['disk'], $naming['directory'], $naming['filename'])->onQueue($queue),
            default => null,
        };

        if (! $job) {
            session()->flash('message', 'Unable to queue export.');
            return null;
        }

        session()->flash('message', $message ?? 'Export queued.');
        $this->dispatch('export-queued', filename: $naming['filename'], path: $naming['path']);

        return $naming;
    }
}

