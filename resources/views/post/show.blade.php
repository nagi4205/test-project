<x-app-layout>
    <div class="w-full lg:w-2/3">
        <div class="mx-w-7xl mx-auto px-6">
            @if(session('message'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">
                        {{ session('message') }}
                    </span>
                </div>
            @endif
            <div class="flex">
                <div class="pl-0 lg:pl-0 xl:pl-0 pr-6 py-3 flex-grow">
                  @if($post->user)
                    <a href="{{ route('user.show', ['user' => $post->user->id]) }}" class="inline-block">
                      <div class="flex items-center gap-x-4">
                        @isset($post->user->profile_image)
                        <img class="inline-block h-[2.375rem] w-[2.375rem] rounded-full" src="{{ Storage::url($post->user->profile_image) }}" alt="Image Description">
                        @endisset
                        <div class="grow">
                          {{-- <span class="block text-sm font-semibold text-gray-800 dark:text-gray-200">{{ $post->user->name }}</span> --}}
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
            {{-- <div class="bg-white w-full rounded-2xl"> --}}
                    <h1 class="text-lg font-semibold">
                        {{ $post->title }}
                    </h1>
                    <div class="flex justify-end">
                        @can('update', $post)
                            <a href="{{route('post.edit', $post)}}">
                                <x-primary-button>
                                    編集
                                </x-primary-button>
                            </a>
                        @endcan
                        @can('delete', $post)
                            <form method="post" action="{{route('post.destroy', $post)}}">
                                @csrf
                                @method('delete')
                                <x-primary-button class="bg-red-700 ml-2">
                                    削除
                                </x-primary-button>
                            </form>
                        @endcan
                        <a href="{{ route('post.comment.create', $post) }}">
                            <x-primary-button class="ml-2">
                                コメントする
                            </x-primary-button>
                        </a>
                    </div>
                    <hr class="w-full">
                    <div class="mt-4 p-8">
                        @isset($post->image)
                            <img src="{{ Storage::url($post->image) }}" >
                        @endisset
                        <p class="mt-4 whitespace-pre-line">
                            {{ $post->content }}
                        </p>
                        <div class="text-sm font-semibold flex flex-row-reverse">
                            <p>
                                {{ $post->created_at }}
                            </p>
                        </div>
                    </div>
            {{-- </div> --}}
        </div>
    
        @foreach($post->comments as $comment)
            <div class="mx-w-7xl mx-auto px-6">
                <div class="bg-white w-full rounded-2xl">
                    <div class="mt-4 p-4">
                        <h1 class="text-lg font-semibold">
                            {{ $comment->title }}
                        </h1>
                        <div class="text-right flex">
                            @can('reply', $comment)
                                <a href="{{route('comment.reply.create', $comment)}}">
                                    <x-primary-button class="bg-green-700 ml-2">
                                        返信
                                    </x-primary-button>
                                </a>
                            @endcan
                            @can('update', $comment)
                                <a href="{{route('post.comment.edit', ['post' => $post->id, 'comment' => $comment->id])}}" class="flex-1">
                                    <x-primary-button>
                                        編集
                                    </x-primary-button>
                                </a>
                            @endcan
                            @can('delete', $comment)
                                <form method="post" action="{{route('post.comment.destroy', ['post' => $post->id, 'comment' => $comment->id])}}" class="flex-2">
                                    @csrf
                                    @method('delete')
                                    <x-primary-button class="bg-red-700 ml-2">
                                        削除
                                    </x-primary-button>
                                </form>
                            @endcan
                        </div>
                        <hr class="w-full">
                        <p class="mt-4 whitespace-pre-line">
                            {{ $comment->content }} / {{ $comment->user->name }}
                        </p>
                        <div class="text-sm font-semibold flex flex-row-reverse">
                            <p>
                                {{ $comment->created_at }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            @foreach($comment->children as $child_comment)
                <div class="mx-w-7xl mx-auto px-6 ml-12">
                    <div class="bg-white w-full rounded-2xl">
                        <div class="mt-4 p-4">
                            <div class="text-right flex">
                                @can('update', $child_comment)
                                    <a href="{{route('post.comment.edit', ['post' => $post->id, 'comment' => $child_comment->id])}}" class="flex1">
                                        <x-primary-button>
                                            編集
                                        </x-primary-button>
                                    </a>
                                @endcan
                                @can('delete', $child_comment)
                                    <form method="post" action="{{route('post.comment.destroy', ['post' => $post->id, 'comment' => $child_comment->id])}}" class="flex2">
                                        @csrf
                                        @method('delete')
                                        <x-primary-button class="bg-red-700 ml-2">
                                            削除
                                        </x-primary-button>
                                    </form>
                                @endcan
                            </div>
                            <div cless="mt-2 whitespace-pre-line">
                                {{ $child_comment->content}} / {{ $child_comment->user->name}}
                            </div>
                            <div class="text-sm font-semibold flex flex-row-reverse">
                                <p>
                                    {{ $child_comment->created_at }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endforeach
    </div>
    
</x-app-layout>
