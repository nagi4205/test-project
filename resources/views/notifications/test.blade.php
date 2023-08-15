<x-app-layout>
  <div class="mx-auto px-6">
      {{-- @if(session('message'))
        <div class="text-red-600 font-bold">
          {{session('message')}}
        </div>
      @endif --}}
      @foreach($notifications as $notification)
        <div class="mt-4 p-8 bg-white w-full rounded-2xl">
          <p class="mt-4 p-4">
            {{-- {{$notification->data['content']}} --}}
          </p>
          <div class="p-4 text-sm font-semibold">
            <p>
              {{$notification->created_at}}
            </p>
          </div>

          {{-- <form method="post" action="{{ route('post.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="w-full flex flex-col">
                <label for="tag" class="font-semibold mt-4">タグ</label>
                <select name="tag" id="tag">
                    @foreach($tags as $tag)
                        <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                    @endforeach
                </select>
            </div>

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
            {{-- <input type="hidden" id="latitude" name="latitude">
            <input type="hidden" id="longitude" name="longitude">

            <x-primary-button class="mt-8 hover:opacity-75">
                送信する
            </x-primary-button>
        </form>

          <form method="POST" action="{{ route('notification/{notification}/response') }}" >
            @csrf
            <div class="w-full flex flex-col">
              <label for="tag" class="font-semibold mt-4">タグ</label>
              <select name="tag" id="tag">
                  @foreach($tags as $tag)
                      <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                  @endforeach
              </select>
          </div>
          </form> --}}

          {{-- <form action="{{ route('notification.response.store') }}" method="POST">
            @csrf
            <input type="hidden" name="notification_id" value="{{ $notification->id }}">
            <input type="radio" id="yes" name="response" value="Yes">
            <label for="yes">Yes</label>
            <input type="radio" id="no" name="response" value="No">
            <label for="no">No</label>
            <input type="submit" value="Submit">
          </form> --}}

          <form action="{{ route('notification.response.store', ['notification' => $notification->id]) }}" method="POST" class="space-y-6">
            @csrf
            <input type="hidden" name="notification_id" value="{{ $notification->id }}">
        
            <div class="flex items-center">
                <input type="radio" id="yes" name="response" value="Yes" class="form-radio text-red-600 h-4 w-4">
                <label for="yes" class="ml-2">Yes</label>
            </div>
        
            <div class="flex items-center">
                <input type="radio" id="no" name="response" value="No" class="form-radio text-indigo-600 h-4 w-4">
                <label for="no" class="ml-2">No</label>
            </div>
        
            <input type="submit" value="Submit" class="w-full py-2 px-4 text-white bg-indigo-600 hover:bg-indigo-500 rounded-md cursor-pointer">
            <x-primary-button class="mt-8 hover:opacity-75">
              送信する
            </x-primary-button>
        </form>
        

        </div>
      @endforeach
      <div class="mb-4">
        {{ $notifications->links() }}
      </div>
  </div>
</x-app-layout>