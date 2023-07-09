<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            コメント編集
        </h2>
    </x-slot>

    <div class="mx-w-7xl mx-auto px-6">
        @if(session('message'))
            <div class="text-red-600 font-bold">
                {{ session('message') }}
            </div>
        @endif
        <form method="post" action="{{ route('post.comment.update', ['post' => $post->id, 'comment' => $comment->id]) }}">
            @csrf
            @method('patch')
            <div class="w-full flex flex-col">
                <label for="content" class="font-semibold mt-4">本文</label>
                <x-input-error :messages="$errors->get('content')" class="mt-2" />
                <textarea name="content" class="w-auto py-2 border border-gray-300 rounded-md" id="content" cols="30" rows="5">{{old('content', $comment->content)}}</textarea>
            </div>

            <x-primary-button class="mt-4 hover:opacity-75">
                送信する
            </x-primary-button>
        </form>
    </div>
</x-app-layout>
