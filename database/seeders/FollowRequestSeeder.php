<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Jobs\SendFollowRequestNotificationJob;
use Illuminate\Database\Seeder;
use App\Models\Follow;
use App\Models\User;

class FollowRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $targetUserId = 131;
        $users = User::where('id', '<>', $targetUserId)->get();

        foreach ($users as $user) {
            Follow::create([
                'follower_id' => $user->id,
                'followee_id' => $targetUserId,
                'status' => 'pending',
            ]);  

            dispatch(new SendFollowRequestNotificationJob($user->id, $targetUserId));
        }
    }
}
