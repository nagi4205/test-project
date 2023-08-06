<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://kit.fontawesome.com/26cd3d4f75.js" crossorigin="anonymous"></script>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            {{-- <div class="flex h-screen bg-gray-100"> --}}
                {{-- <div class="w-64 bg-white p-4 shadow-lg"> --}}
                    <main>


                        @include('layouts.sidebar')

                        
                        
                        <div class="w-full pt-10 px-4 sm:px-6 md:px-8 lg:pl-72">
                            <div class="flex-grow bg-white overflow-auto">
                                    {{ $slot }}
                            </div>
                        </div>
                    </main>
                {{-- </div> --}}
                {{-- <div class="flex-grow bg-white overflow-auto">
                {{ $slot }}
                </div> --}}
            {{-- </div> --}}
        </div>
    </body>
</html>
