<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Follow;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserFollowerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::factory(2)->create();

        foreach($users as $user) {
            Follow::create([
                'follower_id' => 109,
                'followee_id' => $user->id,
                'status' => 'approved',
            ]);
        }
    }
}
