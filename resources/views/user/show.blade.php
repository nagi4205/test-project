<x-app-layout>
  {{-- <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ $user->name }}
      </h2>
  </x-slot> --}}

  @if(session('message'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
        <span class="block sm:inline">
            {{ session('message') }}
        </span>
    </div>
  @endif

  <div class="flex">
    <div class="mt-4 p-4 w-full rounded-2xl">
      <div class="pl-6 lg:pl-3 xl:pl-0 pr-6 py-3">
        <div class="flex items-center gap-x-4">
          @isset($user->profile_image)
          <img class="inline-block h-[2.375rem] w-[2.375rem] rounded-full" src="{{ Storage::url($user->profile_image) }}" alt="Image Description">
          @endisset
          <div class="grow">
            <span class="block text-sm font-semibold text-gray-800 dark:text-gray-200">{{ $user->name }}</span>
            <span class="block text-sm text-gray-500">{{ $user->email }}</span>
          </div>
        </div>
      </div>
    </div>

    <div class="mt-8">
      <form action="{{ route('follows.store') }}" method="POST">
        @csrf
        <input type="hidden" name="user_id" value="{{ $user->id }}">
        @if($alreadyFollowing)
          <x-primary-button type="submit">
            フォローしています
          </x-primary-button>
        @else
          <x-primary-button type="submit">
            フォローする
          </x-primary-button>
        @endif
      </form>
    </div>
  </div>

  {{-- <p>
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
  </p> --}}

  @foreach($user->posts as $post)
    <div class="mt-4 p-4 w-full rounded-2xl">
      @isset($post->image)
      <div class="w-1/2">
        <img src="{{ Storage::url($post->image) }}" >
      </div>
      @endisset
      <h1 class="p-4 text-lg font-semibold">
        件名：
        <a href="{{route('post.show', $post)}}" class="text-blue-600">
          {{$post->title}}
        </a>
      </h1>
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
      </div>

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

      <hr class=" mt-4 border-gray-300 dark:border-gray-700" >
    </div>
  @endforeach
</x-app-layout>
