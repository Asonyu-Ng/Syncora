<?php

namespace App\Policies;

use App\Models\Evaluation;
use App\Models\User;

class EvaluationPolicy
{
    protected function isAdmin(User $user): bool
    {
        return $user->role === 'admin';
    }

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Evaluation $evaluation): bool
    {
        if ($this->isAdmin($user)) {
            return true;
        }

        if ($evaluation->evaluator_user_id === $user->id) {
            return true;
        }

        if ($user->role === 'student' && $user->studentProfile) {
            return $evaluation->student_profile_id === $user->studentProfile->id;
        }

        return false;
    }

    public function create(User $user): bool
    {
        return $this->isAdmin($user) || in_array($user->role, ['company', 'supervisor'], true);
    }

    public function update(User $user, Evaluation $evaluation): bool
    {
        if ($this->isAdmin($user)) {
            return true;
        }

        return $evaluation->evaluator_user_id === $user->id;
    }

    public function delete(User $user, Evaluation $evaluation): bool
    {
        return $this->update($user, $evaluation);
    }

    public function restore(User $user, Evaluation $evaluation): bool
    {
        return $this->isAdmin($user);
    }

    public function forceDelete(User $user, Evaluation $evaluation): bool
    {
        return $this->isAdmin($user);
    }
}
