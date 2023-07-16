<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>

    {{-- setLocation.jsファイル内のリダイレクトのロジックによってactionとmethodmethodを補完している。 --}}
    {{-- <form method="get" action="{{ route('post.index') }}"> --}}
        <label>
            <input type="radio" id="radius_3" name="radius" value="3" checked> 3キロメートル
        </label>
        <label>
            <input type="radio" id="radius_5" name="radius" value="5"> 5キロメートル
        </label>
        <label>
            <input type="radio" id="radius_10" name="radius" value="10"> 10キロメートル
        </label>
        <div class="flex justify-center items-center h-screen">
            {{-- idを追加 --}}
            <x-primary-button id="home-button" class="mt-4 hover:opacity-75">
                一覧表示
            </x-primary-button>
        </div>
    {{-- </form> --}}
    
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <script src="{{ asset('/js/setLocation.js') }}"></script>
</x-app-layout>
