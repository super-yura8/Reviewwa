<?php

namespace App\Http\Controllers;

use App\Model\Review;
use Illuminate\Http\Request;

class FindController extends Controller
{
    public function find(Request $request)
    {
        if (isset($request->all()['find'])) {
            $find = explode(' ', $request->all()['find']);
            $reviews = Review::whereRaw(
                "MATCH(title,content) AGAINST(? IN BOOLEAN MODE)",
                $find
            )->paginate(10);
            return view('layouts.mainPage', compact('reviews'));
        } else {
            return abort(404);
        }

    }
}
