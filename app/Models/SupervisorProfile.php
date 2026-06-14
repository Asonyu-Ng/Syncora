<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'user_id',
    'university',
    'position',
    'department',
    'phone',
    'office_location',
    'bio',
])]
class SupervisorProfile extends Model
{
    use HasFactory;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function internships(): HasMany
    {
        return $this->hasMany(Internship::class);
    }

    public function supervisedInternshipsQuery(): Builder
    {
        return Internship::query()->where('supervisor_profile_id', $this->id);
    }

    public function supervisedStudentProfilesQuery(): Builder
    {
        $internshipIds = $this->internships()->select('id');

        return StudentProfile::query()
            ->whereHas('applications', fn (Builder $builder): Builder => $builder->whereIn('internship_id', $internshipIds)->where('status', 'accepted'));
    }
}
