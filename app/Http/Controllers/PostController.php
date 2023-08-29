<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Support\Facades\Gate;

// notificationResponseモデル
use App\Models\NotificationResponse;


class PostController extends Controller
{
    // public function fetchposts(Request $request)
    // {
    //     if($request->has(['latitude', 'longitude', 'radius'])) {
    //     $lat = $request->input('latitude');
    //     $lng = $request->input('longitude');
    //     $radius = $request->input('radius');
    //     $filteredPosts = Post::with('user')->withinDistance($lat, $lng, $radius)->get();

    //     if(auth()->check()){
    //         $user = auth()->user();
    //         $likedPostIds = $user->likedPosts()->pluck('posts.id')->toArray();

    //         foreach ($filteredPosts as $post) {
    //             $post->hasLiked = in_array($post->id, $likedPostIds);
    //         }
    //     } else {
    //         foreach ($filteredPosts as $post) {
    //             $post->hasLiked = false;
    //         }
    //     }
     
    //     return view('post.components.componentForIndex', compact('filteredPosts'));
    //     } else {
    //     }
    // }


    public function index(Request $request)
    {
        // リクエストに何も含まれていない場合
        if (!$request->hasAny(['latitude', 'longitude', 'radius', 'fetchFollowingPosts'])) {
            return view('post.index');
        }
    
        if ($request->has(['latitude', 'longitude', 'radius'])) {

            $lat = $request->input('latitude');
            $lng = $request->input('longitude');
            $radius = $request->input('radius');
            $filteredPosts = Post::with('user')
                                 ->withinEasyDistance($lat, $lng, $radius)
                                 ->orderBy('created_at', 'desc')
                                 ->get();
            Log::info("位置情報でソート");

        } elseif ($request->has('fetchFollowingPosts')) {

            $user = auth()->user();
            $followingIds = $user->followingUsers()->pluck('users.id');
            $filteredPosts = Post::whereIn('user_id', $followingIds)->with('user')->get();
            Log::info("フォロワーでソート");
        }

        if (auth()->check()) {
            $user = auth()->user();
            $likedPostIds = $user->likedPosts()->pluck('posts.id')->toArray();

            foreach ($filteredPosts as $post) {

                if($post->parent_id) {
                    $post->parent->hasLiked = in_array($post->parent->id, $likedPostIds);
                }

                $post->hasLiked = in_array($post->id, $likedPostIds);
            }
        } else {
            foreach ($filteredPosts as $post) {
                $post->hasLiked = false;
            }
        }
        
        return view('post.components.componentForIndex', compact('filteredPosts'));
        // return view('post.components.componentForIndex', compact('posts'))->render();
    }

    public function index2(Request $request)
    {
        // Log::info('Latitude:'.$request->input('latitude'));
        // Log::info("さてやってまいりました");
        // Log::info('All request data:', $request->all());
        // dd($request);
        if($request->has(['latitude', 'longitude', 'radius'])) {
            $lat = $request->latitude;
            $lng = $request->longitude;
            $radius = $request->radius;
            $posts = Post::with('user')->withinDistance($lat, $lng, $radius)->get();
        } else {
            // $posts = Post::with('user')->get();
        }

        // if(auth()->check()){
        //     $user = auth()->user();
        //     $likedPostIds = $user->likedPosts()->pluck('posts.id')->toArray();

        //     foreach ($posts as $post) {
        //         $post->hasLiked = in_array($post->id, $likedPostIds);
        //     }
        // } else {
        //     foreach ($posts as $post) {
        //         $post->hasLiked = false;
        //     }
        // }

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

        if (isset($validated['parent_id'])) {
            $parentPost = Post::find($validated['parent_id']);
    
            if (!$parentPost) {
                return back()->withErrors(['message' => '親の投稿が見つかりません。']);
            }
    
            $currentUser = auth()->user();
    
            if ($parentPost->user_id !== $currentUser->id || !$currentUser->FollowingUsers()->wherePivot('status', 'approved')->exists()) {
                $isWithinDistance = Post::where('id', $parentPost->id)
                                        ->withinEasyDistance($request->latitude, $request->longitude)
                                        ->exists();
                if (!$isWithinDistance) {
                    return back()->withErrors(['message' => 'この投稿への返信は許可されていません。']);
                }
            }

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

            // SendRepliedPostNotificationJob::dispatch();
    
            return back()->with('message', '投稿を保存しました！');
        }

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
    
        return redirect()->route('posts.index');
    }
}



