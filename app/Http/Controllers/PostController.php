<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function post()
    {
        //
    }

    public function index()
    {
        //ここで初めて$postsを定義
        //postsテーブルのデータを取得
        //EloquentORMを使って条件にあったデータを抽出する方法。where句を使う。
        //モデル名：：where('条件をつけるカラム', ’条件’)->get(); じゅんこ本P.228
        // $posts=Post::where('user_id', auth()->id())->get();
        $posts=Post::where('user_id', auth()->id())->paginate(10);
        //$posts=Post::paginate(20);
        //compact関数で変数$postsを受け渡す
        return view('post.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('post.create');
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

        return back()->with('message', '投稿を保存しました！');
    }



    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $post=Post::find($id);
        return view('post.show', compact('post'));
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

        $request->session()->flash('message', '保存しました！');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Post $post)
    {
        $post->delete();
        $request->session()->flash('message', '削除しました！');
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
}


