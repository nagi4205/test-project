<x-app-layout>
  {{-- <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          一覧表示
      </h2>
  </x-slot> --}}


  <div class="bg-gray-50 dark:bg-slate-900">
    <div class="mx-auto">
        @if(session('message'))
          <div class="text-red-600 font-bold">
            {{session('message')}}
          </div>
        @endif
        @foreach($posts as $post)

          <div class="mt-4 p-4 w-full rounded-2xl">

            <div class="flex">

              <div class="pl-6 lg:pl-3 xl:pl-0 pr-6 py-3 flex-grow">
                @if($post->user)
                  <a href="{{ route('user.show', ['user' => $post->user->id]) }}" class="inline-block">
                    <div class="flex items-center gap-x-4">
                      @isset($post->user->profile_image)
                      <img class="inline-block h-[2.375rem] w-[2.375rem] rounded-full" src="{{ Storage::url($post->user->profile_image) }}" alt="Image Description">
                      @endisset
                      <div class="grow">
                        <span class="block text-sm font-semibold text-gray-800 dark:text-gray-200">{{ $post->user->name }}</span>
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

              <div class="justify-end px-4 pt-4">
                <button id="dropdownButton" data-dropdown-toggle="dropdown" class="inline-block text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-1.5" type="button">
                    <span class="sr-only">Open dropdown</span>
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 3">
                        <path d="M2 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm6.041 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM14 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Z"/>
                    </svg>
                </button>
                <!-- Dropdown menu -->
                <div id="dropdown" class="z-10 hidden text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                    <ul class="py-2" aria-labelledby="dropdownButton">
                    <li>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Edit</a>
                    </li>
                    <li>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Export Data</a>
                    </li>
                    <li>
                        <a href="#" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Delete</a>
                    </li>
                    </ul>
                </div>
              </div>

            </div>

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
                {{$post->created_at}}
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
  </div>
</x-app-layout>
