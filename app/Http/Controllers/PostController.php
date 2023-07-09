<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Post;
use App\Models\Tag;
// notificationResponseモデル
use App\Models\NotificationResponse;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function post()
    {
        //
    }

    // public function index()
    // {
    //     //ここで初めて$postsを定義
    //     //postsテーブルのデータを取得
    //     //EloquentORMを使って条件にあったデータを抽出する方法。where句を使う。
    //     //モデル名：：where('条件をつけるカラム', ’条件’)->get(); じゅんこ本P.228
    //     // $posts=Post::where('user_id', auth()->id())->get();
    //     // ページネーションバージョン↓
    //     // $posts=Post::where('user_id', auth()->id())->paginate(10);
    //     $posts=Post::paginate(15);
    //     //compact関数で変数$postsを受け渡す
    //     return view('post.index', compact('posts'));
    // }

    // PostsController.php (コントローラ)
    public function index(Request $request)
    {
        if($request->has(['latitude', 'longitude', 'radius'])) {
            $lat = $request->latitude;
            $lng = $request->longitude;
            $radius = $request->radius;
            $posts = Post::withinDistance($lat, $lng, $radius)->get();
        } else {
            $posts = Post::all(); // or any default set of posts
        }
        return view('post.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tags = Tag::all();
        return view('post.create', compact('tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required | max:20',
            'content' => 'required | max:400',
            'image' => 'nullable | max:2048 | mimes:jpg,jpeg,png,gif',
            'latitude' => 'nullable | numeric',
            'longitude' => 'nullable | numeric',
            'tag' => 'required | exists:tags,id',
        ]);

        $image = $request->file('image');

        //画像がアップロードされていればstrageに保存
        if ($request->hasFile('image')) {
            // 現在の年月日を取得してYmdフォーマットに変換
            $currentDateTime = now()->format('Ymd');
            // Get the original file name and append the current date and time
            $filename = $currentDateTime.'_'.$request->file('image')->getClientOriginalName();
            // Store the image with the new file name
            $path = $request->file('image')->storePubliclyAs('images', $filename);
            // Update the 'image' attribute in the validated data
            $validated['image'] = $path;
        } else {
            $path = null;
        }

        $validated['user_id'] = auth()->id();

        $post = Post::create($validated);
        $post->tags()->attach($request->tag);  

        return back()->with('message', '投稿を保存しました！');
    }



    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $comments = $post->comments;
        return view('post.show', compact('post', 'comments'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return view('post.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required | max:20',
            'content' => 'required | max:400',
        ]);

        $validated['user_id'] = auth()->id();

        $post->update($validated);

        $request->session()->flash('message', '更新しました！');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Post $post)
    {
        DB::transaction(function () use ($request, $post) {
            $post->comments()->delete();
            $post->delete();
            $request->session()->flash('message', '削除しました！');
        });
    
        return redirect()->route('post.index');
    }

    public function search()
    {
        return view('post.search');
    }

    public function api()
    {
        return view('post.api');
    }

    public function currentLocation(Request $request)
    {
        $lat = $request->lat;
        $lng = $request->lng;
        // currentLocationで表示
        return view('post.currentLocation', [
            // 現在地緯度latをbladeへ渡す
            'lat' => $lat,
            // 現在地経度lngをbladeへ渡す
            'lng' => $lng,
        ]);
    }

    // public function count()
    // {
    //     $users = User::withCount(['notificationResponse' => function($query) {
    //         $query->where('response', 'Yes');
    //     }])->get();

    //     echo "あなたの出勤日数は".$users[0]->notification_response_count."日です。";
    // }

    public function count()
    {
        $user = auth()->user();

        $attendanceCount = $user->notificationResponse()->where('response', 'Yes')->count();

        echo "あなたの出勤日数は".$attendanceCount."日です。";
    }
}



