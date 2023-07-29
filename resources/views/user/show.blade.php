<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ $user->name }}
      </h2>
  </x-slot>

  @if(session('message'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
        <span class="block sm:inline">
            {{ session('message') }}
        </span>
    </div>
  @endif
  <div class="mt-8">
    <form action="{{ route('follows.store') }}" method="POST">
      @csrf
      <input type="hidden" name="user_id" value="{{ $user->id }}">
      <x-primary-button type="submit">
        フォローする
      </x-primary-button>
    </form>
  </div>
</x-app-layout>
