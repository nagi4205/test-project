<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Jobs\SendFollowRequestNotificationJob;
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
        // validation, authentication checks, etc...

        $followerId = $request->user()->id;
        $followeeId = $request->input('user_id');

        if ($followerId == $followeeId) {
            return back()->with('message', '自分自身をフォローすることはできません。');
        }

        $hasFollowed = Follow::where('follower_id', $followerId)
                             ->where('followee_id', $followeeId)
                             ->first();

        if ($hasFollowed) {
            if ($hasFollowed->status == 'rejected' && Carbon::now()->diffInMonths($hasFollowed->rejected_at) < 1) {
                return back()->with('message', 'フォロー申請を送ることはできません。');
            }

            if (in_array($hasFollowed->status, ['pending', 'accepted'])) {
                return back()->with('message', 'すでにフォローリクエストを送っています。');
            }

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

        dispatch(new SendFollowRequestNotificationJob($followerId, $followeeId));

        return back()->with('message', 'フォロー申請を送りました。');
    }

    public function destroy(User $user) {
        $loginUser = Auth::user();
        $follow = $loginUser->follows()->where('followee_id', $user->id)->first();

        if ($follow) {
            $follow->delete();
            return back()->with('message', 'ユーザーのフォローを解除しました。');
        } else {
            return back()->with('message', 'フォロー関係が見つかりませんでした。');
        }
    }

}
