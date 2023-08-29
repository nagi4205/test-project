<x-app-layout>
  <div class="w-full lg:w-2/3">
    @foreach ($followingUsers as $user)
      <div class="flex mt-2">
        <div class="dark:text-gray-200">{{$user->name}}</div>
        <form method="POST" action="{{route('community-invitations.store')}}">
          @csrf
          <input type="hidden" name="community_id" value="{{$community->id}}">
          <input type="hidden" name="invitee_id" value="{{$user->id}}">
          <input type="hidden" name="action_type" value="invite">
          <x-primary-button class="ml-12 hover:opacity-75">
            招待する
          </x-primary-button>
        </form>
      </div>
    @endforeach
  </div>
</x-app-layout>
