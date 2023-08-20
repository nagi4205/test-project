{{-- <div class="w-full lg:w-2/3 bg-gray-200"> --}}
<div class="w-full lg:w-2/3">
@foreach($filteredPosts as $post)
  @if($post->parent_id)
    @include('post.components.parent-post-index')
  @endif
  <div class="mt-4 p-4 w-full rounded-2xl @if($post->parent_id) ml-8 @endif">
    {{--  --}}
    <div class="flex">
      <div class="pl-0 lg:pl-0 xl:pl-0 pr-6 py-3 flex-grow">
        @if($post->user)
          <a href="{{ route('user.show', ['user' => $post->user->id]) }}" class="inline-block">
            <div class="flex items-center gap-x-4">
              @isset($post->user->profile_image)
              <img class="inline-block h-[2.375rem] w-[2.375rem] rounded-full" src="{{ Storage::url($post->user->profile_image) }}" alt="Image Description">
              @endisset
              <div class="grow">
                <span class="block text-sm font-semibold text-gray-800 dark:text-gray-200">{{ $post->user->name }}</span>
                <span class="block text-sm font-semibold text-gray-900 dark:text-white">{{ $post->user->name }}</span>
                <span class="block text-sm text-gray-500">{{ $post->user->email }}</span>
              </div>
            </div>
          </a>
        @else
          <div class="flex items-center gap-x-4">
            <img class="inline-block h-[2.375rem] w-[2.375rem] rounded-full" src="images/default_unspecified.jpeg" alt="Image Description">
            <div class="grow">
              <span class="block text-sm font-semibold text-gray-800 dark:text-gray-200">Deleted User</span>
              <span class="block text-sm text-gray-500">DeletedUser@gmail.com</span>
            </div>
          </div>
        @endif
      </div>
      {{--  --}}

      <div class="px-6 py-1.5">
        <div class="hs-dropdown relative inline-block [--placement:bottom-right]">
          <button id="hs-table-dropdown-2" type="button" class="hs-dropdown-toggle py-1.5 px-2 inline-flex justify-center items-center gap-2 rounded-md text-gray-700 align-middle focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-blue-600 transition-all text-sm dark:text-gray-400 dark:hover:text-white dark:focus:ring-offset-gray-800">
            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
              <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"/>
            </svg>
          </button>
          <div class="hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 hidden mt-2 divide-y divide-gray-200 min-w-[10rem] z-10 bg-white shadow-2xl rounded-lg p-2 mt-2 dark:divide-gray-700 dark:bg-gray-800 dark:border dark:border-gray-700" aria-labelledby="hs-table-dropdown-2">
            <div class="py-2 first:pt-0 last:pb-0">
              <a class="flex items-center gap-x-3 py-2 px-3 rounded-md text-sm text-gray-800 hover:bg-gray-100 focus:ring-2 focus:ring-blue-500 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300" href="#">
                編集する
              </a>
              <a class="flex items-center gap-x-3 py-2 px-3 rounded-md text-sm text-gray-800 hover:bg-gray-100 focus:ring-2 focus:ring-blue-500 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300" href="#">
                Regenrate Key
              </a>
              <a class="flex items-center gap-x-3 py-2 px-3 rounded-md text-sm text-gray-800 hover:bg-gray-100 focus:ring-2 focus:ring-blue-500 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300" href="#">
                Disable
              </a>
            </div>
            @can('delete', $post)
              <div class="py-2 first:pt-0 last:pb-0">
                <form method="post" action="{{ route('posts.destroy', $post) }}" class="flex items-center gap-x-3 py-2 px-3 rounded-md text-sm text-red-600 hover:bg-gray-100 focus:ring-2 focus:ring-blue-500 dark:text-red-500 dark:hover:bg-gray-700">
                  @csrf
                  @method('delete')
                  <button>
                    投稿を削除
                  </button>
                </form>
              </div>
            @endcan
          </div>
        </div>
      </div>
    </div>
    {{--  --}}
    @isset($post->image)
      <img src="{{ Storage::url($post->image) }}" >
    @endisset
    <p class="text-gray-600 dark:text-gray-400">
      {{$post->content}}
    </p>
    <div class="p-4 text-sm font-semibold">
      <p>
        {{$post->location_name}} / {{$post->created_at}}
      </p>
      <p>
        @foreach($post->tags as $tag)
          {{$tag->name}}
        @endforeach
      </p>

      {{-- <p>
        @if(auth()->check() && auth()->user()->likes()->where('post_id', $post->id)->exists())
        <!-- お気に入り削除ボタン -->
        <form method="POST" action="{{ route('favorites.remove', $post) }}">
            @csrf
            <button type="submit">お気に入りから削除</button>
        </form>
        @else
        <!-- お気に入り追加ボタン -->
        <form method="POST" action="{{ route('favorites.add', $post) }}">
            @csrf
            <button type="submit">お気に入りに追加</button>
        </form>
        @endif
      </p> --}}
      <div class="flex gap-x-4 pt-4">
        <a href="{{ route('posts.create', ['parent_id' => $post->id])}}" class="flex items-center w-12 h-4">
          <i class="fa-regular fa-comment-dots"></i>
          @if($post->children->count())
            <span class="mx-2">{{ $post->children->count() }}</span>
          @endif
        </a>
        <form method="POST" action="{{ route('likes.store') }}" class="flex items-center justify-between w-12 h-4 like-form">
          @csrf
          <input type="hidden" name="post_id" value="{{ $post->id }}">
          <button type="button" class="hover:opacity-75 like-button">
            @if($post->hasLiked)
              <i class="fas fa-heart"></i>
            @else
              <i class="far fa-heart"></i> 
            @endif
            <span class="mx-2 like-count">{{$post->likedby->count()}}</span>
          </button>
        </form>
      </div>
    </div>
  </div>
  <hr class="w-full">
@endforeach
</div>