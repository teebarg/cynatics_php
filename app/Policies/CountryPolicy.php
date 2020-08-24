<?php

namespace App\Policies;

use App\Models\Country;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CountryPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine whether the user can create posts.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        if ($user->can('create country')) {
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
        if ($user->can('edit country')) {
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
        if ($user->can('delete country')) {
            return true;
        }
    }
}
