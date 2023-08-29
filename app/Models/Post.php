<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Presenters\PostPresenter;

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

    public function present() {
        return new PostPresenter($this);
    }

    // public function scopeWithinDistance($query, $lat, $lng, $radius = 3) {
    // $query->whereRaw("
    //     ( 6371 * acos( cos( radians(?) ) *
    //       cos( radians( latitude ) )
    //       * cos( radians( longitude ) - radians(?)
    //       ) + sin( radians(?) ) *
    //       sin( radians( latitude ) ) )
    //     ) <= ?", [$lat, $lng, $lat, $radius]);
    // }

    public function scopeWithinEasyDistance($query, $lat, $lng, $radius = 3) {
        $latDelta = $radius / 111; // 地球上で1度の緯度はおおよそ111km
        $lngDelta = $radius / (111 * cos(deg2rad($lat))); // 経度の変化は緯度に依存
    
        $minLat = $lat - $latDelta;
        $maxLat = $lat + $latDelta;
        $minLng = $lng - $lngDelta;
        $maxLng = $lng + $lngDelta;
    
        $query->whereBetween('latitude', [$minLat, $maxLat])
              ->whereBetween('longitude', [$minLng, $maxLng]);
    }

    public function getFormattedCreatedAtAttribute() {
        return $this->present()->formattedCreatedAt();
    }

    // public function getFormattedCreatedAtAttribute() {
    //     $post = new PostPresenter($this);
    //     return $post->formattedCreatedAt();
    // }

    // public function getFormattedCreatedAtAttribute() {
    //     $diffInMinutes = $this->created_at->diffInMinutes();
    //     $diffInHours = $this->created_at->diffInHours();
    //     $diffInDays = $this->created_at->diffInDays();

    //     if ($diffInMinutes < 60) {
    //         return "{$diffInMinutes} minutes ago";
    //     } elseif ($diffInHours < 24) {
    //         return "{$diffInHours} hours ago";
    //     } elseif ($diffInDays < 7) {
    //         return "{$diffInDays} days ago";
    //     } else {
    //         return $this->created_at->format('Y-m-d');
    //     }
    // }
}
