<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\CommunityMember;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommunityMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $communityId = fgets(STDIN);

        $users = User::factory(5)->create();

        foreach($users as $user) {
            CommunityMember::create([
                'community_id' => $communityId,
                'user_id' => $user->id,
                'joined_at' => now(),
            ]);
        }
    }
}
