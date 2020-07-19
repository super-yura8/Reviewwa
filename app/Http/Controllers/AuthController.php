<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function auth(Request $request)
    {
        $data = $request->all();
        if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
            return redirect('/');
        }
    }

    public function register(Request $request)
    {
        $data = $request->all();
        if ($data['password'] == $data['password_again'] && !User::select()->where('email', $data['email'])->first()) {
            $user = User::create(['name' => $data['name'], 'email' => $data['email'], 'password' => password_hash($data['password'], 1)]);
            Auth::login($user);
            return redirect('/');
        }
    }
}
