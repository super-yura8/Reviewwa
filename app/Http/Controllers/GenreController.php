<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\User;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    // Todo: навесить политику
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(Request $request)
    {
        $this->authorize('create', Genre::class);
        $name = $request->all()['name'];
        if (Genre::where('name', $name)->first() == null) {
            $genre = Genre::create(['name' => $name]);
            if ($genre instanceof Genre) {
                return response()->json(['massage' => 'успех']);
            } else {
                return response(view('errors.404'), 404);
            }
        } else {
            return response(view('errors.404'), 404);
        }

    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Request $request)
    {
        $this->authorize('delete', Genre::class);
        $ids = $request->all()['genres'];
        $genres = Genre::whereIn('id', $ids);
        $genre = $genres->delete();
        if ($genre) {
            return response()->json(['massage' => 'успех']);
        } else {
            return response(view('errors.404'), 404);
        }
    }
}
