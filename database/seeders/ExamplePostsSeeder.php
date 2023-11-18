<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post; // Postモデルを使用する場合
use App\Models\User;
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


    // textの改行機能について深掘り
    public function run(): void
    {
        $json = File::get('app/posts_jp.json'); // パスは適切に設定してください
        $posts = json_decode($json, true);

        $users = User::all();
        foreach($users as $user) {
            $randomPost = $posts[array_rand($posts)];

            Post::create([
                'user_id' => $user->id, // ここは適宜変更してください
                'content' => $randomPost['content'],
                "latitude" => 35.625,
                "longitude" => 139.722
            ]);
        }
    }
}
