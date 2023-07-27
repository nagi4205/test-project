<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            個別表示
        </h2>
    </x-slot>

    <div class="mx-w-7xl mx-auto px-6">
        @if(session('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">
                    {{ session('message') }}
                </span>
            </div>
        @endif
        <div class="bg-white w-full rounded-2xl">
            <div class="mt-4 p-4">
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
            </div>
        </div>
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
</x-app-layout>
