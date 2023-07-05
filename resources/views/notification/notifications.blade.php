<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          通知一覧
      </h2>
  </x-slot>

  <div class="mx-auto px-6">
      {{-- @if(session('message'))
        <div class="text-red-600 font-bold">
          {{session('message')}}
        </div>
      @endif --}}
      @foreach($notifications as $notification)
        <div class="mt-4 p-8 bg-white w-full rounded-2xl">
          <p class="mt-4 p-4">
            {{$notification->data['content']}}
          </p>
          <div class="p-4 text-sm font-semibold">
            <p>
              {{$notification->created_at}}
            </p>
          </div>
        </div>
      @endforeach
      <div class="mb-4">
        {{ $notifications->links() }}
      </div>
  </div>
</x-app-layout>