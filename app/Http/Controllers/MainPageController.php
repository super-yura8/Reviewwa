<?php

namespace App\Http\Controllers;

use App\Model\File;
use App\Model\Review;
use App\Http\Controllers\CommentController;
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
        $reviews = Review::withCount(
            ['Likes' => function($el) {$el->where('like', 1);},
                'Comments'
            ])->with(['User' => function($el) {$el->select('id','name');}])->paginate(10);
        return response()->json($reviews);
    }

    public function showReview($id)
    {
        $reviews = Review::find($id);
        $count = $reviews->comments()->count();
        $comments = $reviews->comments()->take(20)->get();
        $reviews = [$reviews];
        return view('layouts.mainPage', compact('reviews', 'comments', 'count'));
    }

    public function showReviewEditor()
    {
        return view('layouts.addReview');
    }

    public function showEditor($id)
    {
        $review = Review::find($id);
        $data = ['content' => $review->content, 'title' => $review->title, 'id' => $id];
        return view('layouts.addReview', compact('data'));
    }
}
