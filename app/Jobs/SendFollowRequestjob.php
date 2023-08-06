<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use App\Models\Follow;
use App\Models\User;
use App\Notifications\NewFollowRequestNotification;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendFollowRequestjob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $followerId;
    protected $followeeId;


    public function __construct($followerId, $followeeId)
    {
        $this->followerId = $followerId;
        Log::info("In Job constructor: followerId is {$this->followerId}");
        $this->followeeId = $followeeId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info("At the beginning of handle method: followerId is {$this->followerId}");
        $follow = Follow::where('follower_id', $this->followerId)
        ->where('followee_id', $this->followeeId)
        ->first();

        Log::info($this->followerId);

        if ($follow) {
            if ($follow->status == 'rejected' && Carbon::now()->diffInMonths($follow->rejected_at) < 1) {
            
            Log::info("if it's less than a month since the last rejection, the follow request is not sent");
            
            return;
            }

            $follow->status = 'pending';
            $follow->rejected_at = null;
            $follow->save();

        } else {
            Follow::create([
            'follower_id' => $this->followerId,
            'followee_id' => $this->followeeId,
            'status' => 'pending',
            ]);
        }

        Log::info("At the end of handle method: followerId is {$this->followerId}");

        $followee = User::find($this->followeeId);
        $follower = User::find($this->followerId);
        $followee->notify(new NewFollowRequestNotification($follower));
    }
}
