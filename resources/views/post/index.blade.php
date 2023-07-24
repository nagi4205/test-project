<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          一覧表示
      </h2>
  </x-slot>

  <div class="mx-auto px-6">
      @if(session('message'))
        <div class="text-red-600 font-bold">
          {{session('message')}}
        </div>
      @endif
      @foreach($posts as $post)
        <div class="mt-4 p-8 bg-white w-full rounded-2xl">
          {{-- ここに画像を表示 --}}
          @isset($post->image)
            <img src="{{ Storage::url($post->image) }}" >
          @endisset
          <h1 class="p-4 text-lg font-semibold">
            件名：
            <a href="{{route('post.show', $post)}}" class="text-blue-600">
              {{$post->title}}
            </a>
          </h1>
          <hr class="w-full">
          <p class="mt-4 p-4">
            {{$post->content}}
          </p>
          <div class="p-4 text-sm font-semibold">
            <p>
              {{$post->created_at}} / {{$post->user->name??'Unknown'}}
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

             <!-- お気に入り追加/削除ボタン -->
            <p>
              <form method="POST" action="{{ route('like', $post) }}">
                @csrf
                <button type="submit" class="mt-8 hover:opacity-75">
                    @if(auth()->check() && auth()->user()->likedPosts()->where('post_id', $post->id)->exists())
                        <i class="fas fa-heart"></i>
                    @else
                        <i class="far fa-heart"></i> 
                    @endif
                    <span class="mx-2">{{$post->likedby->count()}}</span>
                </button>
              </form>
            </p>
          

          </div>
        </div>
      @endforeach
      {{-- <div class="mb-4">
        {{ $posts->links() }}
      </div> --}}
  </div>
</x-app-layout>
