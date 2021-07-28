<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Portal</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    <link rel="stylesheet" href="/vendor/fontawsome/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('css/portal.css') }}">
    @yield('css')
</head>
<body class="bg-white w-full overflow-x-hidden h-full min-h-screen">
    <div id="preloader" style="display: block;">
        <div class="bars"></div>
    </div>
    <div id="portal" class="w-full h-full flex flex-wrap relative min-h-screen justify-end">
        <div class="sidebar lg:w-1/5 bg-blue-700 text-white h-screen w-72 overflow-y-auto" id="portal-sidebar">
            <i class="fas lg:hidden fa-times fa-2x cursor-pointer sticky top-0 right-0 push" @click.prevent="toggleNav('portal-sidebar')"></i>
            @include('frontend.portal.includes.sidebar')
        </div>
        <div class="lg:w-4/5 w-full">
        @include('frontend.portal.includes.nav')
            @yield('content')
        </div>
    </div>

    <script src="{{asset('js/portal/manifest.js')}}"></script>
    <script src="{{asset('js/portal/vendor.js')}}"></script>
    <script src="{{asset('js/portal/app.js')}}"></script>
    @yield('js')
</body>
</html>
