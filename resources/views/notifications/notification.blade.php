<x-app-layout>
  <x-slot name="header">
      <h2 class="fles justify-end font-semibold text-xl text-gray-800 leading-tight">
          通知
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
    @foreach($notifications as $notification)
    <div class="notification w-full p-4 border rounded-sm m-4">
      @switch($notification->getTypeKey())
        @case('liked_post')
          @include('notifications.partials.likedPost')
        @break
        @case('follow_request')
          @include('notifications.partials.followRequest')
        @break
        @default
          @include('notifications.partials.unknown')
      @endswitch
      {{-- {!! $renderedNotifications[$loop->index] !!} --}}
    </div>
    @endforeach
    <div class="mb-4">
      {{-- {{ $notifications->links() }} --}}
    </div>
  </div>
</x-app-layout>