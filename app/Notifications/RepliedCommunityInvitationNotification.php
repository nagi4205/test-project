<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Models\User;
use App\Models\Community;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RepliedCommunityInvitationNotification extends Notification
{
    use Queueable;

    protected $invitee;
    protected $community;

    public function __construct(User $invitee, Community $community)
    {
        $this->invitee = $invitee;
        $this->community = $community;
    }

    // public function test() {
    //     Log::info('$this->invitee:'.json_encode($this->invitee));
    //     Log::info('$this->community:'.json_encode($this->community));
    // }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'invitee_id' => $this->invitee->id,
            'invitee_name' => $this->invitee->name,
            'community_id' => $this->community->id,
            'community_name' => $this->community->name,
        ];
    }
}
