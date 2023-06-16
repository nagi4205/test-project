<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            検索
        </h2>
    </x-slot>

    <div class="mx-w-7xl mx-auto px-6">
        <div id="map" style="height:400px">
	    </div>
        
        <script>
            // currentLocation.jsで使用する定数latに、controllerで定義した$latをいれて、currentLocation.jsに渡す
            const lat = {{ $lat }};
            // currentLocation.jsで使用する定数lngに、controllerで定義した$lngをいれて、currentLocation.jsに渡す
            const lng = {{ $lng }};
        </script>
        {{--    上記の処理をしてから、googleMapを読み込まないとエラーが出てくる--}}


        <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>

        <script src="{{ asset('/js/setLocation.js') }}"></script>
        <script src="{{ asset('/js/result.js') }}"></script>
        <script src="https://maps.googleapis.com/maps/api/js?language=ja&region=JP&key=AIzaSyDLm3FiiHj5SL12ki1Nigf2P9i9irwpXZU&callback=initMap" async defer>
        </script>

        <form method="get" action="{{ route('post.index') }}">
            <div class="flex justify-center items-center h-screen">
                <x-primary-button class="mt-4 hover:opacity-75">
                    検索
                </x-primary-button>
            </div>
        </form>
    </div>

  

</x-app-layout>
