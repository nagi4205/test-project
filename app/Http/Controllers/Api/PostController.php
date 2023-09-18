<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Post;
use App\Models\Tag;
use App\Services\PostService;
use App\Services\CommunityService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Support\Facades\Gate;

// notificationResponseモデル
use App\Models\NotificationResponse;

class PostController extends Controller
{
    private $postService;
    private $communityService;

    public function __construct(PostService $postService, CommunityService $communityService)
    {
        $this->postService = $postService;
        $this->communityService = $communityService;
    }


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


    //新index
    private function isEmptyRequest(Request $request): bool
    {
        return !$request->hasAny(['latitude', 'longitude', 'radius', 'fetchFollowingPosts']);
    }

    private function fetchPostsBasedOnRequest(Request $request)
    {
        if($this->isLocationBasedRequest($request)) {
            Log::info('ここまできました。at_fetchPostsBasedOnRequest()');
            return $this->postService->getFilteredPostsByLocation(
                $request->input('latitude'),
                $request->input('longitude'),
                $request->input('radius'),
            );
        }

        if($this->isFollowingPostsRequest($request)) {
            return $this->postService->getFilteredPostsByFollowingUsers();
        }
    }

    private function fetchCommunitiesBasedOnRequest(Request $request)
    {
        Log::info('fetchCommunitiesBasedOnRequestまできました。');
        if($this->isLocationBasedRequest($request)) {
            return $this->communityService->getFilteredCommunitiesByLocation(
                $request->input('latitude'),
                $request->input('longitude'),
                $request->input('radius'),
            );
        }
    }

    private function isLocationBasedRequest(Request $request): bool
    {
        return $request->has(['latitude', 'longitude', 'radius']);
    }

    private function isFollowingPostsRequest(Request $request): bool
    {
        return $request->has('fetchFollowingPosts');
    }

    ///すぐ消す
    public function cat(Request $request)
    {
        $inputCats = $request->all();
        return response()->json([
            'status' => 'true',
            'cat' => $inputCats,
        ]);
    }

    ///すぐ消す
    public function test(Request $request)
    {
        $posts = Post::all();
        return response()->json($posts);
    }

    public function fakeindex(Request $request)
    {
        if ($this->isEmptyRequest($request)) {
            return view('post.index');
        }

        $filteredPosts = $this->fetchPostsBasedOnRequest($request);
        $likedPostIds = auth()->check() ? auth()->user()->getLikedPostIdsForAuthenticatedUser() : [];

        $filteredCommunities =  $this->fetchCommunitiesBasedOnRequest($request);

        Log::info('$filteredPosts:'.json_encode($filteredPosts));
        // Log::info('$filteredCommunities:'.json_encode($filteredCommunities));
        // Log::info('$likedPostIds:'.json_encode($likedPostIds));

        $this->postService->attachLikeStatusToPosts($filteredPosts, $likedPostIds);

        return response()->json(count($filteredPosts));
        // return view('post.components.componentForIndex', compact('filteredPosts', 'filteredCommunities'));
    }

    // ここから正しいindex
    public function index(Request $request)
    {
        $filteredPosts = $this->fetchPostsBasedOnRequest($request);

        // Log::info(first($filteredPosts));
        
        foreach($filteredPosts as $post) {
            $post->image = $post->image ? Storage::url($post->image) : null;
        }

        // Log::info(first($filteredPosts));

        Log::info('ここ:at_before_$likedPostIds');
        $likedPostIds = auth()->check() ? auth()->user()->getLikedPostIdsForAuthenticatedUser() : [];

        $filteredCommunities =  $this->fetchCommunitiesBasedOnRequest($request);

        Log::info('$filteredPosts:'.json_encode($filteredPosts));
        // Log::info('$filteredCommunities:'.json_encode($filteredCommunities));
        // Log::info('$likedPostIds:'.json_encode($likedPostIds));

        Log::info('ここ:at_before_$this->postService->attachLikeStatusToPosts');
        $this->postService->attachLikeStatusToPosts($filteredPosts, $likedPostIds);

        return response()->json($filteredPosts);
        // return view('post.components.componentForIndex', compact('filteredPosts', 'filteredCommunities'));
    }

///旧index
    // public function index(Request $request)
    // {
    //     // リクエストに何も含まれていない場合
    //     if (!$request->hasAny(['latitude', 'longitude', 'radius', 'fetchFollowingPosts'])) {
    //         return view('post.index');
    //     }
    
    //     if ($request->has(['latitude', 'longitude', 'radius'])) {

    //         $lat = $request->input('latitude');
    //         $lng = $request->input('longitude');
    //         $radius = $request->input('radius');
    //         $filteredPosts = Post::with('user')
    //                              ->withinEasyDistance($lat, $lng, $radius)
    //                              ->orderBy('created_at', 'desc')
    //                              ->get();

    //     } elseif ($request->has('fetchFollowingPosts')) {

    //         $user = auth()->user();
    //         $followingIds = $user->followingUsers()->pluck('users.id');
    //         $filteredPosts = Post::whereIn('user_id', $followingIds)->with('user')->get();
    //     }

    //     if (auth()->check()) {
    //         $user = auth()->user();
    //         $likedPostIds = $user->likedPosts()->pluck('posts.id')->toArray();

    //         foreach ($filteredPosts as $post) {

    //             if($post->parent_id) {
    //                 $post->parent->hasLiked = in_array($post->parent->id, $likedPostIds);
    //             }

    //             $post->hasLiked = in_array($post->id, $likedPostIds);
    //         }
    //     } else {
    //         foreach ($filteredPosts as $post) {
    //             $post->hasLiked = false;
    //         }
    //     }

    //     return view('post.components.componentForIndex', compact('filteredPosts'));
    //     // return view('post.components.componentForIndex', compact('posts'))->render();
    // }

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