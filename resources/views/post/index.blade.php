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
          {{-- <img src="{{'/storage'. $post{'image'}}}" /> --}}
          <img src="{{ asset('storage/' .$post->image) }}" >
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
              {{-- 　PostモデルとUserモデルを関連付けている↓ --}}
              {{$post->created_at}} / {{$post->user->name??'Unknown'}}
            </p>
          </div>
        </div>
      @endforeach
      <div class="mb-4">
        {{ $posts->links() }}
      </div>
  </div>
</x-app-layout>