<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddUserFormRequest;
use App\Http\Requests\BanUserFormRequest;
use App\Http\Requests\ChangeFormRequest;
use App\Model\Review;
use App\Models\Genre;
use App\Models\Permissions;
use App\Models\Roles;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Helpers\AdminHelper;

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
        $user = User::findOrFail($data['id']);
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
        if ($user = User::findOrFail($id)) {
            $this->authorize('canUnban', $user);
            if ($user->is_ban) {
                $user->is_ban = 0;
                $user->banned_until = null;
                $user->save();
                return response('', 200);
            }
        }
    }

    /**
     * Update user function
     *
     * @param ChangeFormRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function updateUser(ChangeFormRequest $request, $id)
    {
        $data = $request->all();
        $user = User::findOrFail($id);
        $this->authorize('canChange', $user);
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->save();
        return response()->json(['name' => $data['name'], 'email' => $data['email']]);
    }

    /**
     * show page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showUsers()
    {
        $users = User::all();
        $counts = AdminHelper::getCounts();
        return view('layouts.users', compact('users', 'counts'));
    }

    /**
     * show page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showReviews()
    {
        $reviews = Review::all();
        $counts = AdminHelper::getCounts();
        return view('layouts.reviews', compact('reviews', 'counts'));
    }

    /**
     * show page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showReviewsByUser($user)
    {
        $reviews = Review::all()->where('user.name', $user);
        $counts = AdminHelper::getCounts();
        return view('layouts.reviews', compact('reviews', 'counts'));
    }

    /**
     * show page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showAddUser()
    {
        $counts = AdminHelper::getCounts();
        $roles = Roles::all();
        $permissions = Permissions::all();
        return view('layouts.addUser', compact('counts', 'roles', 'permissions'));
    }

    /**
     * show page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $counts = AdminHelper::getCounts();
        return view('layouts.master', compact('counts'));
    }

    /**
     * show page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showAddGenre()
    {
        $counts = AdminHelper::getCounts();
        return view('layouts.addGenre', compact('counts'));
    }

    public function showRemoveGenre()
    {
        $counts = AdminHelper::getCounts();
        $genres = Genre::all();
        return view('layouts.removeGenre', compact('counts', 'genres'));
    }
}
