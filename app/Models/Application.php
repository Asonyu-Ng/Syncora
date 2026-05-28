<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'internship_id',
    'student_profile_id',
    'status',
    'cover_letter',
    'payload',
    'decided_at',
])]
class Application extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'payload' => 'array',
            'decided_at' => 'datetime',
        ];
    }

    public function internship(): BelongsTo
    {
        return $this->belongsTo(Internship::class);
    }

    public function studentProfile(): BelongsTo
    {
        return $this->belongsTo(StudentProfile::class);
    }
}

