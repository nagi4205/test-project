<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            コメント個別表示
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
                    {{ $comment->title }}
                </h1>
                <div class="text-right flex">
                    <a href="{{route('comment.edit', ['post' => $post->id, 'comment' => $comment->id])}}" class="flex-1">
                        <x-primary-button>
                            編集
                        </x-primary-button>
                    </a>

                    <form method="post" action="{{route('comment.destroy', ['post' => $post->id, 'comment' => $comment->id])}}" class="flex-2">
                        @csrf
                        @method('delete')
                        <x-primary-button class="bg-red-700 ml-2">
                            削除
                        </x-primary-button>
                    </form>
                </div>
                <hr class="w-full">
                <p class="mt-4 whitespace-pre-line">
                    {{ $comment->content }}
                </p>
                <div class="text-sm font-semibold flex flex-row-reverse">
                    <p> {{ $comment->created_at }} </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
