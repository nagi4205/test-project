<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;


class LikeController extends Controller
{
    public function like(Post $post) {
    
    if ($post->likedBy->contains(auth()->user())) {
        auth()->user()->likes()->detach($post);
    } else {
        auth()->user()->likes()->attach($post);
    }

    return back();
    }

    public function index() {
        $likes = auth()->user()->likes()->get();
        $sortedLikes = $likes->sortByDesc(function ($like) {
            return $like->pivot->created_at;
        });
        
        return view('like.index', compact('sortedLikes'));
    }

    // public function index() {
    //     $likes = auth()->user()->likes()->orderBy('created_at', 'desc')->get();
    //     return view('like.index', compact('likes'));
    // }

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
