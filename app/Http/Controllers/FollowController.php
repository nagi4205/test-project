<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FollowController extends Controller
{
    public function store(Request $request) {
        // フォローするユーザーのIDを取得
        $followed_user_id = $request->input('user_id');

        // 現在のユーザーを取得
        $user = $request->user();

        // フォロー処理
        $user->followings()->attach($followed_user_id);

        return redirect()->back()->with('success', 'ユーザーをフォローしました');
    }
}
