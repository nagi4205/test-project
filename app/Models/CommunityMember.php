<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class CommunityMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'community_id',
        'user_id',
        'joined_at',
    ];

    public $timestamps = false;

    public static function currentTimestamp() {
        return Carbon::now()->format('Y-m-d H:i:s');
    }
}
