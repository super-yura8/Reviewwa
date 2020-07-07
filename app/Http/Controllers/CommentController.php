<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function showFirstComments($id)
    {
        $comments = Comment::select()->where('review_id',$id);
        return ['comments' => $comments->take(20)->get(), 'count' => $comments->count()];
    }

    public function getComments($id)
    {
        $comments = Comment::with(['user' => function($query){
            $query->select(['id','name']);
        }])->select()->where('review_id',$id)->paginate(20);
        return response()->json($comments);
    }

    public function create(Request $request, $id)
    {
        //навесить валидацию и политику
        $data = $request->all();
        Comment::create(['content' => $data['content'], 'user_id' => auth()->id(), 'review_id' => $id]);
        return response()->json(['message' => 'created!','name' => auth()->user()->name,'created_at' => date('d-m-Y'), 'content' => $data['content']]);
    }

    public function delete($id)
    {
        //навесить валидацию и политику
        Comment::find($id)->delete();
        return response()->json(['message' => 'success']);
    }

    public function edit(Request $request, $id)
    {
        //навесить валидацию и политику
        $data = $request->all();
        $comment = Comment::find($id);
        $comment->content = $data['content'];
        $comment->save();
        return response()->json(['content' => $data['content']]);
    }
}
