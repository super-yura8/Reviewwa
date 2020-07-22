<?php

namespace App\Http\Controllers;

use App\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    // Todo: навесить политику
    public function create(Request $request)
    {
        $name = $request->all()['name'];
        $genre = Genre::create(['name' => $name]);
        if ($genre) {
            return response()->json(['massage' => 'успех']);
        } else {
            return response()->json(['massage' => 'провал']);
        }
    }

    public function destroy($id)
    {
        $genre = Genre::findOrFail($id);
        $genre->delete();
        if (!$genre) {
            return response()->json(['massage' => 'успех']);
        } else {
            return response()->json(['massage' => 'провал']);
        }
    }
}
