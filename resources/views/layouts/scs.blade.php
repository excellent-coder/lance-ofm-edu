<!DOCTYPE html>
<html lang="en">
<head>
    @include('includes.meta')
        <link rel="stylesheet" href="{{ asset('css/portal.css') }}">
    @yield('css')
</head>
<body class="w-full h-full min-h-screen overflow-x-hidden bg-white">
    <div id="preloader" style="display: block;">
        <div class="bars"></div>
    </div>
    <div id="portal" class="relative flex flex-wrap justify-end w-full h-full min-h-screen">
        <div class="h-screen overflow-y-auto text-white bg-blue-700 sidebar lg:w-1/5 w-72" id="portal-sidebar">
            <i class="sticky top-0 right-0 cursor-pointer fas lg:hidden fa-times fa-2x push" @click.prevent="toggleNav('portal-sidebar')"></i>
            @include('frontend.scs.includes.sidebar')
        </div>
        <div class="w-full lg:w-4/5">
        @include('frontend.scs.includes.nav')
            @yield('content')
        </div>
    </div>

    <script src="{{asset('js/portal/manifest.js')}}"></script>
    <script src="{{asset('js/portal/vendor.js')}}"></script>
    <script src="{{asset('js/portal/app.js')}}"></script>
    <script src="https://checkout.flutterwave.com/v3.js"></script>
    @yield('js')
</body>
</html>
