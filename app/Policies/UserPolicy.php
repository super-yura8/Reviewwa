<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Check admin create permission.
     * @param User $user
     *
     * @return bool
     */
    public function canCreate(User $user)
    {
        return $user->hasPermissionTo('create admin');
    }
}
