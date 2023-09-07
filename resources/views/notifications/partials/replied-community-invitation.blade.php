<a href="{{ route('user.show', ['user' => $notification->data['invitee_id']]) }}">
  <div class="flex items-center gap-x-2">
    {{-- <img class="inline-block h-8 w-8 rounded-full ring-2 ring-white dark:ring-gray-800" src="{{ Storage::url($notification->data['follower_profile_image']) }}" alt="Image Description"> --}}
    <p class="mb-4 dark:text-gray-50">{{ $notification->data['invitee_name'] }}さんが「{{ $notification->data['community_name'] }}」に参加しました！</p>
  </div>
</a>