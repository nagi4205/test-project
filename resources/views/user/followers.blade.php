<x-app-layout>
  @foreach($followerUsersCollection as $user)
    <div class="flex">
      <div class="mt-4 p-4 w-full rounded-2xl">
        <div class="pl-6 lg:pl-3 xl:pl-0 pr-6 py-3">
          <div class="flex items-center gap-x-4">
            @isset($user->profile_image)
            <img class="inline-block h-[2.375rem] w-[2.375rem] rounded-full" src="{{ Storage::url($user->profile_image) }}" alt="Image Description">
            @endisset
            <div class="grow">
              <span class="block text-sm font-semibold text-gray-800 dark:text-gray-200">{{ $user->name }}</span>
              <span class="block text-sm text-gray-500">{{ $user->email }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  @endforeach
</x-app-layout>