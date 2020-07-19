<?php

namespace App\Http\Controllers;

use App\Model\File;
use App\Model\Review;
use App\Http\Controllers\CommentController;
use App\Models\Subscribe;
use App\User;
use Illuminate\Http\Request;

class MainPageController extends Controller
{
    public function index()
    {
        $reviews = Review::paginate(10);
        return view('layouts.mainPage', compact('reviews'));
    }

    public function showReview($id)
    {
        $reviews = Review::findOrFail($id);
        $count = $reviews->comments()->count();
        $comments = $reviews->comments()->orderBy('created_at', 'desc')->take(20)->get();
        $reviews = [$reviews];
        return view('layouts.mainPage', compact('reviews', 'comments', 'count'));
    }

    public function showReviewEditor()
    {
        return view('layouts.addReview');
    }

    public function showEditor($id)
    {
        $review = Review::findOrFail($id);
        $data = ['content' => $review->content, 'title' => $review->title, 'id' => $id];
        return view('layouts.addReview', compact('data'));
    }

    public function showTracked()
    {
        $users = array_keys(Subscribe::where('user_id', auth()->id())->get()->groupBy('subscriber_id')->toArray());
        $reviews = Review::whereIn('user_id', $users)->paginate(10);
        return view('layouts.mainPage', compact('reviews'));
    }
}
