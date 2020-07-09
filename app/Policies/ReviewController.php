<?php

namespace App\Policies;

use App\User;
use App\Model\Review;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReviewController
{
    use HandlesAuthorization;

    /**
     *
     * @param  \App\User $user
     * @param  \App\Model\Review $review
     * @return bool
     */
    public function edit(User $user, Review $review)
    {
        return $user->hasPermissionTo('edit reviews') || $user->id === $review->user_id;
    }

    /**
     *
     * @param  \App\User $user
     * @param  \App\Model\Review $review
     * @return bool
     */
    public function delete(User $user, Review $review)
    {
        return $user->hasPermissionTo('unpublish review') || $user->id === $review->user_id;
    }
}
