<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddUserFormRequest;
use App\User;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Create user function
     *
     * @param  AddUserFormRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function createUser(AddUserFormRequest $request)
    {
        $this->authorize('canCreate', Auth::user());
        $data = $request->all();
        if ($data['password'] == $data['passwordAgain']) {
            $user = User::create(['name' => $data['name'],
                'email' => $data['email'],
                'password' => password_hash($data['password'], 1)]);

            if (isset($data['role'])) {
                $user->assignRole($data['role']);
            }

            if (isset($data['permission'])) {
                $user->givePermissionTo($data['permission']);
            }

            return response()->json(['userName' => $data['name']]);
        }
    }
}
