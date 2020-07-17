<?php

namespace App\Http\Controllers;

use App\Model\Review;
use App\Models\Subscribe;
use App\User;
use Illuminate\Http\Request;

class UserMenuController extends Controller
{
    public function index()
    {
        if (auth()->check()) {
            $user = auth()->user();
        }
        $allReviews = Review::where('user_id', auth()->id());
        $reviews = $allReviews->take(10)->get();
        $count = $allReviews->count();
        return view('layouts.profile', compact('reviews', 'count', 'user'));
    }

    public function userById($id)
    {
        $user = User::findOrFail($id);
        $allReviews = Review::where('user_id', $id);
        $reviews = $allReviews->take(10)->get();
        $count = $allReviews->count();
        return view('layouts.profile', compact('reviews', 'count', 'user'));
    }

    public function changePass()
    {
        return view('inc.changePassForm');
    }

    public function followers($id)
    {
        $type = 'follower';
        $count = Subscribe::where('subscriber_id', $id)->count();
        $user_ids = array_keys(Subscribe::where('subscriber_id', $id)->paginate(10)->groupBy('user_id')->toArray());
        $users = User::findOrFail($user_ids);
        return view('layouts.subscribers', compact('users', 'count', 'type'));
    }

    public function subscriptions($id)
    {
        $type = 'subscriptions';
        $count = Subscribe::where('user_id', $id)->count();
        $user_ids = array_keys(Subscribe::where('user_id', $id)->paginate(10)->groupBy('subscriber_id')->toArray());
        $users = User::findOrFail($user_ids);
        return view('layouts.subscribers', compact('users', 'count', 'type'));
    }

}
