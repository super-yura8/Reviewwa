<?php
/**
 * Created by PhpStorm.
 * User: zuzel
 * Date: 8/5/2020
 * Time: 12:01 PM
 */

namespace App\Helpers;
use App\User;
use App\Model\Review;

class AdminHelper
{
    static public function getCounts()
    {
        $counts = ['Users' => User::all()->count(),
            'reviews' => Review::all()->count()];

        return $counts;
    }
}
