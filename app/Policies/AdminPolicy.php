<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create posts.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        if ($user->can('create')) {
            return true;
        }
    }

    /**
     * Determine whether the user can update the post.
     *
     * @param User $user
     * @return mixed
     */
    public function update(User $user)
    {
        if ($user->can('edit')) {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the post.
     *
     * @param User $user
     * @return mixed
     */
    public function delete(User $user)
    {
        if ($user->can('delete')) {
            return true;
        }
    }
}
