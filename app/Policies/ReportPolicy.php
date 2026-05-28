<?php

namespace App\Policies;

use App\Models\Report;
use App\Models\User;

class ReportPolicy
{
    protected function isAdmin(User $user): bool
    {
        return $user->role === 'admin';
    }

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Report $report): bool
    {
        if ($this->isAdmin($user)) {
            return true;
        }

        if ($report->user_id === $user->id) {
            return true;
        }

        if ($user->role === 'supervisor' && $user->supervisorProfile) {
            return $report->internship
                && $report->internship->supervisor_profile_id === $user->supervisorProfile->id;
        }

        return false;
    }

    public function create(User $user): bool
    {
        return $this->isAdmin($user) || $user->role === 'student';
    }

    public function update(User $user, Report $report): bool
    {
        if ($this->isAdmin($user)) {
            return true;
        }

        return $report->user_id === $user->id && $report->status !== 'published';
    }

    public function delete(User $user, Report $report): bool
    {
        if ($this->isAdmin($user)) {
            return true;
        }

        return $report->user_id === $user->id;
    }

    public function restore(User $user, Report $report): bool
    {
        return $this->isAdmin($user);
    }

    public function forceDelete(User $user, Report $report): bool
    {
        return $this->isAdmin($user);
    }
}
