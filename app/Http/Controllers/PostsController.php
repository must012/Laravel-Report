<?php

namespace App\Http\Controllers;

use App\Attachment;
use App\Http\Requests\PostRequest;
use Illuminate\Http\Request;
use App\Post;


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

    public function index(Request $request)
    {
        $query = Post::orderBy(
            $request->input('sort', 'created_at'),
            $request->input('order', 'desc')
        );


        if ($keyword = $request->input('search')) {
            $raw = 'MATCH(title,content) AGAINST(? IN BOOLEAN MODE)';
            $query = $query->whereRaw($raw, [$keyword]);
        }


//        $list = Post::orderBy('id', 'desc')->paginate(10);
        $list = $query->paginate(10);

        return view('posts.list', compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        $list = new Post();

        return view('posts.formPartial.write', compact('list'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\PostRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        \Log::debug("on posts store");

        $value = array("writer" => $request->writer, "name" => $request->name, "title" => $request->title, "content" => $request->contents);

        $list = Post::create($value);

        \Log::debug("List ID : " . $list->id);

        if (!$list) {
            return back()->with('flash_message', '글이 저장되지 않았습니다.')->withInput();
        }

        if ($request->has('upFiles')) {
            foreach ($request->upFiles as $fid) {
                $attach = Attachment::find($fid);
                $attach->post()->associate($list);
                $attach->save();
            }
        }

        event(new \App\Events\PostsEvent($list));
        event(new \App\Events\ModelChanged(['posts']));

        return redirect()->route('posts.show', $list)->with('flash_message', "작성이 완료되었습니다.");

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post $post
     * @return \Illuminate\Http\Response
     */

    public function show(Post $post)
    {
        $comments = $post->comments()->with('replies')->withTrashed()->whereNull('parent_id')->oldest()->get();

        if (auth()->user()) {
            if (!$post->viewers()->whereViewer(auth()->user()->id)->exists()) {
                $post->viewers()->create([
                    'viewer' => auth()->user()->id
                ]);
            }
        }
        return view('posts.detail', compact('post', 'comments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post $post
     * @return \Illuminate\Http\Response
     */

    public function edit(Post $post)
    {
        $this->authorize('update', $post);

        $list = Post::find($post->id);

        return view('posts.formPartial.edit', compact('list'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Post $post
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, Post $post)
    {
        $this->authorize('update', $post);

        $post->update([
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
        $this->authorize('delete', $post);

        foreach ($post->comments()->get() as $comment) {
            $comment->delete();
        }

        $post->delete();

        return redirect(route('posts.index'))->with('flash_message', $post->id . '번 포스트가 삭제되었습니다');
    }

    public function like(Request $request, Post $post)
    {
        $check = $request->input('like');
        \Log::info('check = ' . $check);
        \Log::info('userid = ' . $request->user()->id);
        $idCheck = $post->likes()->whereUserId($request->user()->id)->exists();


        if (!$idCheck)
            $post->likes()->create([
                'user_id' => $request->user()->id,
                'liked' => null
            ]);

        if ($check == 1) {
            \Log::info('in dislike');
            \Log::info(auth()->user()->id);
            $post->likes()->whereUserId($request->user()->id)->update([
                'liked' => 0,
                'liked_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ]);
        } else {
            \Log::info('in like');
            \Log::info(auth()->user()->id);
            $post->likes()->whereUserId($request->user()->id)->update([
                'liked' => 1,
                'liked_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ]);
        }

        $check = !$check;

        return response()->json([
            'value' => $post->likes()->where('liked', 1)->count()
        ]);
    }

}
