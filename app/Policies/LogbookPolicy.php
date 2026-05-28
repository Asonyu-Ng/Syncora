<?php

namespace App\Policies;

use App\Models\Logbook;
use App\Models\User;

class LogbookPolicy
{
    protected function isAdmin(User $user): bool
    {
        return $user->role === 'admin';
    }

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Logbook $logbook): bool
    {
        if ($this->isAdmin($user)) {
            return true;
        }

        if ($user->role === 'student' && $user->studentProfile) {
            return $logbook->student_profile_id === $user->studentProfile->id;
        }

        if ($user->role === 'supervisor' && $user->supervisorProfile) {
            return $logbook->internship
                && $logbook->internship->supervisor_profile_id === $user->supervisorProfile->id;
        }

        return false;
    }

    public function create(User $user): bool
    {
        return $this->isAdmin($user) || $user->role === 'student';
    }

    public function update(User $user, Logbook $logbook): bool
    {
        if ($this->isAdmin($user)) {
            return true;
        }

        if ($user->role === 'student') {
            return $this->view($user, $logbook) && $logbook->status !== 'approved';
        }

        if ($user->role === 'supervisor') {
            return $this->view($user, $logbook);
        }

        return false;
    }

    public function delete(User $user, Logbook $logbook): bool
    {
        if ($this->isAdmin($user)) {
            return true;
        }

        return $user->role === 'student'
            && $this->view($user, $logbook)
            && $logbook->status !== 'approved';
    }

    public function restore(User $user, Logbook $logbook): bool
    {
        return $this->isAdmin($user);
    }

    public function forceDelete(User $user, Logbook $logbook): bool
    {
        return $this->isAdmin($user);
    }
}
