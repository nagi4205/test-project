<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          お気に入りした投稿
      </h2>
  </x-slot>
  <div class="flex flex-row">
    <div class="w-full lg:w-2/3 bg-gray-200">
      <p>この部分はPC画面で2カラムの左側（全体の2/3）になります。スマホだと1カラムになります。</p>
    </div>
    <div class="w-full lg:w-1/3 bg-gray-300">
      <p>この部分はPC画面で2カラムの右側（全体の1/3）になります。スマホだと1カラムになります。</p>
    </div>
  </div>

  <div class="flex justify-center items-center h-screen">
    <x-primary-button id="home-button" class="mt-4 hover:opacity-75">
        一覧表示
    </x-primary-button>
  </div>

  <div class="flex justify-center items-start h-screen bg-gray-200 bg-opacity-50 p-6 rounded-lg">
    <x-primary-button id="home-button" class="mt-4 hover:opacity-75">
        一覧表示
    </x-primary-button>
  </div>


</x-app-layout>