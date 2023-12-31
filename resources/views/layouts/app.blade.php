<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SN') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    @yield('styles')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/home') }}">
                    {{ config('app.name', 'SN') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Zaloguj się') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Zarejestruj się') }}</a>
                                </li>
                            @endif
                        @else
                        <li class="nav-item">
                        @if(Auth::check())
                <div style="font-size:16px;" class="nav-link">{{ __('Witaj,') }} {{ Auth::user()->first_name }}</div>
                        @endif

                        </li>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>
                               
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                              
                                @if(Request::is('home*'))
                                    <div class="H2p">
                                    <a  onclick="rating(0); toggleExpand()" class="dropdown-item"  href="#">
                                    {{ ('Edycja profilu') }}
                                    </a>
                                    <a onclick="rating(1);  closeExpand();" class="dropdown-item"  href="#">
                                    {{ ('Wydarzenia indywidulane') }}
                                    </a>
                                    @if(Auth::user() && Auth::user()->role == '2')
                                    <a onclick="rating(2);  closeExpand();" class="dropdown-item"  href="#">
                                    {{ (' Zapis grupowy') }}
                                    </a>
                                    @endif
                                    <a onclick="rating(3);  closeExpand();" class="dropdown-item"  href="#">
                                    {{ ('Zapis indywidualny-wygasłe') }}
                                    </a>
                                    @if(Auth::user() && Auth::user()->role == '2')
                                    <a onclick="rating(4);  closeExpand();" class="dropdown-item"  href="#">
                                    {{ ('Zapis grupowy-wygasłe') }}
                                    </a>
                                    @endif
                                    <a  onclick="redirectToEventList(event)" class="dropdown-item"  href="#">
                                    {{ ('Wszystkie wydarzenia') }}
                                    </a>
                                    </div>

                                    @endif
                                    @if(Request::is('event/list*'))
                                    <div class="H2p">
                                    <a onclick="window.location.href = '{{ url('/home') }}';" class="dropdown-item" href="#">
                                    {{ ('Profil') }}
                                    </a>
                                    </div>

                                    @endif
                                    
                                    <a style="font-size:14px;" class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Wyloguj') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                   
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>