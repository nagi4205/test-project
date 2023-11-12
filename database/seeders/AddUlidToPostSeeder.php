<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Post;

class AddUlidToPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Post::all()->each(function ($post) {
            do {
                $ulid = (string) Str::ulid();
            } while (Post::where('ulid', $ulid)->exists());

            $post->ulid = $ulid;
            $post->save();
        });
    }
}
