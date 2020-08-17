<?php

namespace App\Policies;

use App\Models\Comment;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @param Comment $comment
     * @return bool
     */
    public function delete(User $user, Comment $comment)
    {
        return $user->hasPermissionTo('unpublish comment') || $user->id === $comment->user_id;
    }

    /**
     * @param User $user
     * @param Comment $comment
     * @return bool
     */
    public function edit(User $user, Comment $comment)
    {
        return $user->hasPermissionTo('edit comments') || $user->id === $comment->user_id;
    }
}
