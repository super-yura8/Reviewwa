<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class GenrePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create genres');
    }

    public function delete (User $user)
    {
        return $user->hasPermissionTo('delete genres');
    }
}
