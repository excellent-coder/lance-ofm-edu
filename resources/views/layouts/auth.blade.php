<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('includes.meta')
        <link rel="stylesheet" href="{{ asset('css/all.css') }}">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        @yield('css')
    </head>
    <body>
        <div id="preloader" style="display: block;">
            <div class="bars"></div>
        </div>
        <div class="w-full font-sans antialiased text-gray-900" id="app">
            @include('includes.navbar')
            <div class="mt-16 ">
                @yield('content')
            </div>
        </div>
    <script src="{{asset('js/manifest.js')}}"></script>
    <script src="{{asset('js/vendor.js')}}"></script>
    <script src="{{asset('js/app.js')}}"></script>
    <script src="{{asset('vendor/intersection-observer/main.js')}}"></script>
    <script src="{{asset('js/interset.js')}}"></script>
    <script src="https://checkout.flutterwave.com/v3.js"></script>

    @yield('js')
    </body>
</html>
