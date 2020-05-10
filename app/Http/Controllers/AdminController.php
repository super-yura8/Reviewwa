<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddUserFormRequest;
use App\Http\Requests\BanUserFormRequest;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Traits\AdminHelp;

class AdminController extends Controller
{
    use AdminHelp;

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

    /**
     * Ban user function
     *
     * @param BanUserFormRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function banUser(BanUserFormRequest $request)
    {
        $data = $request->all();
        $user = User::find($data['id']);
        $this->authorize('canBan', $user);
        $date = new \DateTime($data['date']);
        $date = $date->format('Y-m-d');
        $user->banned_until = $date;
        $user->is_ban = 1;
        $user->save();
        return response()->json(['userId' => $data['id']]);
    }

    /**
     * Unban user function
     *
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function unbanUser($id)
    {
        if ($user = User::find($id)){
            $this->authorize('canUnban', $user);
            if ($user->is_ban){
                $user->is_ban=0;
                $user->banned_until=null;
                $user->save();
                return response('User unban',200);
            }
        }
    }

    /**
     * show page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showUsers()
    {
        $users = User::all();
        $counts = self::returnCounts();
        return view('layouts.users', compact('users', 'counts'));
    }

    /**
     * show page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showReviews()
    {
        $reviews = 'Reviews table';
        $counts = self::returnCounts();
        return view('layouts.reviews', compact('reviews', 'counts'));
    }

    /**
     * show page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showAddUser()
    {
        $counts = self::returnCounts();
        return view('layouts.addUser', compact('counts'));
    }

    /**
     * show page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $counts = self::returnCounts();
        return view('layouts.master', compact('counts'));
    }
}
