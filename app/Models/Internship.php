<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'company_profile_id',
    'supervisor_profile_id',
    'title',
    'location',
    'type',
    'duration',
    'description',
    'start_date',
    'end_date',
    'status',
])]
class Internship extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }

    public function companyProfile(): BelongsTo
    {
        return $this->belongsTo(CompanyProfile::class);
    }

    public function supervisorProfile(): BelongsTo
    {
        return $this->belongsTo(SupervisorProfile::class);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function logbooks(): HasMany
    {
        return $this->hasMany(Logbook::class);
    }

    public function evaluations(): HasMany
    {
        return $this->hasMany(Evaluation::class);
    }

    public function reports(): HasMany
    {
        return $this->hasMany(Report::class);
    }
}

