<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class FollowerController extends Controller
{
    public function index(User $user) {
        $followerUsersCollection = $user->followerUsers()->wherePivot('status', 'approved')
                                      ->orderBy('updated_at', 'desc')
                                      ->get();

        return view('user.followers', ['followerUsersCollection' => $followerUsersCollection]);
    }
}
