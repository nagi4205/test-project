<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Jobs\SendLikedPostNotificationJob;
use App\Models\Post;
use Illuminate\Support\Facades\Log;
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
        $data = [];

        if ($hasAlreadyLiked) {
            auth()->user()->likedPosts()->detach($post);
            $data['status'] = 'unliked';
        } else {
            auth()->user()->likedPosts()->attach($post);
            $user = auth()->user();
            $data['status'] = 'liked';

            // dispatch(new SendLikedPostJob($followerId, $followeeId));
            // SendLikedPostNotificationJob::dispatch($post, $user);
        }

        $data['likeCount'] = $post->likedby->count();

        return response()->json($data);
    }
}
