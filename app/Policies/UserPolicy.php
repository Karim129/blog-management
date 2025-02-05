<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /** * Determine whether the user can view any users. */
    public function viewAny(User $user)
    {
        return $user->can('manage users');
    }

    /**
     * Determine whether the user can view a specific user.
     */
    public function view(User $user, User $model): bool
    {
        if ($user->can('manage users')) {
            return true;
        }

        return $user->id === $model->id;
    }

    /**
     * Determine whether the user can create new users.
     */
    public function create(User $user)
    {
        return $user->can('manage users');
    }

    /**
     * Determine whether the user can update a specific user.
     */
    public function update(User $user, User $model): bool
    {
        if ($user->can('manage users')) {
            return true;
        }

        return $user->id === $model->id;
    }

    /**
     * Determine whether the user can delete a specific user.
     */
    public function delete(User $user, User $model): bool
    {
        return $user->can('manage users') && $user->id !== $model->id;
    }

    /**
     * Determine whether the user can assign roles to users.
     */
    public function assignRole(User $user)
    {
        return $user->can('manage users');
    }
}
