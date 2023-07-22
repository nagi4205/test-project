<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;

class CommentController extends Controller
{
    public function create(Post $post)
    {
        return view('comment.create', compact('post'));
    }

    public function store(StoreCommentRequest $request, Post $post)
    {
        $validated = $request->validated();

        $validated['user_id'] = auth()->id();
        $validated['post_id'] = $post->id;

        $comment = Comment::create($validated);

        // return back()->with('message', '投稿を保存しました！');
        return redirect()->route('post.show', ['post' => $post->id])->with('message', '投稿を保存しました！');
    }

    public function edit(Post $post, Comment $comment)
    {
        $user = Auth::user();
        if($user->id !== $comment->user_id) {
            abort(403, 'Unauthorized action.');
        }
        return view('comment.edit', compact('comment', 'post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommentRequest $request, Post $post, Comment $comment)
    {
        $comment->update($request->validated());

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