<?php

namespace App\Presenters;

use Carbon\Carbon;

class PostPresenter
{
    protected $post;

    public function __construct($post)
    {
        $this->post = $post;
    }

    public function formattedCreatedAt()
    {
        $diffInMinutes = $this->post->created_at->diffInMinutes();
        $diffInHours = $this->post->created_at->diffInHours();
        $diffInDays = $this->post->created_at->diffInDays();

        if ($diffInMinutes < 60) {
            return "{$diffInMinutes} minutes ago";
        } elseif ($diffInHours < 24) {
            return "{$diffInHours} hours ago";
        } elseif ($diffInDays < 7) {
            return "{$diffInDays} days ago";
        } else {
            return $this->post->created_at->format('Y-m-d');
        }
    }
}
