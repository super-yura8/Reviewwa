<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentFormRequest;
use App\Models\Comment;
use Illuminate\Http\Request;


class CommentController extends Controller
{
    /**
     * return first 20 comments
     *
     * @param $id
     * @return array
     */
    public function showFirstComments($id)
    {
        $comments = Comment::select()->where('review_id',$id);
        return ['comments' => $comments->take(20)->get(), 'count' => $comments->count()];
    }

    /**
     * return json comments
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getComments($id)
    {
        $comments = Comment::with(['user' => function($query){
            $query->select(['id','name']);
        }])->select()->where('review_id',$id)->paginate(20);
        return response()->json(['comments' => $comments,
            'canUpdate' => auth()->user()->hasPermissionTo('edit comments'),
            'canDelete' => auth()->user()->hasPermissionTo('unpublish comment')]);
    }

    /**
     * create comment
     *
     * @param CommentFormRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(CommentFormRequest $request, $id)
    {
        //навесить валидацию и политику
        $data = $request->all();
        $comment = Comment::create(['content' => $data['content'], 'user_id' => auth()->id(), 'review_id' => $id]);
        return response()->json(['message' => 'created!','name' => auth()->user()->name,'created_at' => date('d-m-Y'), 'content' => $data['content'], 'id' => $comment->id]);
    }

    /**
     * delete comment
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function delete($id)
    {
        $comment = Comment::find($id);
        $this->authorize('delete', $comment);
        $comment->delete();
        return response()->json(['message' => 'success']);
    }

    /**
     * edit comment
     *
     * @param CommentFormRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(CommentFormRequest $request, $id)
    {
        $data = $request->all();
        $comment = Comment::find($id);
        $this->authorize('edit', $comment);
        $comment->content = $data['content'];
        $comment->save();
        return response()->json(['content' => $data['content']]);
    }
}
