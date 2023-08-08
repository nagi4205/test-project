<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function show(User $user) {
        $user->load(['posts',
                    'follows',
                    'followingUsers' => function ($query) {
                        $query->where('status', 'approved');
                    },
                    'followerUsers' => function ($query) {
                        $query->where('status', 'approved');
                    },
                ]);

        $ViewingOwnProfile = auth()->id() === $user->id;
        $alreadyFollowing = auth()->user()->follows()->where('followee_id', $user->id)
                                                     ->where('status', 'approved')
                                                     ->exists();
        $alreadyRejected = auth()->user()->follows()->where('followee_id', $user->id)
                                                    ->where('status', 'rejected')
                                                    ->exists();
        $followingsCount = $user->followingUsers->count();
        $followersCount = $user->followerUsers->count();

        return view('user.show', compact('user', 'ViewingOwnProfile', 'alreadyFollowing', 'alreadyRejected', 'followingsCount', 'followersCount'));
    }

    public function followings(User $user) {
        $followingUsersCollection = $user->followingUsers()->wherePivot('status', 'approved')
                                      ->orderBy('updated_at', 'desc')
                                      ->get();

        return view('user.followings', ['followingUsersCollection' => $followingUsersCollection]);
    }

    public function followers(User $user) {
        $followerUsersCollection = $user->followerUsers()->wherePivot('status', 'approved')
                                      ->orderBy('updated_at', 'desc')
                                      ->get();

        return view('user.followers', ['followerUsersCollection' => $followerUsersCollection]);
    }
}
