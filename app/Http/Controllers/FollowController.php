<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Jobs\SendFollowRequestJob;
use App\Models\Follow;
use Carbon\Carbon;

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

    public function follow(Request $request) {
        // validation, authentication checks, etc...

        $followerId = $request->user()->id;
        Log::info("Follow method: followerId is {$followerId}");
        $followeeId = $request->input('user_id');
        Log::info("Follow method: followeeId is {$followeeId}");

        $same = $followerId == $followeeId;

        
        if ($same) {
            // return back()->withErrors('自分自身をフォローすることはできません。');
            return back()->with('message', '自分自身をフォローすることはできません。');
        }
        
        dispatch(new SendFollowRequestJob($followerId, $followeeId));

        return back()->with('message', 'フォロー申請を送りました。');
    }

    public function respondToFollowRequest(Request $request) {
    // validation, authentication checks, etc...
    
    
    $follow = Follow::where('follower_id', $request->input('follower_id'))
                    ->where('followee_id', $request->user()->id)
                    ->first();

        if ($follow) {
            if ($request->input('action') == 'approve') {
                $follow->status = 'approved';
                $message = "フォローリクエストが承認されました。";
                
            } elseif ($request->input('action') == 'reject') {
                $follow->status = 'rejected';
                $follow->rejected_at = Carbon::now();
                $message = "フォローリクエストが拒否されました。";
            }
            
            $follow->save();
            
            
            $notification = $request->user()->notifications()->where('id', $request->input('notification_id'))->first();
            if ($notification) {
                $notification->delete();
            }
            
            return back()->with('message', $message);
        }



        return back()->with('message', 'フォローリクエストが見つかりませんでした。');
    }

}
