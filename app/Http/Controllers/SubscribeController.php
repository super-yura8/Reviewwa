<?php

namespace App\Http\Controllers;

use App\User;

class SubscribeController extends Controller
{
    public function subscribe($id)
    {
        $user = User::find($id);
        if ($user != null && $id != auth()->id() && auth()->user()->follows->where('id', $id)->first() == null) {
            $user->subscribers()->attach(auth()->id());
            return response()->json(['message' => 'Успех']);
        } else {
            return response(view('errors.404'), 404);
        }
    }

    public function unsubscribe($id)
    {
        $user = User::find($id);
        if ($user != null && $id != auth()->id() && auth()->user()->follows->where('id', $id)->first() != null) {
            $user->subscribers()->detach(auth()->id());
            return response()->json(['message' => 'Успех']);
        } else {
            return response(view('errors.404'), 404);
        }
    }
}
