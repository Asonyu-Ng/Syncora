<?php

namespace App\Jobs\Exports;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\File;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

abstract class AbstractCsvExportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public int $requestedByUserId,
        public array $filters,
        public string $disk,
        public string $directory,
        public string $filename,
    ) {
    }

    abstract protected function headers(): array;

    abstract protected function writeRows($handle): void;

    public function handle(): void
    {
        $tmp = tempnam(sys_get_temp_dir(), 'syncora_export_');

        if ($tmp === false) {
            return;
        }

        $handle = fopen($tmp, 'wb');

        if ($handle === false) {
            @unlink($tmp);
            return;
        }

        fputcsv($handle, $this->headers());
        $this->writeRows($handle);
        fclose($handle);

        Storage::disk($this->disk)->putFileAs($this->directory, new File($tmp), $this->filename);

        @unlink($tmp);
    }
}

