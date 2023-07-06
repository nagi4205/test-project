<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Post $post)
    {
        return view('comment.create', compact('post'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Post $post)
    {
        // dd($request->input('content'));

        $validated = $request->validate([
            'content' => 'required | max:255',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['post_id'] = $post->id;

        $comment = Comment::create($validated);

        // return back()->with('message', '投稿を保存しました！');
        return redirect()->route('post.show', ['post' => $post->id])->with('message', '投稿を保存しました！');
    }
    /**
     * Display the specified resource.
     */
    // public function show(Post $post,Comment $comment)
    // {
    //     return view('comment.show', compact('post', 'comment'));
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post, Comment $comment)
    {
        return view('comment.edit', compact('comment', 'post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post, Comment $comment)
    {
        $validated = $request->validate([
            'content' => 'required | max:255',
        ]);

        $validated['user_id'] = auth()->id();

        $comment->update($validated);

        $request->session()->flash('message', '更新しました！');
        return redirect()->route('post.show', ['post' => $post->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post,Comment $comment)
    {
        $comment->delete();
        //        ↓あとで実装
        // $request->session()->flash('message', '削除しました！');
    
        return redirect()->route('post.index');
    }
}