<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_image',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function posts() {
        return $this->hasMany(Post::class);
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function community() {
        return $this->belongsToMany(Community::class, 'community_members', 'user_id', 'community_id');
    }

    public function likedPosts() {
        return $this->belongsToMany(Post::class, 'likes')->withTimestamps();
    }

    public function dailyStatuses() {
        return $this->hasMany(UserDailyStatus::class);
    }

    public function customNotifications() {
        return $this->hasMany(Notification::class, 'notifiable_id');
    }

    public function notificationResponse() {
        return $this->hasMany(notificationResponse::class);
    }

    public function followingUsers() {
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'followee_id')->withTimestamps();
    }
    
    public function followerUsers() {
        return $this->belongsToMany(User::class, 'follows', 'followee_id', 'follower_id')->withTimestamps();
    }

    public function follows() {
        return $this->hasMany(Follow::class, 'follower_id');
    }

    public function getLikedPostIdsForAuthenticatedUser() {
        return $this->likedPosts()->pluck('posts.id')->toArray();
    }

    public function getProfileImageUrlAttribute()
    {
        return $this->profile_image 
                    ? Storage::url($this->profile_image) 
                    : asset('images/istockphoto-1095773552-612x612.jpg');
    }
}
