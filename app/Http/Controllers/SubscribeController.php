<?php

namespace App\Http\Controllers;

use App\Models\Subscribe;
use App\User;

class SubscribeController extends Controller
{
    public function subscribe($id)
    {
        $user = User::find($id);
        if ($user != null && $id != auth()->id() && Subscribe::where('subscriber_id', $id)->where('user_id', auth()->id())->first() == null) {
            Subscribe::create(['user_id' => auth()->id(), 'subscriber_id' => $id]);
            return response()->json(['message' => 'Успех']);
        } else {
            return abort(404, 'fail');
        }
    }

    public function unsubscribe($id)
    {
        $user = User::find($id);
        if ($user != null && $id != auth()->id() && Subscribe::where('subscriber_id', $id)->where('user_id', auth()->id())->first() != null) {
            Subscribe::where('subscriber_id', $id)->delete();
            return response()->json(['message' => 'Успех']);
        } else {
            return abort(404, 'fail');
        }
    }
}
