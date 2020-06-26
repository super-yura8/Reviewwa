<?php

namespace App\Traits;

use App\Model\Review;
use App\User;

trait AdminHelp
{

    /**
     * return counts of users and reviews
     *
     * @return array
     */
    protected static function returnCounts()
    {
        $counts = ['Users' => User::all()->count(),
            'reviews' => Review::all()->count()];

        return $counts;
    }
}
