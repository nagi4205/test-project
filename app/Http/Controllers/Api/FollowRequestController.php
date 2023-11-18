<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Jobs\SendFollowRequestNotificationJob;
use App\Models\Follow;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\DatabaseNotification;
use App\Http\Requests\FollowRequestRequest;



class FollowRequestController extends Controller
{
    public function store(FollowRequestRequest $request) {
        // validation, authentication checks, etc...
        Log::info('FollowRequest::store()のrequest:'.auth()->user());
        Log::info('FollowRequest::store()のrequest:'.$request);


        $followerId = $request->user()->id;
        $followeeId = $request->input('followee_id');

        Log::info('ここまできたよ');

        //　自分自身にフォローリクエストを送っている場合
        if ($followerId == $followeeId) {
            Log::info('同じじゃん');
            return response()->json(['message' => '自分自身にフォローリクエストを送ることはできません。'], 400);
        }

        // $hasFollowedという変数名が気に入らない
        // すでに同じユーザーにフォローリクエストを送っているorフォローリクエストが拒否されているorフォローしている
        $hasFollowed = Follow::where('follower_id', $followerId)
                             ->where('followee_id', $followeeId)
                             ->first();

        if ($hasFollowed) {
            // フォローリクエストが拒否されてから１ヶ月経っていない場合
            // あとでfollowsのデータがrejectされてから１ヶ月で自動的に削除されるようにロジックを組んだ方がいいか検討
            if ($hasFollowed->status == 'rejected' && Carbon::now()->diffInMonths($hasFollowed->rejected_at) < 1) {
                return response()->json('message', 'フォロー申請を送ることはできません。');
            }

            // すでにフォローしているorまだリクエストしている途中の場合
            if (in_array($hasFollowed->status, ['pending', 'accepted'])) {
                return back()->with('message', 'すでにフォローリクエストを送っています。');
            }

            // リクエストが拒否されてから１ヶ月経過しているばあい、再度ペンディングに
            // けどこれだと新規通知として表示されないなあ
            $hasFollowed->status = 'pending';
            $hasFollowed->rejected_at = null;
            $hasFollowed->save();
        } else {
            Follow::create([
                'follower_id' => $followerId,
                'followee_id' => $followeeId,
                'status' => 'pending',
            ]);
        }

        // $result = Follow::handleFollowRequest($followerId, $followeeId);

        dispatch(new SendFollowRequestNotificationJob($followerId, $followeeId));

        return response()->json('フォロー申請を送りましたわよん');
    }
}
