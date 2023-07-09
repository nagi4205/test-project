<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationResponse extends Model
{
    use HasFactory;

    protected $fillable = [
        'notification_id',
        'user_id',
        'response',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function notification(){
        return $this->belongsTo(Notification::class);
    }
}
