<x-app-layout>
  <div class="flex justify-end text-red-600">
    <h1>Communities</h1>
  </div>

  <div class="flex justify-end text-gray-600 dark:text-gray-100">
    @if($communities->isEmpty())
        <p>No communities available.</p>
    @else
        <ul>
            @foreach($communities as $community)
              <a href="{{ route('communities.show', ['community' => $community->id])}}">
                <p>{{ $community->name }}</p>
              </a>
            @endforeach
        </ul>
    @endif
  </div>

  <div class="text-center">
    <button type="button" class="py-3 px-4 inline-flex justify-center items-center gap-2 rounded-md border border-transparent font-semibold bg-blue-500 text-white hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all text-sm dark:focus:ring-offset-gray-800" data-hs-overlay="#hs-modal-upgrade-to-pro">
      Open modal
    </button>
  </div>
  
  <!-- Modal -->
  <div id="hs-modal-upgrade-to-pro" class="hs-overlay hidden w-full h-full fixed top-0 left-0 z-[60] overflow-x-hidden overflow-y-auto">
    <div class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-lg sm:w-full m-3 sm:mx-auto">
      <div class="bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-gray-800 dark:border-gray-700">
        <div class="p-4 sm:p-7">
          <div class="text-center">
            <h2 class="block text-xl sm:text-2xl font-semibold text-gray-800 dark:text-gray-200">コミュニティーを作成しよう！</h2>
            <div class="mt-2">
              <li class="flex space-x-3" id="locationStatus">
                  <svg class="flex-shrink-0 h-6 w-6 text-green-300" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M15.1965 7.85999C15.1965 3.71785 11.8387 0.359985 7.69653 0.359985C3.5544 0.359985 0.196533 3.71785 0.196533 7.85999C0.196533 12.0021 3.5544 15.36 7.69653 15.36C11.8387 15.36 15.1965 12.0021 15.1965 7.85999Z" fill="currentColor" fill-opacity="0.1"/>
                      <path d="M10.9295 4.88618C11.1083 4.67577 11.4238 4.65019 11.6343 4.82904C11.8446 5.00788 11.8702 5.32343 11.6914 5.53383L7.44139 10.5338C7.25974 10.7475 6.93787 10.77 6.72825 10.5837L4.47825 8.5837C4.27186 8.40024 4.25327 8.0842 4.43673 7.87781C4.62019 7.67142 4.93622 7.65283 5.14261 7.83629L7.01053 9.49669L10.9295 4.88618Z" fill="currentColor"/>
                  </svg>
                  <span class="text-gray-600 dark:text-gray-400" id="locationMessage">
                    位置情報取得中...
                  </span>
              </li>
            </div>
          </div>
  
          <form method="POST" action="{{ route('communities.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="mt-8 sm:mt-10 divide-y divide-gray-200 dark:divide-gray-700">
              <p class="block font-semibold text-gray-800 dark:text-gray-200">コミュニティ名</p>
              <x-input-error :messages="$errors->get('name')" class="mt-2" />
              <input name="name"  type="text" class="py-3 px-4 block w-full border-gray-200 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400">
              <p class="block font-semibold text-gray-800 dark:text-gray-200">説明欄</p>
              <x-input-error :messages="$errors->get('description')" class="mt-2" />
              <textarea name="description" class="py-3 px-4 block w-full border-gray-200 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400" rows="3"></textarea>
              <div class="flex items-center">
                <input type="checkbox" name="status" id="hs-small-switch" class="relative shrink-0 w-11 h-6 bg-gray-100 checked:bg-none checked:bg-blue-600 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 border border-transparent ring-1 ring-transparent focus:border-blue-600 focus:ring-blue-600 ring-offset-white focus:outline-none appearance-none dark:bg-gray-700 dark:checked:bg-blue-600 dark:focus:ring-offset-gray-800 before:inline-block before:w-5 before:h-5 before:bg-white checked:before:bg-blue-200 before:translate-x-0 checked:before:translate-x-full before:shadow before:rounded-full before:transform before:ring-0 before:transition before:ease-in-out before:duration-200 dark:before:bg-gray-400 dark:checked:before:bg-blue-200">
                <label for="hs-small-switch" class="text-sm text-gray-500 ml-3 dark:text-gray-400">Small</label>
              </div>
              <div class="flex flex-col gap-y-2">
                <label for="file-upload">ファイルを選択:</label>
                <input type="file" name="community_image" id="file-upload">
              </div>
              <input type="hidden" id="latitude" name="latitude">
              <input type="hidden" id="longitude" name="longitude">
              <input type="hidden" id="location_name" name="location_name">
              <div class="flex justify-end items-center gap-x-2 p-4 sm:px-7 border-t dark:border-gray-700">
                <button type="button" class="py-2.5 px-4 inline-flex justify-center items-center gap-2 rounded-md border font-medium bg-white text-gray-700 shadow-sm align-middle hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-blue-600 transition-all text-sm dark:bg-gray-800 dark:hover:bg-slate-800 dark:border-gray-700 dark:text-gray-400 dark:hover:text-white dark:focus:ring-offset-gray-800" data-hs-overlay="#hs-modal-upgrade-to-pro">
                  Cancel
                </button>
                <x-primary-button class="mt-8 hover:opacity-75" id="submitPostButton">
                  作成！
                </x-primary-button>
              </div>
              {{-- <!-- Icon -->
              <div class="flex gap-x-7 py-5 first:pt-0 last:pb-0">
                <svg class="flex-shrink-0 mt-1 w-8 h-8 text-gray-600 dark:text-gray-400"xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M5.5 9.511c.076.954.83 1.697 2.182 1.785V12h.6v-.709c1.4-.098 2.218-.846 2.218-1.932 0-.987-.626-1.496-1.745-1.76l-.473-.112V5.57c.6.068.982.396 1.074.85h1.052c-.076-.919-.864-1.638-2.126-1.716V4h-.6v.719c-1.195.117-2.01.836-2.01 1.853 0 .9.606 1.472 1.613 1.707l.397.098v2.034c-.615-.093-1.022-.43-1.114-.9H5.5zm2.177-2.166c-.59-.137-.91-.416-.91-.836 0-.47.345-.822.915-.925v1.76h-.005zm.692 1.193c.717.166 1.048.435 1.048.91 0 .542-.412.914-1.135.982V8.518l.087.02z"/>
                  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                  <path d="M8 13.5a5.5 5.5 0 1 1 0-11 5.5 5.5 0 0 1 0 11zm0 .5A6 6 0 1 0 8 2a6 6 0 0 0 0 12z"/>
                </svg>
    
                <div>
                  <h3 class="font-semibold text-gray-800 dark:text-gray-200">
                    "Compare to" price
                  </h3>
                  <p class="text-sm text-gray-500">
                    Use this feature when you want to put a product on sale or show savings off suggested retail pricing.
                  </p>
                </div>
              </div>
              <!-- End Icon -->
    
              <!-- Icon -->
              <div class="flex gap-x-7 py-5 first:pt-0 last:pb-0">
                <svg class="flex-shrink-0 mt-1 w-8 h-8 text-gray-600 dark:text-gray-400"xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M3.5 3.5c-.614-.884-.074-1.962.858-2.5L8 7.226 11.642 1c.932.538 1.472 1.616.858 2.5L8.81 8.61l1.556 2.661a2.5 2.5 0 1 1-.794.637L8 9.73l-1.572 2.177a2.5 2.5 0 1 1-.794-.637L7.19 8.61 3.5 3.5zm2.5 10a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0zm7 0a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0z"/>
                </svg>
    
                <div>
                  <h3 class="font-semibold text-gray-800 dark:text-gray-200">
                    Bulk discount pricing
                  </h3>
                  <p class="text-sm text-gray-500">
                    Encourage higher purchase quantities with volume discounts.
                  </p>
                </div>
              </div>
              <!-- End Icon -->
    
              <!-- Icon -->
              <div class="flex gap-x-7 py-5 first:pt-0 last:pb-0">
                <svg class="flex-shrink-0 mt-1 w-8 h-8 text-gray-600 dark:text-gray-400"xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2zM8 1.918l-.797.161A4.002 4.002 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4.002 4.002 0 0 0-3.203-3.92L8 1.917zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5.002 5.002 0 0 1 13 6c0 .88.32 4.2 1.22 6z"/>
                </svg>
    
                <div>
                  <h3 class="font-semibold text-gray-800 dark:text-gray-200">
                    Inventory tracking
                  </h3>
                  <p class="text-sm text-gray-500">
                    Automatically keep track of product availability and receive notifications when inventory levels get low.
                  </p>
                </div>
              </div>
              <!-- End Icon --> --}}
            </div>
          </form>
        </div>
  
        <!-- Footer -->
        {{-- <div class="flex justify-end items-center gap-x-2 p-4 sm:px-7 border-t dark:border-gray-700">
          <button type="button" class="py-2.5 px-4 inline-flex justify-center items-center gap-2 rounded-md border font-medium bg-white text-gray-700 shadow-sm align-middle hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-blue-600 transition-all text-sm dark:bg-gray-800 dark:hover:bg-slate-800 dark:border-gray-700 dark:text-gray-400 dark:hover:text-white dark:focus:ring-offset-gray-800" data-hs-overlay="#hs-modal-upgrade-to-pro">
            Cancel
          </button>
          <a class="py-2.5 px-4 inline-flex justify-center items-center gap-2 rounded-md border border-transparent font-semibold bg-blue-500 text-white hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all text-sm dark:focus:ring-offset-gray-800" href="#">
            作成！
          </a>
        </div> --}}
        <!-- End Footer -->
      </div>
    </div>
  </div>
  <!-- End Modal -->
  <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
  <script src="{{ asset('js/addLocationStoreCommunity.js') }}"></script>
</x-app-layout>

