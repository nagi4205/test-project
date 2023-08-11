<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\SendLikedPostNotificationJob;
use App\Models\Post;
use App\Models\User;


class LikeController extends Controller
{
    public function index()
    {
        $likedPosts = auth()->user()->likedPosts()->orderBy('pivot_created_at', 'desc')->get();

        return view('like.index', compact('likedPosts'));
    }

    public function store(Request $request)
    {
        $post = Post::findOrFail($request->input('post_id'));
        $hasAlreadyLiked = $post->likedBy->contains(auth()->user());

        if ($hasAlreadyLiked) {
            auth()->user()->likedPosts()->detach($post);
        } else {
            auth()->user()->likedPosts()->attach($post);
            $user = auth()->user();

            // dispatch(new SendLikedPostJob($followerId, $followeeId));
            SendLikedPostNotificationJob::dispatch($post, $user);
        }


        return back();
    }

    // public function index() {
    //     $likes = auth()->user()
    //         ->likes()
    //         ->join('likes', 'likes.post_id', '=', 'posts.id')
    //         ->orderBy('likes.created_at', 'desc')
    //         ->get();
    
    //     return view('like.index', compact('likes'));
    // }
    

    
    
    public function test() {
        return view('like.test');
    }
}
