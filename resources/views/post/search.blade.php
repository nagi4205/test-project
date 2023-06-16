<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            検索
        </h2>
    </x-slot>

    <div class="mx-w-7xl mx-auto px-6">
        <div id="map" style="height:400px">
	      </div>


        {!! Form::open(['route' => 'post.currentLocation','method' => 'get']) !!}
         {{--隠しフォームでresult.currentLocationに位置情報を渡す--}}
         {{--lat用--}}
         {!! Form::hidden('lat','lat',['class'=>'lat_input']) !!}
         {{--lng用--}}
         {!! Form::hidden('lng','lng',['class'=>'lng_input']) !!}
         {{--setlocation.jsを読み込んで、位置情報取得するまで押せないようにdisabledを付与し、非アクティブにする。--}}
         {{--その後、disableはfalseになるようにsetlocation.js内に記述した--}}
         {!! Form::submit("周辺を表示", ['class' => "btn btn-success btn-block",'disabled']) !!}
         {!! Form::close() !!}

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
