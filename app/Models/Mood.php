<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mood extends Model
{
    use HasFactory;

    protected $fillable = ['mood'];

    public function userDailyStatuses()
    {
        return $this->hasMany(UserDailyStatus::class);
    }
}
