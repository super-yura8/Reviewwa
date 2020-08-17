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
        $user = auth()->user();
        $allReviews = Review::where('user_id', auth()->id());
        $reviews = $allReviews->paginate(10);
        $count = $allReviews->count();
        return view('layouts.profile', compact('reviews', 'count', 'user'));
    }
    public function userById($id)
    {
        $user = User::findOrFail($id);
        $allReviews = Review::where('user_id', $id);
        $reviews = $allReviews->paginate(10);
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
        $user = User::findOrFail($id);
        $count = $user->subscribers->count();
        $user_ids = array_keys($user->subscribers()->paginate(10)->groupBy('id')->toArray());
        $users = User::findOrFail($user_ids);
        return view('layouts.subscribers', compact('users', 'count', 'type'));
    }

    public function subscriptions($id)
    {
        $type = 'subscriptions';
        $user = User::findOrFail($id);
        $count = $user->follows->count();
        $user_ids = array_keys($user->follows()->paginate(10)->groupBy('id')->toArray());
        $users = User::findOrFail($user_ids);
        return view('layouts.subscribers', compact('users', 'count', 'type'));
    }
}
