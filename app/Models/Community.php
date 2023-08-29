<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Community extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'status',
        'owner_id',
    ];

    public function communityMembers() {
        return $this->belongsToMany(User::class, 'community_members', 'community_id', 'user_id');
    }

    public function communityPosts() {
        return $this->hasMany(CommunityPost::class);
    }
}
