<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          RainMood
      </h2>
  </x-slot>

  <div class="mx-auto px-6">
    @foreach ($notifications as $notification)
    <div class="notification w-full p-4 bg-gray-600 text-red-400 rounded-sm m-4">
        {{-- <a href="/articles/{{ $notification->data['article']['id'] }}"> </a> --}}
        <p>{{ $notification->data['article_title'] }}</p>
    </div>
    @endforeach
    <div class="mb-4">
      {{ $notifications->links() }}
    </div>
  </div>
</x-app-layout>