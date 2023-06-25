<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            フォーム
        </h2>
    </x-slot>

    <div class="mx-w-7xl mx-auto px-6">
        {{-- @if(session('message'))
            <div class="text-red-600 font-bold">
                {{ session('message') }}
            </div>
        @endif --}}
        <x-message :message="session('message')" />
        
        <form method="post" action="{{ route('post.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="mt-8">
                <div class="w-full flex flex-col">
                    <label for="title" class="font-semibold mt-4">件名</label>
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    <input type="text" name="title" class="w-auto py-2 border border-gray-300 rounded-md" id="title" value="{{old('title')}}"> 
                </div>
            </div>
            
            <div class="w-full flex flex-col">
                <label for="content" class="font-semibold mt-4">本文</label>
                <x-input-error :messages="$errors->get('content')" class="mt-2" />
                <textarea name="content" class="w-auto py-2 border border-gray-300 rounded-md" id="content" cols="30" rows="5">
                    {{old('content')}}
                </textarea>
            </div>

            <div class="w-full flex flex-col">
                <label for="image" class="font-semibold mt-4">画像登録</label>
                <input type="file" class="form-control-file" name="image" id="image" >
            </div>

            {{-- 位置情報をコントローラに渡す --}}
            <input type="hidden" id="latitude" name="latitude">
            <input type="hidden" id="longitude" name="longitude">

            <x-primary-button class="mt-8 hover:opacity-75">
                送信する
            </x-primary-button>
        </form>

        <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
        <script src="{{ asset('/js/setLocation.js') }}"></script>
        <script src="https://maps.googleapis.com/maps/api/js?language=ja&region=JP&key=AIzaSyDLm3FiiHj5SL12ki1Nigf2P9i9irwpXZU&callback=initMap" async defer></script>
    </div>
    
</x-app-layout>
