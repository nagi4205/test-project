<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
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
        
        return response()->json($user);

        // $isOwnProfile = auth()->id() === $user->id;
        // $hasFollowed = auth()->user()->follows()->where('followee_id', $user->id)
        //                                              ->where('status', 'approved')
        //                                              ->exists();
        // $hasRejected = auth()->user()->follows()->where('followee_id', $user->id)
        //                                             ->where('status', 'rejected')
        //                                             ->exists();
        // $followingsCount = $user->followingUsers->count();
        // $followersCount = $user->followerUsers->count();

        // return view('user.show', compact('user', 'isOwnProfile', 'hasFollowed', 'hasRejected', 'followingsCount', 'followersCount'));
    }
}
