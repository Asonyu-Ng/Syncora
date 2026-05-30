<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'student_profile_id',
    'internship_id',
])]
class SavedInternship extends Model
{
    use HasFactory;

    public function studentProfile(): BelongsTo
    {
        return $this->belongsTo(StudentProfile::class);
    }

    public function internship(): BelongsTo
    {
        return $this->belongsTo(Internship::class);
    }
}
