<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('tags')->insert([
            ['name' => 'つらい…', 'created_at' => $now, 'updated_at' => $now],
            ['name' => '楽しい！！', 'created_at' => $now, 'updated_at' => $now],
            ['name' => '今日も１日！', 'created_at' => $now, 'updated_at' => $now],
        ]);


    }
}
