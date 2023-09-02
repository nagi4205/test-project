<?php

namespace App\Services;

use App\Models\Post;

class PostService
{
    public function getFilteredPostsByLocation($lat, $lng, $radius)
    {
        return Post::with('user')
                   ->withinEasyDistance($lat, $lng, $radius)
                   ->orderBy('created_at', 'desc')
                   ->get();
    }

    public function getFilteredPostsByFollowingUsers()
    {
        $followingIds = auth()->user()->followingUsers()->pluck('users.id');
        return Post::whereIn('user_id', $followingIds)->with('user')->get();
    }

    public function attachLikeStatusToPosts($filteredPosts, $likedPostIds)
    {
        foreach ($filteredPosts as $post) {
            if($post->parent_id) {
                $post->parent->hasLiked = in_array($post->parent->id, $likedPostIds);
            }
            $post->hasLiked = in_array($post->id, $likedPostIds);
        }
        return $filteredPosts;
    }
}
