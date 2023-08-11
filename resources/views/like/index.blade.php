<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          お気に入りした投稿
      </h2>
  </x-slot>

  <div class="flex flex-row">
    <div class="w-full lg:w-2/3 bg-gray-200">
    
      <div class="mx-auto px-6">
          @if(session('message'))
            <div class="text-red-600 font-bold">
              {{session('message')}}
            </div>
          @endif


          
          @foreach($likedPosts as $likedPost)
            <div class="mt-4 p-8 bg-white w-full rounded-2xl">
              {{-- ここに画像を表示 --}}
              @isset($likedPost->image)
                <img src="{{ Storage::url($likedPost->image) }}" >
              @endisset
              <h1 class="p-4 text-lg font-semibold">
                件名：
                {{-- <a href="{{route('post.show', $post)}}" class="text-blue-600"> --}}
                  {{$likedPost->title}}
                </a>
              </h1>
              <hr class="w-full">
              <p class="mt-4 p-4">
                {{$likedPost->content}}
              </p>
              <div class="p-4 text-sm font-semibold">
                <p>
                  {{-- 　PostモデルとUserモデルを関連付けている↓ --}}
                  {{$likedPost->created_at}} / {{$likedPost->user->name??'Unknown'}} / {{$likedPost->id}}
                </p>

                  {{-- <p>
                  <!-- お気に入り追加/削除ボタン -->
                  <form method="POST" action="{{ route('like', $post) }}">
                      @csrf
                      <button type="submit">
                          @if(auth()->check() && auth()->user()->likes()->where('post_id', $post->id)->exists())
                              お気に入りから削除
                          @else
                              お気に入りに追加
                          @endif
                      </button>
                  </form>
                </p>
              --}}
              <p>
                <form method="POST" action="{{ route('likes.store') }}">
                  @csrf
                  <input type="hidden" name="post_id" value="{{ $likedPost->id }}">
                  <button type="submit" class="mt-8 hover:opacity-75">
                      @if(auth()->check() && auth()->user()->likedPosts()->where('post_id', $likedPost->id)->exists())
                          <i class="fas fa-heart"></i>
                      @else
                          <i class="far fa-heart"></i> 
                      @endif
                      <span class="mx-2">{{$likedPost->likedby->count()}}</span>
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

    </div>

    <div class="w-full lg:w-1/3 bg-gray-300">
      ここはPCだと2カラムの右側、スマホだと1カラムになります
    </div>
    
  </div>
</x-app-layout>
