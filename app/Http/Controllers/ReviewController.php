<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewFormRequest;
use App\Model\Review;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function createReview(ReviewFormRequest $request)
    {
        $data = $request->all();
        Review::create(['title' => $data['title'], 'content' => $data['content'], 'user_id' => Auth::user()->id]);
        return response()->json([
            'success' => 'true',
            'message' => 'Review created'
        ]);

    }
}
