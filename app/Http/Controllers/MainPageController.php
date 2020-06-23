<?php

namespace App\Http\Controllers;

use App\Model\File;
use App\Model\Review;
use Illuminate\Http\Request;

class MainPageController extends Controller
{
    public function index()
    {
        $reviews = Review::all()->take(10);
        return view('layouts.mainPage', compact('reviews'));
    }

    public function getPage()
    {
        $reviews = Review::paginate(10);
        return response()->json($reviews);
    }


    public function showReviewEditor()
    {
        return view('layouts.addReview');
    }
}
