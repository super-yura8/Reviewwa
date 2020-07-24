<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewFormRequest;
use App\Model\Review;
use Illuminate\Support\Facades\Auth;
use App\Models\Likes;

class ReviewController extends Controller
{
    /**
     * create review
     *
     * @param ReviewFormRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createReview(ReviewFormRequest $request)
    {
        $data = $request->all();
        $review = Review::create(['title' => $data['title'], 'content' => $data['content'], 'user_id' => Auth::user()->id]);
        $genres = $data['genres'];
        $genres = array_map(function ($el) {
            return $el['value'];
        },$genres);
        $review->genres()->attach($genres);
        return response()->json([
            'success' => 'true',
            'message' => 'Review created'
        ]);
    }

    /**
     * create like function
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * delete review
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function delete($id)
    {
        $review = Review::findOrFail($id);
        $this->authorize('delete', $review);
        $review->delete();
        return response()->json(['message' => 'success']);
    }

    /**
     * edit review
     *
     * @param ReviewFormRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(ReviewFormRequest $request, $id)
    {
        $data = $request->all();
        $review = Review::findOrFail($id);
        $this->authorize('edit', $review);
        $review->content = $data['content'];
        $review->title = $data['title'];
        $review->save();
        return response()->json(['message' => 'success']);
    }

    public function getReviewByUser($id)
    {
        $review = $reviews = Review::where('user_id', $id)->withCount(
            ['Likes' => function ($el) {
                $el->where('like', 1);
            },
                'Comments'
            ]
        )->paginate(10);
        return response()->json($review);
    }

    public function usersReviews($id)
    {
        $allReviews = Review::where('user_id', $id);
        $reviews = $allReviews->paginate(10);
        $count = $allReviews->count();
        return view('layouts.usersReviews', compact('reviews', 'count'));
    }
}
