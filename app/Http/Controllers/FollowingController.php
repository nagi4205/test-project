<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class FollowingController extends Controller
{
    public function index(User $user) {
        $followingUsersCollection = $user->followingUsers()->wherePivot('status', 'approved')
                                      ->orderBy('updated_at', 'desc')
                                      ->get();

        return view('user.followings', ['followingUsersCollection' => $followingUsersCollection]);
    }
}
