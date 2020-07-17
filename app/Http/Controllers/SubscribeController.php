<?php

namespace App\Http\Controllers;

use App\Models\Subscribe;
use App\User;
use Illuminate\Http\Request;

class SubscribeController extends Controller
{
    public function subscribe($id)
    {
        $user = User::find($id);
        if ($user != null && $id != auth()->id() && Subscribe::where('subscriber_id', $id)->first() == null) {
            Subscribe::create(['user_id' => auth()->id(), 'subscriber_id' => $id]);
            return response()->json(['message' => 'success']);
        } else {
            return response()->json(['message' => 'fail ']);
        }
    }

    public function unsubscribe($id) {
        $user = User::find($id);
        if ($user != null && $id != auth()->id() && Subscribe::where('subscriber_id', $id)->first() != null) {
            Subscribe::where('subscriber_id', $id)->delete();
            return response()->json(['message' => 'success']);
        } else {
            return response()->json(['message' => 'fail']);
        }
    }
}
