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

        // ユーザーがすでにフォローしているかどうかを確認
        if ($user->followings()->where('followee_id', $followed_user_id)->exists()) {
            // すでにフォローしている場合、フォローを解除
            $user->followings()->detach($followed_user_id);
            $message = 'ユーザーのフォローを解除しました';
        } else {
            // フォローしていない場合、フォローする
            $user->followings()->attach($followed_user_id);
            $message = 'ユーザーをフォローしました';
        }
    
        return redirect()->back()->with('success', $message);
    }
}
