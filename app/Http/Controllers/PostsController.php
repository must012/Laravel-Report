<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;


class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    public function index()
    {
        //
        $list = Post::orderBy('id', 'desc')->paginate(10);

        return view('posts.list', compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('posts.write');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        $rules = [
            'title' => ['required'],
            'writer' => ['required'],
            'name' => ['required']
        ];

        $messages = [
            'title.required' => '제목이 입력되어야 합니다',
            'writer.required' => '로그인 정보 확인',
            'name.required' => '로그인 정보 확인'
        ];

        $this->validate($request, $rules, $messages);

        $value = array("writer" => $request->writer, "name" => $request->name, "title" => $request->title, "content" => $request->contents);

        $post = Post::create($value);


        if (!$post) {
            return back()->with('flash_message', '글이 저장되지 않았습니다.')->withInput();
        }

        return redirect(route('posts.show', $post))->with('flash_message', "작성이 완료되었습니다.");

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post $post
     * @return \Illuminate\Http\Response
     */

    public function show(Post $post)
    {
        //

        $list = Post::find($post->id);

        return view('posts.detail', compact('list'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
        $list = Post::find($post->id);

        return view('posts.edit', compact('list'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Post $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //

        $this->authorize('update', $post);

        $obj = Post::findOrFail($post->id);

        $obj->update([
            'title' => $request->get('title'),
            'content' => $request->get('contents')
        ]);

        return redirect(route('posts.show', $post->id))->with('flash_message', '수정이 완료 되었습니다.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
        $this->authorize('delete', $post);

        $obj = Post::findOrFail($post->id);

        foreach ($obj->comments()->get() as $comment) {
            $comment->delete();
        }

        $obj->delete();

        return redirect(route('posts.index'))->with('flash_message', $obj->id . '번 포스트가 삭제되었습니다');
    }


}
