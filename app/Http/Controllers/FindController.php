<?php

namespace App\Http\Controllers;

use App\Model\Review;
use App\Models\Genre;
use Illuminate\Http\Request;

class FindController extends Controller
{
    public function find(Request $request)
    {
        if (isset($request->all()['find'])) {
            $genres = isset($request->all()['genre']) ? explode(',', $request->all()['genre']) : '';
            $find = explode(' ', $request->all()['find']);
            $reviews = Review::whereHas('genres', function ($el) use ($genres) {
                if (!$genres) {
                    return $el;
                }
                return $el->whereIn('name', $genres);
            })->whereRaw(
                "MATCH(title,content) AGAINST(? IN NATURAL LANGUAGE MODE)",
                $find
            )->orderByRaw("MATCH(title,content) AGAINST(? IN NATURAL LANGUAGE MODE) DESC",
                $find)->paginate(10);
        } elseif (isset($request->all()['genre'])) {
            $genres = explode(',', $request->all()['genre']);
            $reviews = Review::whereHas('genres', function ($el) use ($genres) {
                if (!$genres)
                {
                    return $el;
                }
                return $el->whereIn('name', $genres);
            })->paginate(10);
        } else {
            return abort(404);
        }
        $genres = Genre::all();
        return view('layouts.mainPage', compact('reviews', 'genres'));
    }
}
