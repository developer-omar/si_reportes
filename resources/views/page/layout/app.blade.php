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
        <link rel="stylesheet" href="{{ asset('css/page/app.css') }}">
    @show
</head>
<body class="body">
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark shadow-sm navbar-page">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    @guest()
                    @else
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item nav-item-page">
                            <a class="nav-link nav-link-page" href="/">
                                <i class="fas fa-home sidebar-icon"></i>
                                <span>Inicio</span>
                            </a>
                        </li>
                    </ul>
                    @endguest


                    <!-- Right Side Of Navbar -->
                    @guest()
                    @else
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown nav-item-page">

                            <a id="navbarDropdown" class="nav-link dropdown-toggle nav-link-page" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <i class="fas fa-user-circle"></i>
                                {{ Auth::user()->name }} {{ Auth::user()->last_name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('page.user-company-institution-profile.show') }}">
                                    <i class="fas fa-cog"></i>
                                    Perfil de Usuario
                                </a>
                                <a  class="dropdown-item"
                                    href="{{ route('auth.login.user-company-institution-logout') }}"
                                >
                                    <i class="fas fa-sign-out-alt"></i>
                                    Cerrar Sesi&oacute;n
                                </a>
                            </div>
                        </li>
                    </ul>
                    @endguest
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
