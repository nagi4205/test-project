<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class MoodsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('moods')->insert([
            ['mood' => '晴れ', 'created_at' => $now, 'updated_at' => $now],
            ['mood' => '曇り', 'created_at' => $now, 'updated_at' => $now],
            ['mood' => '雨', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
