<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewFormRequest;
use App\Model\Review;
use http\Env\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Likes;

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

    public function like($id)
    {
        $data = Likes::where('review_id', $id)->where('user_id', Auth::id())->first();
        if ($data) {
            if ($data->like) {
                $data->like = 0;
                $data->save();
                return response()->json(['action' => 'unlike']);
            } else {
                $data->like = 1;
                $data->save();
                return response()->json(['action' => 'like']);
            }
        } else {
            Likes::create(['user_id' => Auth::id(), 'review_id' => $id, 'like' => 1]);
            return response()->json(['action' => 'like']);
        }
    }

    public function delete($id)
    {
        Review::find($id)->delete();
        return response()->json(['message' => 'success']);

    }

    public function edit(ReviewFormRequest $request, $id)
    {
        $data = $request->all();
        $review = Review::find($id);
        $review->content = $data['content'];
        $review->title = $data['title'];
        $review->save();
        return response()->json(['message' => 'success']);
    }


}
