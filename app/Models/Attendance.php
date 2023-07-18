<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = ['attendance'];

    public function userDailyStatuses()
    {
        return $this->hasMany(UserDailyStatus::class);
    }
}
