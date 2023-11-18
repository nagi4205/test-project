<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\Community;
use App\Notifications\CommunityInvitationNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendCommunityInvitationNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $invitee_id;
    protected $inviter_id;
    protected $community_id;
    /**
     * Create a new job instance.
     */
    public function __construct($invitee_id, $inviter_id, $community_id)
    {
        $this->invitee_id = $invitee_id;
        $this->inviter_id = $inviter_id;
        $this->community_id = $community_id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $invitee = User::find($this->invitee_id);
        $inviter = User::find($this->inviter_id);
        $community = Community::find($this->community_id);

        $invitee->notify(new CommunityInvitationNotification($inviter, $community));
    }
}
