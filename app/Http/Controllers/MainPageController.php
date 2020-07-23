<?php

namespace App\Http\Controllers;

use App\Model\File;
use App\Model\Review;
use App\Http\Controllers\CommentController;
use App\Models\Genre;
use App\Models\Subscribe;
use App\User;
use Carbon\Carbon;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class MainPageController extends Controller
{
    public function index()
    {
        $reviews = Review::paginate(10);
        return view('layouts.mainPage', compact('reviews'));
    }

    public function showReview($id)
    {
        $reviews = Review::where('id', $id)->paginate(1);
        $count = $reviews->first()->comments()->count();
        $comments = $reviews->first()->comments()->orderBy('created_at', 'desc')->take(20)->get();
        return view('layouts.mainPage', compact('reviews', 'comments', 'count'));
    }

    public function showReviewEditor()
    {
        $genres = Genre::all();
        return view('layouts.addReview', compact('genres'));
    }

    public function showEditor($id)
    {
        $genres = Genre::all();
        $review = Review::findOrFail($id);
        $data = ['content' => $review->content, 'title' => $review->title, 'id' => $id];
        return view('layouts.addReview', compact('data', 'genres'));
    }

    public function showTracked()
    {
        $users = array_keys(Subscribe::where('user_id', auth()->id())->get()->groupBy('subscriber_id')->toArray());
        $reviews = Review::whereIn('user_id', $users)->paginate(10);
        return view('layouts.mainPage', compact('reviews'));
    }

    public function popular(Request $request)
    {
        $page = isset($request->all()['page']) ? $request->all()['page'] : 1;
        $perPage = 10;
        $skip = $perPage * ($page - 1);
        $collection = Review::all()->sort(function ($a, $b) {
            $currentTime = time();
            $aTime = $currentTime - strtotime($a->created_at);
            $bTime = $currentTime - strtotime($b->created_at);
            $aLikes = $a->likes->where('like', 1)->count();
            $bLikes = $b->likes->where('like', 1)->count();
            if (!$aLikes && $bLikes) {
                return 1;
            } elseif ($aLikes && !$bLikes) {
                return -1;
            } elseif ($aLikes && $bLikes) {
                return $bTime - $aTime;
            }
            $aRating = $aLikes / $aTime;
            $bRating = $bLikes / $bTime;
            return $bRating - $aRating;
        })->all();
        $collection = array_slice($collection, $skip, $perPage);
        $reviews = new LengthAwarePaginator($collection, Review::all()->count(), 10);
        return view('layouts.mainPage', compact('reviews'));
    }

    public function best($periodName = null)
    {
        switch ($periodName) {
            case null:
                $period = 1;
                break;
            case 'week':
                $period = 7;
                break;
            case 'mouth':
                $period = 30;
                break;
            case 'year':
                $period = 365;
                break;
            case 'all':
                $period = false;
                break;
            default:
                abort(404);
        }
        if ($period) {
            $reviews = Review::withCount(['Likes' => function ($el) {
                $el->where('like', 1);
            }])->whereDate('created_at', '>=', Carbon::now()->subDays($period)->toDateTimeString())->orderByDesc('likes_count')->paginate(10);
        } else {
            $reviews = Review::withCount(['Likes' => function ($el) {
                $el->where('like', 1);
            }])->orderByDesc('likes_count')->paginate(10);
        }
        return view('layouts.mainPage', compact('reviews'));
    }
}
