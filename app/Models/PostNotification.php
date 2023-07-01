<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'notification_period',
        'notification_status',
        'user_id',
        'post_id',
    ]

    public fanction user()
    {
        return $this->belongsTo(User::class);
    }

    public fanction post()
    {
        return $this->belongsTo(Post::class);
    }
}
