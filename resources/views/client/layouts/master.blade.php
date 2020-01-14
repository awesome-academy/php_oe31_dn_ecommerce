 <!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="baseUrl" content="{{ url(route('client.home.index')) }}">
    <meta name="fullUrl" content="{{ url()->full() }}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/bower_dev/fontawesome-free/all.min.css') }}" rel="stylesheet">
    <title>@yield('title')</title>
    @yield('style')
</head>
<body>
    @include('client.layouts.header')

    @yield('content')

    @include('client.layouts.footer')

    <script src="{{ asset('plugins/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
