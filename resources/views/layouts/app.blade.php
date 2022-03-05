<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | {{ config('app.name', 'Laravel') }}</title>

    <!--font awesome cdn link-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!--custom css file link-->
    <link rel="stylesheet" href="{{ mix('css/user.css') }}">
    <a href="https://storyset.com/people">People illustrations by Storyset</a>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    @livewireStyles

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>
</head>

<body>
    <!--header section starts-->
    <header class="header">
        <a href="#" class="logo"> <i class="fas fa-tooth"></i> dentalcare. </a>
        <nav class="navbar">
            <a href="#home">Pagrindinis</a>
            <a href="#services">Paslaugos</a>
            <a href="#about">Apie mus</a>
            <a href="#doctors">Specialistai</a>
            @if(Route:: has('login'))

            @auth
            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <a href="{{route('login')}}">Atsijungti</a>
            </form>
            @else
            <a href="{{route('login')}}">Prisijungti</a>
            <a href="{{route('register')}}">Registruotis</a>

            @endauth

            @endif
        </nav>

        <!--menu mygtukas kai ekrano dydis mazesnis-->
        <div id="menu-btn" class="fas fa-bars"></div>
    </header>
    <!--header section ends-->
    <div class="container mt-5" id="app">
        @yield('content')
    </div>

    <!-- footer section ends -->
</body>
</html>