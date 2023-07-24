<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Article;
use Illuminate\Support\Carbon;


class ArticlesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $articles = [
            ['title' => '家でできる気分転換', 'content' => 'This is article 1', 'created_at' => $now, 'updated_at' => $now],
            ['title' => '休日のおすすめスポット', 'content' => 'This is article 2', 'created_at' => $now, 'updated_at' => $now],
            ['title' => '変わったマイブーム', 'content' => 'This is article 3', 'created_at' => $now, 'updated_at' => $now],
            ['title' => '料理でもどうでしょう', 'content' => 'This is article 4', 'created_at' => $now, 'updated_at' => $now],
            ['title' => 'おすすめサンドバッグ', 'content' => 'This is article 5', 'created_at' => $now, 'updated_at' => $now],
        ];
        
        foreach($articles as $article) {
            Article::create($article);
        }
    }
}
