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
            });
            if (isset($request->all()['sort'])) {
                $sort = $request->all()['sort'];
                if ($sort == 'best') {
                    $reviews = $reviews->whereRaw(
                        "MATCH(title,content) AGAINST(? IN NATURAL LANGUAGE MODE)",
                        $find
                    )->withCount(['Likes' => function ($el) {
                        $el->where('like', 1);
                    }])->orderByDesc('likes_count')->paginate(10);
                } elseif ($sort == 'new') {
                    $reviews = $reviews->whereRaw(
                        "MATCH(title,content) AGAINST(? IN NATURAL LANGUAGE MODE)",
                        $find)->orderByDesc('created_at')->paginate(10);
                } else {
                    $reviews = $reviews->whereRaw(
                        "MATCH(title,content) AGAINST(? IN NATURAL LANGUAGE MODE)",
                        $find
                    )->orderByRaw("MATCH(title,content) AGAINST(? IN NATURAL LANGUAGE MODE) DESC",
                        $find)->paginate(10);
                }
            } else {
                $reviews = $reviews->whereRaw(
                    "MATCH(title,content) AGAINST(? IN NATURAL LANGUAGE MODE)",
                    $find
                )->orderByRaw("MATCH(title,content) AGAINST(? IN NATURAL LANGUAGE MODE) DESC",
                    $find)->paginate(10);
            }
        } elseif (isset($request->all()['genre'])) {
            $genres = explode(',', $request->all()['genre']);
            $reviews = Review::whereHas('genres', function ($el) use ($genres) {
                if (!$genres) {
                    return $el;
                }
                return $el->whereIn('name', $genres);
            })->paginate(10);
        } else {
            $reviews = Review::paginate(10);
        }
        $genres = Genre::all();
        return view('layouts.mainPage', compact('reviews', 'genres'));
    }
}
