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
        'community_image',
        'latitude',
        'longitude',
        'location_name',
        'owner_id',
    ];

    public function communityMembers() {
        return $this->belongsToMany(User::class, 'community_members', 'community_id', 'user_id');
    }

    public function communityPosts() {
        return $this->hasMany(CommunityPost::class);
    }

    public function scopeWithinEasyDistance($query, $lat, $lng, $radius = 3) {
        $latDelta = $radius / 111;
        $lngDelta = $radius / (111 * cos(deg2rad($lat)));
    
        $minLat = $lat - $latDelta;
        $maxLat = $lat + $latDelta;
        $minLng = $lng - $lngDelta;
        $maxLng = $lng + $lngDelta;
    
        $query->whereBetween('latitude', [$minLat, $maxLat])
              ->whereBetween('longitude', [$minLng, $maxLng]);
    }
}
