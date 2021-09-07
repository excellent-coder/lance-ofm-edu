<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<link rel="shortcut icon" href="/{{web_setting('general', 'favicon')}}" type="image/x-icon">
<link rel="stylesheet" href="/vendor/fontawesome/all.min.css">
<link rel="stylesheet" href="{{asset('css/all.css')}}">
<title>{{ web_setting('general', 'title', 'Default Title') }} @yield('title') </title>

