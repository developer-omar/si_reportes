<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel='icon' href='{{ asset('favicon.ico') }}' type='image/x-icon'>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    @section('js')
        <script src="{{ asset('js/app.js') }}"></script>
    @show

<!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    @section('css')
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/page/dashboard.css') }}" rel="stylesheet">
    @show
</head>
<body>
@include('page.layout.navbar-mobile')
<div class="wrapper">
    @include('page.layout.sidebar')
    <main class="main">
        @include('page.layout.navbar-main')
        <div class="content">
            @yield('content')
        </div>
    </main>
</div>
</body>
</html>
