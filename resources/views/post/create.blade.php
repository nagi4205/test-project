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
        
        <form method="post" action="{{ route('posts.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="w-full flex flex-col">
                <label for="tag" class="font-semibold mt-4">タグ</label>
                <select name="tag" id="tag">
                    @foreach($tags as $tag)
                        <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                    @endforeach
                </select>
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

            <input type="hidden" id="latitude" name="latitude">
            <input type="hidden" id="longitude" name="longitude">
            <input type="hidden" id="location_name" name="location_name">
            @if(request('parent_id'))
                <input type="hidden" name="parent_id" value="{{ request('parent_id') }}">
            @endif

            <div class="mt-2">
                <li class="flex space-x-3" id="locationStatus">
                    <svg class="flex-shrink-0 h-6 w-6 text-green-300" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15.1965 7.85999C15.1965 3.71785 11.8387 0.359985 7.69653 0.359985C3.5544 0.359985 0.196533 3.71785 0.196533 7.85999C0.196533 12.0021 3.5544 15.36 7.69653 15.36C11.8387 15.36 15.1965 12.0021 15.1965 7.85999Z" fill="currentColor" fill-opacity="0.1"/>
                        <path d="M10.9295 4.88618C11.1083 4.67577 11.4238 4.65019 11.6343 4.82904C11.8446 5.00788 11.8702 5.32343 11.6914 5.53383L7.44139 10.5338C7.25974 10.7475 6.93787 10.77 6.72825 10.5837L4.47825 8.5837C4.27186 8.40024 4.25327 8.0842 4.43673 7.87781C4.62019 7.67142 4.93622 7.65283 5.14261 7.83629L7.01053 9.49669L10.9295 4.88618Z" fill="currentColor"/>
                    </svg>
                    <span class="text-gray-600 dark:text-gray-400" id="locationMessage">
                      位置情報取得中...
                    </span>
                </li>
            </div>

            <x-primary-button class="mt-8 hover:opacity-75" id="submitPostButton">
                送信する
            </x-primary-button>
        </form>

        <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
        <script src="{{ asset('js/addLocationStorePost.js') }}"></script>
    </div>
    
</x-app-layout>
