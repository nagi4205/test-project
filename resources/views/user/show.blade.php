<x-app-layout>
  <x-slot name="header">
      <h2 class="flex justify-end font-semibold text-xl text-gray-800 leading-tight">
          {{ $user->name }}
      </h2>
  </x-slot>

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
      @if($ViewingOwnProfile)
        <a href="{{ route('profile.edit') }}" class="primary-button">
          <button class="py-3 px-4 inline-flex justify-center items-center gap-2 rounded-full border border-transparent font-semibold text-indigo-500 hover:bg-indigo-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all text-sm dark:focus:ring-offset-gray-800">
            プロフィール編集
          </button>
        </a>
      @else
        @if($alreadyFollowing)
          <form action="{{ route('follows.unfollow', ['user' => $user->id]) }}" method="POST">
            @csrf
            @method('delete')
            <x-primary-button type="submit">
              フォロー解除
            </x-primary-button>
          </form>
        @elseif($alreadyRejected)
          <x-primary-button>
            拒否されました
          </x-primary-button>
        @else
          <form action="{{ route('follows.createFollowRequestJob') }}" method="POST">
            @csrf
            <input type="hidden" name="user_id" value="{{ $user->id }}">
            <x-primary-button type="submit">
              フォロー申請を送る
            </x-primary-button>
          </form>
        @endif
      @endif
    </div>
  </div>

  <div class="flex ml-4 gap-x-8">
    <a href="{{ route('user.followings', ['user' => $user->id]) }}">
      <p>フォロー中{{ $followingsCount }}</p>
    </a>
    <a href="{{ route('user.followers', ['user' => $user->id]) }}">
      <p>フォロワー{{ $followersCount }}</p>
    </a>
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
