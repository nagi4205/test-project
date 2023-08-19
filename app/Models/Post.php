<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'image',
        'latitude',
        'longitude',
        'location_name',
        'parent_id',
        'user_id',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function tags() {
        return $this->belongsToMany(Tag::class, 'post_tags');
    }

    public function likedBy() {
        return $this->belongsToMany(User::class, 'likes')->withTimestamps();
    }

    public function parent() {
        return $this->belongsTo(Post::class, 'parent_id');
    }

    public function children() {
        return $this->hasMany(Post::class, 'parent_id');
    }

    public function scopeWithinDistance($query, $lat, $lng, $radius = 3) {
    $query->whereRaw("
        ( 6371 * acos( cos( radians(?) ) *
          cos( radians( latitude ) )
          * cos( radians( longitude ) - radians(?)
          ) + sin( radians(?) ) *
          sin( radians( latitude ) ) )
        ) <= ?", [$lat, $lng, $lat, $radius]);
    }
}
