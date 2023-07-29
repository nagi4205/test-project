<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    
    <div class="flex justify-center mt-4">
        @isset($user->profile_image)
            <img src="{{ Storage::url($user->profile_image) }}" >
        @endisset
    </div>


    <form  method="post" action="{{ route('profile.storeImage', ['user' => auth()->id()]) }}" enctype="multipart/form-data">
        @csrf
        <input type="file" class="form-control-file" name="profile_image" accept="image/*">
        <x-primary-button>保存</x-primary-button>
    </form>

    <div class="m-4">
        <button type="button" class="group inline-flex items-center gap-2 rounded-full bg-gray-700 px-4 py-1.5 font-semibold text-white hover:bg-gray-900">
          MENU
          <svg class="stroke-gray-50 stroke-2" xmlns="http://www.w3.org/2000/svg" fill="none" width="24" height="24" viewBox="0 0 24 24" aria-hidden="true">
            <line x1="2" y1="5" x2="22" y2="5" />
            <line x1="2" y1="12" x2="18" y2="12" class="transition group-hover:translate-x-[-0.5px] group-hover:scale-x-125" />
            <line x1="2" y1="19" x2="22" y2="19" class="transition group-hover:translate-x-[1px] group-hover:scale-x-50" />
          </svg>
        </button>
      </div>

      




    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
