<?php

namespace App\Jobs;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use App\Notifications\LikedPostNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendLikedPostNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $post;
    protected $user;

    public function __construct(Post $post, User $user)
    {
        $this->post = $post;
        $this->user = $user;
        Log::info("In Job constructor: いいねは{$this->post}です。");
        Log::info("{$this->user}");
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->post->user->notify(new LikedPostNotification($this->post, $this->user));
    }
}
