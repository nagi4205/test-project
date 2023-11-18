<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Follow extends Model
{
    use HasFactory;

    protected $fillable = 
    [
        'follower_id',
        'followee_id',
        'status',
        'rejected_at',
    ];

    public static function handleFollowRequest($followerId, $followeeId)
    {
        $follow = self::where('follower_id', $followerId)
                ->where('followee_id', $followeeId)
                ->first();

        if ($follow) {
            if ($follow->status == 'rejected' && Carbon::now()->diffInMonths($follow->rejected_at) < 1) {
                return back()->with('message', 'フォロー申請を送ることはできません。');
            }
            
            if (in_array($follow->status, ['pending', 'accepted'])) {
                return back()->with('message', 'すでにフォローリクエストを送っています。');
            }

            $follow->status = 'pending';
            $follow->rejected_at = null;
            $follow->save();
        } else {
            Follow::create([
                'follower_id' => $followerId,
                'followee_id' => $followeeId,
                'status' => 'pending',
            ]);
        }
    }
}
