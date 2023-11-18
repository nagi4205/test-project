<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\User;

class FollowController extends Controller
{
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
