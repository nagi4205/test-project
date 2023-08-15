<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Follow;
use Carbon\Carbon;

class FollowResponseController extends Controller
{
    public function store(Request $request)
    {
            // validation, authentication checks, etc...
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

            return back()->with('message', $message);
        }

        return back()->with('message', 'フォローリクエストが見つかりませんでした。');
    }
}
