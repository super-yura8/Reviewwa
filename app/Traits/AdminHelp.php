<?php

namespace App\Traits;

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
            'reviews' => 'later)'];

        return $counts;
    }
}
