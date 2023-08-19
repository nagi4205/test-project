<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Notifications\LikedPostNotification;
use App\Notifications\NewFollowRequestNotification;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Log;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'read_at',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function markAsRead() {
        $this->update(['read_at' => now()]);
    }

    public static function render($notifications)
    {
        $renderedNotifications = [];
        $viewMap = [
            LikedPostNotification::class => 'notifications.partials.likedPost',
            NewFollowRequestNotification::class => 'notifications.partials.followRequest',
        ];

        foreach ($notifications as $notification) {
            if (array_key_exists($notification->type, $viewMap)) {
                $renderedNotifications[] = View::make($viewMap[$notification->type], ['notification' => $notification])->render();
            } else {
                Log::warning("Unknown notification type: {$notification->type}");
                $renderedNotifications[] = 'Unknown notification type!';
            }
        }

        return $renderedNotifications;
    }

    public function getTypeKey()
    {
        $typeKeys = [
            'App\Notifications\LikedPostNotification' => 'liked_post',
            'App\Notifications\NewFollowRequestNotification' => 'follow_request',
        ];

        return $typeKeys[$this->type] ?? 'unknown_type';
    }
}
