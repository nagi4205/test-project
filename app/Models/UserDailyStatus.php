<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDailyStatus extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'attendance', 'mood_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function attendance()
    {
        return $this->belongsTo(Attendance::class);
    }

    public function mood()
    {
        return $this->belongsTo(Mood::class);
    }
}
