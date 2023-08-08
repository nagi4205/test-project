<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Jobs\SendFollowRequestJob;
use App\Models\Follow;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\DatabaseNotification;
use App\Notifications\NewFollowRequestNotification;


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

    public function createFollowRequestJob(Request $request) {
        // validation, authentication checks, etc...

        $followerId = $request->user()->id;
        Log::info("Follow method: followerId is {$followerId}");
        $followeeId = $request->input('user_id');
        Log::info("Follow method: followeeId is {$followeeId}");

        $same = $followerId == $followeeId;

        if ($same) {
            return back()->with('message', '自分自身をフォローすることはできません。');
        }

        // $existingRequest = DatabaseNotification::where('type', NewFollowRequestNotification::class)
        //                                        ->where('notifiable_id', $followeeId)
        //                                        ->whereJsonContains('data->follower_id', $followerId)
        //                                        ->first();

        // if ($existingRequest) {
        // Log::info("followeeId is {$followeeId}");
        // return back()->with('message', 'すでにフォロー申請を送っています。');
        // }

        $cacheKey = "follow_request:{$followerId}:{$followeeId}";

        if (Redis::get($cacheKey)) {
            return back()->with('message', 'すでにフォロー申請を送っています。');
        }   
    
        // Redis::setex($cacheKey, 300, true); // 5分間キャッシュする
        Redis::set($cacheKey, true, 'EX', 300); 
        
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

    public function unfollow(User $user) {
        // ログイン中のユーザーを取得
        $currentUser = Auth::user();

        // 該当するフォロー関係を検索
        $follow = $currentUser->follows()->where('followee_id', $user->id)->first();
        if ($follow) {
            // フォロー関係が存在すれば削除
            $follow->delete();

            return back()->with('message', 'ユーザーのフォローを解除しました。');
        } else {
            return back()->with('message', 'フォロー関係が見つかりませんでした。');
        }
    }

}
