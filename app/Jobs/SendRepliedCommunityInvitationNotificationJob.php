<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\Community;
use App\Notifications\RepliedCommunityInvitationNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendRepliedCommunityInvitationNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    protected $inviter_id;
    protected $invitee_id;
    protected $community_id;

    public function __construct($inviter_id, $invitee_id, $community_id)
    {
        $this->inviter_id = $inviter_id;
        $this->invitee_id = $invitee_id;
        $this->community_id = $community_id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $inviter = User::find($this->inviter_id);
        $invitee = User::find($this->invitee_id);
        $community = Community::find($this->community_id);
        Log::info('$inviter:'.json_encode($inviter));
        Log::info('$invitee:'.json_encode($invitee));
        Log::info('$community:'.json_encode($community));
        $inviter->notify(new RepliedCommunityInvitationNotification($invitee, $community));
    }
}
