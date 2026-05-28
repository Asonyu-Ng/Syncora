<?php

namespace App\Policies;

use App\Models\Application;
use App\Models\User;

class ApplicationPolicy
{
    protected function isAdmin(User $user): bool
    {
        return $user->role === 'admin';
    }

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Application $application): bool
    {
        if ($this->isAdmin($user)) {
            return true;
        }

        if ($user->role === 'student' && $user->studentProfile) {
            return $application->student_profile_id === $user->studentProfile->id;
        }

        if ($user->role === 'company' && $user->companyProfile) {
            return $application->internship
                && $application->internship->company_profile_id === $user->companyProfile->id;
        }

        if ($user->role === 'supervisor' && $user->supervisorProfile) {
            return $application->internship
                && $application->internship->supervisor_profile_id === $user->supervisorProfile->id;
        }

        return false;
    }

    public function create(User $user): bool
    {
        return $this->isAdmin($user) || $user->role === 'student';
    }

    public function update(User $user, Application $application): bool
    {
        if ($this->isAdmin($user)) {
            return true;
        }

        if ($user->role === 'student') {
            return $this->view($user, $application) && $application->status === 'pending';
        }

        if (in_array($user->role, ['company', 'supervisor'], true)) {
            return $this->view($user, $application);
        }

        return false;
    }

    public function delete(User $user, Application $application): bool
    {
        if ($this->isAdmin($user)) {
            return true;
        }

        return $user->role === 'student'
            && $this->view($user, $application)
            && $application->status === 'pending';
    }

    public function restore(User $user, Application $application): bool
    {
        return $this->isAdmin($user);
    }

    public function forceDelete(User $user, Application $application): bool
    {
        return $this->isAdmin($user);
    }
}
