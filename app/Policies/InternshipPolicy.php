<?php

namespace App\Policies;

use App\Models\Internship;
use App\Models\User;

class InternshipPolicy
{
    protected function isAdmin(User $user): bool
    {
        return $user->role === 'admin';
    }

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Internship $internship): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $this->isAdmin($user) || $user->role === 'company';
    }

    public function update(User $user, Internship $internship): bool
    {
        if ($this->isAdmin($user)) {
            return true;
        }

        return $user->role === 'company'
            && $user->companyProfile
            && $internship->company_profile_id === $user->companyProfile->id;
    }

    public function delete(User $user, Internship $internship): bool
    {
        return $this->update($user, $internship);
    }

    public function restore(User $user, Internship $internship): bool
    {
        return $this->isAdmin($user);
    }

    public function forceDelete(User $user, Internship $internship): bool
    {
        return $this->isAdmin($user);
    }
}
