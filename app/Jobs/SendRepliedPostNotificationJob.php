<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendRepliedPostNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $repliedPost;

    public function __construct()
    {
        $this->post = $post;
        $this->user = $user;
        Log::info("In Job constructor: いいねは{$this->post}です。");
        Log::info("{$this->user}");
        $this->repliedPost = $repliedPost;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        
    }
}
