<?php

namespace App\Support\Exports;

use Carbon\Carbon;
use Illuminate\Support\Str;

class ExportNamer
{
    public function make(string $type, int $userId, array $filters = [], string $extension = 'csv'): array
    {
        $normalizedType = Str::slug($type, '_');
        $timestamp = Carbon::now()->format('Ymd_His');
        $hash = substr(hash('sha256', json_encode($filters, JSON_THROW_ON_ERROR)), 0, 12);
        $filename = $normalizedType . '_' . $userId . '_' . $timestamp . '_' . $hash . '.' . ltrim($extension, '.');
        $directory = 'private/exports/' . $normalizedType . '/' . $userId;

        return [
            'disk' => 'local',
            'directory' => $directory,
            'filename' => $filename,
            'path' => $directory . '/' . $filename,
        ];
    }
}

