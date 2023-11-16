<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Follow;
use Carbon\Carbon;

use Illuminate\Support\Facades\Log;

class FollowResponseController extends Controller
{
    public function store(Request $request)
    {
        $followRequest = Follow::where('follower_id', $request->input('follower_id'))
                            ->where('followee_id', $request->user()->id)
                            ->first();

        if ($followRequest) {
            if ($request->input('action') == 'approve') {
                $followRequest->status = 'approved';
                $message = "フォローリクエストが承認されました。";

            } elseif ($request->input('action') == 'reject') {
                $followRequest->status = 'rejected';
                $followRequest->rejected_at = Carbon::now();
                $message = "フォローリクエストが拒否されました。";
            }

            $followRequest->save();

            $notification = $request->user()->notifications()->where('id', $request->input('notification_id'))->first();
            if ($notification) {
                $notification->delete();
            }

            return response()->json('うまくいきました。');
        }
        
        return back()->with('message', 'フォローリクエストが見つかりませんでした。');
    }
}
