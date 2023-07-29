<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Support\Facades\Gate;

// notificationResponseモデル
use App\Models\NotificationResponse;


class PostController extends Controller
{
    public function index(Request $request)
    {
        if($request->has(['latitude', 'longitude', 'radius'])) {
            $lat = $request->latitude;
            $lng = $request->longitude;
            $radius = $request->radius;
            $posts = Post::withinDistance($lat, $lng, $radius)->get();
        } else {
            $posts = Post::all();
        }
        return view('post.index', compact('posts'));
    }

    public function create()
    {
        $tags = Tag::all();
        return view('post.create', compact('tags'));
    }

    public function store(StorePostRequest $request)
    {
        $validated = $request->validated();

        $image = $request->file('image');

        if ($request->hasFile('image')) {
            $currentDateTime = now()->format('Ymd');
            $filename = $currentDateTime.'_'.$request->file('image')->getClientOriginalName();
            $path = $request->file('image')->storePubliclyAs('images', $filename);
            $validated['image'] = $path;
        } else {
            $path = null;
        }

        $validated['user_id'] = auth()->id();

        $post = Post::create($validated);
        $post->tags()->attach($request->tag);

        return back()->with('message', '投稿を保存しました！');
    }

    public function show($id)
    {
        $post = Post::with(['comments' => function ($query) {
            $query->whereNull('parent_id');
        }, 'comments.children'])->find($id);

        return view('post.show', compact('post'));
    }

    public function edit(Post $post)
    {
        $user = Auth::user();
        if($user->id !== $post->user_id) {
            abort(403, 'Unauthorized action.');
        }
        return view('post.edit', compact('post'));
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        $validated = $request->validated();

        $validated['user_id'] = auth()->id();

        $post->update($validated);

        $request->session()->flash('message', '更新しました！');
        return back();
    }

    public function destroy(Request $request, Post $post)
    {
        $this->authorize('delete', $post);

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

        return view('post.currentLocation', [
            'lat' => $lat,
            'lng' => $lng,
        ]);
    }

    public function count()
    {
        $user = auth()->user();

        $attendanceCount = $user->notificationResponse()->where('response', 'Yes')->count();

        echo "あなたの出勤日数は".$attendanceCount."日です。";
    }
}



