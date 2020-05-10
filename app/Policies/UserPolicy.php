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


    /**
     * Check user ban permission
     *
     * @param User $currentUser
     * @param User $user
     * @return bool
     */
    public function canBan(User $currentUser, User $user)
    {
        return $currentUser->hasPermissionTo('ban user')
            && $currentUser->id != $user->id
            && ($currentUser->isAnyAdmin() != $user->isAnyAdmin()
                || ($currentUser->isSuperAdmin() && $user->isAdmin()));
    }

    public function canUnban(User $currentUser, User $user)
    {
        return $user->id != $currentUser->id && $user->is_ban && $currentUser->hasPermissionTo('unban user');
    }
}
