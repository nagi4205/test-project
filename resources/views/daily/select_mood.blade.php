<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          毎日フォーム
      </h2>
  </x-slot>

  @if ($errors->any())
  <div class="alert alert-danger">
      <ul>
          @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
          @endforeach
      </ul>
  </div>
  @endif

  @isset($moodValue)
    <p>{{$moodValue}}</p>
  @endisset


  <div class="mx-w-7xl mx-auto px-6">
    <div class="grid m-20 place-items-center">
      <div class="w-11/12 p-12 bg-white sm:w-8/12 md:w-1/2 lg:w-7/12">
        <h1 class="text-xl font-semibold">DailyCheck!</h1>
        <form class="mt-6" method="POST" action="{{ route('daily_mood.store') }}">
          @csrf
            <p class="mt-4">出勤しましたか？</p>
            <div class="mt-2 mx-auto">
              <div class="flex items-center space-x-2">
                <input type="radio" id="example1" name="attendance" value="1" class="h-4 w-4 rounded-full border-gray-300 text-primary-600 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50 focus:ring-offset-0 disabled:cursor-not-allowed disabled:text-gray-400" />
                <label for="example1" class="text-sm font-medium text-gray-700">はい</label>
              </div>
              <div class="flex items-center space-x-2">
                <input type="radio" id="example2" checked name="attendance" value="0" class="h-4 w-4 rounded-full border-gray-300 text-primary-600 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50 focus:ring-offset-0 disabled:cursor-not-allowed disabled:text-gray-400" />
                <label for="example2" class="text-sm font-medium text-gray-700">いいえ</label>
              </div>
            </div>
            <p class="mt-4">今日の気分を選択して下さい</p>
            <div class="flex justify-around mt-4">
              @foreach($moods as $mood)
              <label class="block border p-2 hover:scale-105">
                <input type="radio" name="mood_id" value="{{$mood->id}}" class="hidden radio" onclick="changeClass(this)">
                <img src="/images/rain-gab98baac5_1280.jpg" class="h-40 w-48 object-cover">
              </label>
              @endforeach
            </div> 
            <button type="submit" class="mt-4 px-4 py-2 bg-blue-600 text-white">Submit</button>
        </form>
      </div>
    </div>
  </div>
  {{-- <script>
  function changeClass(elem) {
    let radios = document.getElementsByClassName('radio');
    for (let i = 0; i < radios.length; i++) {
      let label = radios[i].nextElementSibling;
      if (radios[i] === elem && radios[i].checked) {
        label.classList.add('border-2', 'border-indigo-500');
      } else {
        label.classList.remove('border-2', 'border-indigo-500');
      }
    }
  }
  </script> --}}
  <script>
    function changeClass(elem) {
      let radios = document.getElementsByClassName('radio');
      for (let i = 0; i < radios.length; i++) {
        let label = radios[i].parentNode;
        if (radios[i] === elem && radios[i].checked) {
          label.classList.add('border-2', 'border-indigo-500');
        } else {
          label.classList.remove('border-2', 'border-indigo-500');
        }
      }
    }
    </script>

</x-app-layout>
