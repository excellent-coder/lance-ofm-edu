<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('includes.meta')
        <link rel="stylesheet" href="{{ asset('css/all.css') }}">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    </head>
    <body>
        <div class="w-full font-sans antialiased text-gray-900" id="app">
            @yield('content')
        </div>
    <script src="{{asset('js/manifest.js')}}"></script>
    <script src="{{asset('js/vendor.js')}}"></script>
    <script src="{{asset('js/app.js')}}"></script>
    <script src="{{asset('vendor/intersection-observer/main.js')}}"></script>
    <script src="{{asset('js/interset.js')}}"></script>
    @yield('js')
    </body>
</html>