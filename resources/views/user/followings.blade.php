<x-app-layout>
  @foreach($followingUsersCollection as $user)
    <div>  
      {{$user->name}}
    </div>
  @endforeach
</x-app-layout>