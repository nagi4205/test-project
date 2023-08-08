<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          RainMood
      </h2>
  </x-slot>

  @if(session('message'))
  <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
      <span class="block sm:inline">
          {{ session('message') }}
      </span>
  </div>
  @endif
  
  <div class="mx-auto px-6">
    @foreach ($notifications as $notification)
    <div class="notification w-full p-4 border rounded-sm m-4">
        {{-- <a href="/articles/{{ $notification->data['article']['id'] }}"> </a> --}}
        @isset($notification->data['article_title'])
          <p>{{ $notification->data['article_title'] }}</p>
        @endisset
        @isset($notification->data['follower_id'])
          <a href="{{ route('user.show', ['user' => $notification->data['follower_id']]) }}">
            <div class="flex items-center gap-x-2">
              <img class="inline-block h-8 w-8 rounded-full ring-2 ring-white dark:ring-gray-800" src="{{ Storage::url($notification->data['follower_profile_image']) }}" alt="Image Description">
              <p class="mb-4">{{ $notification->data['follower_name'] }}さんからフォロー申請が届いています。</p>
            </div>
          </a>
          <form method="post" action="{{ route('follows.respondToFollowRequest') }}">
            @csrf
            <input type="hidden" name="follower_id" value="{{ $notification->data['follower_id'] }}">
            <input type="hidden" name="notification_id" value="{{ $notification->id }}">
            <div class="flex">
              <div class="pr-4">
                <button type="submit" name="action" value="approve" class="py-3 px-4 inline-flex justify-center items-center gap-2 rounded-md border-2 border-gray-900 font-semibold text-gray-800 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-800 focus:ring-offset-2 transition-all text-sm dark:text-white dark:hover:bg-gray-900 dark:hover:border-gray-900 dark:focus:ring-gray-900 dark:focus:ring-offset-gray-800">
                  承認
                </button>
              </div>
              <button type="submit" name="action" value="reject" class="py-3 px-4 inline-flex justify-center items-center gap-2 rounded-md border-2 border-red-200 font-semibold text-red-500 hover:text-white hover:bg-red-500 hover:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-200 focus:ring-offset-2 transition-all text-sm dark:focus:ring-offset-gray-800">
                拒否
              </button>
            </div>
          </form>
        @endisset
    </div>
    @endforeach
    <div class="mb-4">
      {{ $notifications->links() }}
    </div>
  </div>
</x-app-layout>