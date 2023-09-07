{{-- <div class="w-full lg:w-2/3 bg-gray-200"> --}}
<div class="flex">
  <div class="w-full lg:w-3/5">
  @foreach($filteredPosts as $post)
    @if($post->parent_id)
      @include('post.components.parent-post-index')
    @endif
      <div class="mt-4 p-4 w-full rounded-2xl @if($post->parent_id) ml-8 @endif">
        {{--  --}}
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
        {{--  --}}
          <a href="{{ route('posts.show', ['post' => $post->id])}}">
              @isset($post->image)
                <img src="{{ Storage::url($post->image) }}" >
              @endisset
              <p class="py-4 font-medium text-gray-600 dark:text-gray-50">
                {{$post->content}}
              </p>
              <div class="pb-2 text-sm font-light">
                <p class="text-gray-600 dark:text-gray-400">
                  {{$post->location_name}} / {{$post->formatted_created_at}}
                </p>
                  {{-- @foreach($post->tags as $tag)
                    {{$tag->name}}
                  @endforeach --}}        
              </div>
          </a>

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
          <div class="flex gap-x-4 pt-4">
            <a href="{{ route('posts.create', ['parent_id' => $post->id])}}" class="flex items-center w-12 h-4">
              <i class="fa-regular fa-comment-dots dark:text-gray-400"></i>
              @if($post->children->count())
                <span class="mx-2 dark:text-gray-400">{{ $post->children->count() }}</span>
              @endif
            </a>
            <form method="POST" action="{{ route('likes.store') }}" class="flex items-center justify-between w-12 h-4 like-form">
              @csrf
              <input type="hidden" name="post_id" value="{{ $post->id }}">
              <button type="button" class="hover:opacity-75 like-button">
                @if($post->hasLiked)
                  <i class="fas fa-heart text-pink-500"></i>
                @else
                  <i class="far fa-heart text-pink-200 dark:text-gray-400"></i> 
                @endif
                <span class="mx-2 dark:text-gray-400 like-count">{{$post->likedby->count()}}</span>
              </button>
            </form>
          </div>
      </div>
    <hr class="w-full">
  @endforeach
  </div>
  <div class="hidden lg:block lg:w-2/5 px-4">
    <div class="text-sm mb-2">
      現在位置から絞り込んだコミュニティです。
    </div>
    {{-- テスト --}}
    <div class="text-center">
      <button type="button" class="py-3 px-4 inline-flex justify-center items-center gap-2 rounded-md border border-transparent font-semibold bg-blue-500 text-white hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all text-sm dark:focus:ring-offset-gray-800" >
        Open modal
      </button>
    </div>

    <div id="hs-modal-upgrade-to-pro" class="hs-overlay hidden w-full h-full fixed top-0 left-0 z-[60] overflow-x-hidden overflow-y-auto">
      <div class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-lg sm:w-full m-3 sm:mx-auto">
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-gray-800 dark:border-gray-700">
          <div class="p-4 sm:p-7">
            <div class="text-center">
              <h2 class="block text-xl sm:text-2xl font-semibold text-gray-800 dark:text-gray-200">コミュニティーを作成しよう！</h2>
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
            </div>
            <form method="POST" action="{{ route('communities.store') }}" enctype="multipart/form-data">
              @csrf
              <div class="mt-8 sm:mt-10 divide-y divide-gray-200 dark:divide-gray-700">
                <p class="block font-semibold text-gray-800 dark:text-gray-200">コミュニティ名</p>
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                <input name="name"  type="text" class="py-3 px-4 block w-full border-gray-200 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400">
                <p class="block font-semibold text-gray-800 dark:text-gray-200">説明欄</p>
                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                <textarea name="description" class="py-3 px-4 block w-full border-gray-200 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400" rows="3"></textarea>
                <div class="flex items-center">
                  <input type="checkbox" name="status" id="hs-small-switch" class="relative shrink-0 w-11 h-6 bg-gray-100 checked:bg-none checked:bg-blue-600 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 border border-transparent ring-1 ring-transparent focus:border-blue-600 focus:ring-blue-600 ring-offset-white focus:outline-none appearance-none dark:bg-gray-700 dark:checked:bg-blue-600 dark:focus:ring-offset-gray-800 before:inline-block before:w-5 before:h-5 before:bg-white checked:before:bg-blue-200 before:translate-x-0 checked:before:translate-x-full before:shadow before:rounded-full before:transform before:ring-0 before:transition before:ease-in-out before:duration-200 dark:before:bg-gray-400 dark:checked:before:bg-blue-200">
                  <label for="hs-small-switch" class="text-sm text-gray-500 ml-3 dark:text-gray-400">Small</label>
                </div>
                <div class="flex flex-col gap-y-2">
                  <label for="file-upload">ファイルを選択:</label>
                  <x-input-error :messages="$errors->get('community_image')" class="mt-2" />
                  <input type="file" name="community_image" id="file-upload">
                </div>
                <input type="hidden" id="latitude" name="latitude">
                <input type="hidden" id="longitude" name="longitude">
                <input type="hidden" id="location_name" name="location_name">
                <div class="flex justify-end items-center gap-x-2 p-4 sm:px-7 border-t dark:border-gray-700">
                  <button type="button" class="py-2.5 px-4 inline-flex justify-center items-center gap-2 rounded-md border font-medium bg-white text-gray-700 shadow-sm align-middle hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-blue-600 transition-all text-sm dark:bg-gray-800 dark:hover:bg-slate-800 dark:border-gray-700 dark:text-gray-400 dark:hover:text-white dark:focus:ring-offset-gray-800" data-hs-overlay="#hs-modal-upgrade-to-pro">
                    Cancel
                  </button>
                  <x-primary-button class="mt-8 hover:opacity-75" id="submitPostButton">
                    作成！
                  </x-primary-button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    {{-- テスト --}}



    @if($filteredCommunities->isEmpty())
      <div class="my-4 py-4 bg-violet-700 text-sm text-white rounded-md p-4" role="alert">
        <p class="font-bold">お近くにコミュニティーはありません</p>
        <p>コミュニティーを作り仲間と交流しましょう！</p>
  
        <p id="myModal" class="flex justify-end item-center cursor-pointer hover:underline modal-trigger" data-hs-overlay="#hs-modal-upgrade-to-pro">Create New Community
          <svg xmlns="http://www.w3.org/2000/svg" class="text-white ml-2 w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h13M12 5l7 7-7 7"/></svg>
        </p>



        {{-- モーダル --}}
        <div id="" class="hidden fixed inset-0 flex items-center justify-center p-4 bg-black bg-opacity-50">



        </div>
        {{-- モーダル --}}
      </div>
    @else
      @foreach($filteredCommunities as $community)
        <div class="mb-4">
          <a href="{{ route('communities.show', ['community' => $community->id])}}">
            {{-- カード --}}
            <div class="group flex flex-col h-full bg-white border border-gray-200 shadow-sm rounded-xl dark:bg-slate-900 dark:border-gray-700 dark:shadow-slate-700/[.7]">
              <div class="h-60 flex flex-col justify-center items-center bg-white rounded-t-xl relative overflow-hidden">
                @if($community->community_image)
                  <img src="{{ Storage::url($community->community_image) }}" class="absolute w-full h-auto object-cover object-center" alt="Image Description">
                @else
                {{-- <img src="/images/rain-gab98baac5_1280.jpg" class="h-40 w-48 object-cover"> --}}
                  <img src="{{ asset('images/20200502_noimage.jpg') }}" alt="No Image" class="w-32 h-32">
                @endif
              </div>
              <div class="p-4 md:p-6 border-t">
                <h3 class="text-sm font-semibold text-gray-800 hover:text-blue-600 dark:text-gray-300 dark:hover:text-white">
                  {{ $community->name }}
                </h3>
                <p class="text-xs mt-3 text-gray-500">
                  {{ $community->description }}
                </p>
              </div>
              {{-- <div class="mt-auto flex border-t border-gray-200 divide-x divide-gray-200 dark:border-gray-700 dark:divide-gray-700">
                <a class="w-full py-3 px-4 inline-flex justify-center items-center gap-2 rounded-bl-xl font-medium bg-white text-gray-700 shadow-sm align-middle hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-blue-600 transition-all text-sm sm:p-4 dark:bg-slate-900 dark:hover:bg-slate-800 dark:border-gray-700 dark:text-gray-400 dark:hover:text-white dark:focus:ring-offset-gray-800" href="#">
                  View sample
                </a> --}}
                {{-- <a class="w-full py-3 px-4 inline-flex justify-center items-center gap-2 rounded-br-xl font-medium bg-white text-gray-700 shadow-sm align-middle hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-blue-600 transition-all text-sm sm:p-4 dark:bg-slate-900 dark:hover:bg-slate-800 dark:border-gray-700 dark:text-gray-400 dark:hover:text-white dark:focus:ring-offset-gray-800" href="#">
                  View API
                </a> --}}
              {{-- </div> --}}
            </div>
            {{-- カード --}}
          </a>
        </div>
      @endforeach
    @endif
  </div>
</div>