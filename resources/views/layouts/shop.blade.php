<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('includes.meta')
    <title>{{ config('app.name', 'WishLead') }}@yield('title')</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    <link rel="stylesheet" href="/vendor/fontawsome/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('css/shop/shop.css') }}">
    @yield('css')
</head>

<body class="w-full font-sans antialiased bg-gray-200">
     <div id="preloader" style="display: block;">
        <div class="bars"></div>
    </div>
    <div id="shop" class="container overflow-x-hidden ">
        @include('includes.shop.nav')
        <div class="mt-2 ">
            @yield('content')
        </div>

        {{-- modals --}}
        @include('includes.modals.general')
        @guest
            @include('includes.modals.auth')
        @endguest
        {{-- modals --}}
    </div>
    <script src="{{asset('js/shop/manifest.js')}}"></script>
    <script src="{{asset('js/shop/vendor.js')}}"></script>
    <script src="{{asset('js/shop/shop.js')}}"></script>
    @yield('js')
</body>

</html>
