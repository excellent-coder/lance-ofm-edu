<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Portal</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    <link rel="stylesheet" href="/vendor/fontawesome/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/all.css') }}?v={{$js_version}}">
    <link rel="stylesheet" href="{{ asset('css/portal.css') }}?v={{$js_version}}">
    @yield('css')
</head>
<body class="w-full h-full min-h-screen overflow-x-hidden bg-white">
    <div id="preloader" style="display: block;">
        <div class="bars"></div>
    </div>
    <div id="portal" class="relative flex flex-wrap justify-end w-full h-full min-h-screen">
        <div class="h-screen overflow-y-auto text-white bg-blue-700 sidebar lg:w-1/5 w-72" id="portal-sidebar">
            <i class="sticky top-0 right-0 cursor-pointer fas lg:hidden fa-times fa-2x push" @click.prevent="toggleNav('portal-sidebar')"></i>
            @include('frontend.pgs.includes.sidebar')
        </div>
        <div class="w-full lg:w-4/5">
        @include('frontend.pgs.includes.nav')
            @yield('content')
        </div>
    </div>

    <script src="{{asset('js/portal/manifest.js')}}?v={{$js_version}}"></script>
    <script src="{{asset('js/portal/vendor.js')}}?v={{$js_version}}"></script>
    <script src="{{asset('js/portal/app.js')}}?v={{$js_version}}"></script>
    <script src="https://checkout.flutterwave.com/v3.js"></script>
    @yield('js')
</body>
</html>
