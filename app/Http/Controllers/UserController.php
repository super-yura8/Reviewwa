<?php

namespace App\Http\Controllers;


use App\Http\Requests\PasswordChangeRequest;
use Illuminate\Http\Request;

class UserController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function changePass(PasswordChangeRequest $request)
    {
        $data = $request->all();
        $user = auth()->user();
        if ($data['pass'] === $data['passAgg'] && password_verify($data['originPass'], $user->getAuthPassword())) {
            $user->password = password_hash($data['pass'], 1);
            $user->save();
            return response()->json(['nice']);
        }
    }
}
