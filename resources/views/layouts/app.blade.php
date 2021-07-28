<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('includes.meta')
    <title>{{ config('app.name', 'WishLead') }}@yield('title')</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    <link rel="stylesheet" href="/vendor/fontawsome/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @yield('css')
</head>

<body class="font-sans antialiased w-full">
     <div id="preloader" style="display: block;">
        <div class="bars"></div>
    </div>
    <div id="app" class="w-full overflow-x-hidden">
        @include('includes.navbar')
        <div style="margin-top:50px">
        @yield('content')
        </div>

        {{-- modals --}}
        @include('includes.modals.general')
        @guest
            @include('includes.modals.auth')
        @endguest
        {{-- modals --}}
    </div>
    <script src="{{asset('js/manifest.js')}}"></script>
    <script src="{{asset('js/vendor.js')}}"></script>
    <script src="{{asset('js/app.js')}}"></script>
    @yield('js')
</body>

</html>
