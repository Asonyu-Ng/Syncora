<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;

class TaskPolicy
{
    protected function isAdmin(User $user): bool
    {
        return $user->role === 'admin';
    }

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Task $task): bool
    {
        if ($this->isAdmin($user)) {
            return true;
        }

        if ($user->role === 'student' && $user->studentProfile) {
            return $task->student_profile_id === $user->studentProfile->id;
        }

        if ($user->role === 'company' && $user->companyProfile) {
            return $task->internship
                && $task->internship->company_profile_id === $user->companyProfile->id;
        }

        if ($user->role === 'supervisor' && $user->supervisorProfile) {
            return $task->internship
                && $task->internship->supervisor_profile_id === $user->supervisorProfile->id;
        }

        return $task->assigned_by_user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $this->isAdmin($user) || in_array($user->role, ['company', 'supervisor'], true);
    }

    public function update(User $user, Task $task): bool
    {
        if ($this->isAdmin($user)) {
            return true;
        }

        if ($user->role === 'student') {
            return $this->view($user, $task);
        }

        if (in_array($user->role, ['company', 'supervisor'], true)) {
            return $this->view($user, $task);
        }

        return $task->assigned_by_user_id === $user->id;
    }

    public function submit(User $user, Task $task): bool
    {
        return $user->role === 'student'
            && $user->studentProfile !== null
            && $task->student_profile_id === $user->studentProfile->id;
    }

    public function review(User $user, Task $task): bool
    {
        if ($this->isAdmin($user)) {
            return true;
        }

        return in_array($user->role, ['company', 'supervisor'], true)
            && $this->view($user, $task);
    }

    public function delete(User $user, Task $task): bool
    {
        if ($this->isAdmin($user)) {
            return true;
        }

        return in_array($user->role, ['company', 'supervisor'], true) && $this->view($user, $task);
    }

    public function restore(User $user, Task $task): bool
    {
        return $this->isAdmin($user);
    }

    public function forceDelete(User $user, Task $task): bool
    {
        return $this->isAdmin($user);
    }
}
