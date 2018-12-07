<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use App\Http\Requests\CommentsRequest;
use Symfony\Component\CssSelector\Parser\Handler\CommentHandler;

class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

    public function store(CommentsRequest $request, Post $post)
    {
        $post->comments()->create(array_merge(
            $request->all(),
            ['user_id' => $request->user()->id]
        ));

        return redirect(route('posts.show', $post->id) . '#comments-head');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */

    public function update(CommentsRequest $request, Comment $comment)
    {
        $this->authorize('comment_update',$comment);
        
        $comment->update($request->all());

        return redirect(route('posts.show', $comment->commentable_id) . '#comments-head');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */

    public function destroy(Comment $comment)
    {
        $this->authorize('comment_update',$comment);

        if ($comment->replies->count() > 0)
            $comment->delete();
        else
            $comment->forceDelete();

        event(new \App\Events\ModelChanged(['posts']));

        return response()->json([], 204, [], JSON_PRETTY_PRINT);
    }
}
