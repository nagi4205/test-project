<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function show(User $user) {
        $user->load('posts');

        $alreadyFollowing = auth()->user()->followings()->where('followee_id', $user->id)->exists();

        return view('user.show', compact('user', 'alreadyFollowing'));
    }
}
