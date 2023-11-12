<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post; // Postモデルを使用する場合
use Illuminate\Support\Facades\File;

class ExamplePostsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    // public function run(): void
    // {
    //     $json = File::get('app/posts_jp.json'); // パスは適切に設定してください
    //     $posts = json_decode($json);

    //     foreach ($posts as $post) {
    //         Post::create([
    //             'user_id' => 1, // ここは適宜変更してください
    //             'content' => $post->content,
    //             "latitude" => 35.702,
    //             "longitude" => 139.774
    //         ]);
    //     }
    // }

    public function run(): void
    {
        Post::create([
            'user_id' => 1, // ここは適宜変更してください
            'content' => 'こんにちは！',
            "latitude" => -22.906,
            "longitude" => -178.173
        ]);
    }
}
