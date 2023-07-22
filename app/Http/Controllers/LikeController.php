<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;


class LikeController extends Controller
{
    public function like(Post $post) {
    
    if ($post->likedBy->contains(auth()->user())) {
        auth()->user()->likedPosts()->detach($post);
    } else {
        auth()->user()->likedPosts()->attach($post);
    }

    return back();
    }

    // public function index() {

    //     $likes = auth()->user()->likes()->get();
    //     $sortedLikes = $likes->sortByDesc(function ($like) {
    //         return $like->pivot->created_at;
    //     });

    //     return view('like.index', compact('sortedLikes'));
    // }

    public function nagi() {
        $user = User::find(1);
        dd($user->likedPosts);
    }

    public function index() {
        $likes = auth()->user()->likedPosts()->orderBy('pivot_created_at', 'desc')->get();

        return view('like.index', compact('likes'));
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
