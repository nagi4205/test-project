<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use App\Models\Follow;
use App\Models\User;
use App\Notifications\FollowRequestNotification;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendFollowRequestNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $followerId;
    protected $followeeId;


    public function __construct($followerId, $followeeId)
    {
        $this->followerId = $followerId;
        $this->followeeId = $followeeId;
    }

    public function handle(): void
    {
        Log::info('ジョブが実行されています。');
        $followee = User::find($this->followeeId);
        $follower = User::find($this->followerId);
        
        $followee->notify(new FollowRequestNotification($follower));
    }
}
