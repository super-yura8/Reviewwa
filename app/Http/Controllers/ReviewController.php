<?php

namespace App\Http\Controllers;

use App\Model\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function createReview(Request $request)
    {
        $data = $request->all();
        Review::create(['title' => $data['title'], 'content' => $data['content'], 'user_id' => 1]); //надо будет поменять на Auth::user()->id
        return json_encode([
            'success' => 'true',
            'message' => 'Review created'
        ]);

    }
}
