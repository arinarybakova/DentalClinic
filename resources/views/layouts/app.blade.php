<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1" >
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | {{ config('app.name', 'Laravel') }}</title>

    <!--font awesome cdn link-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!--custom css file link-->
    <link rel="stylesheet" href="assets/css/styles.css">
    <link href ="{{ mix('css/app.css') }}" type="text/css" rel="stylesheet"/>

    <link rel = "stylesheet" href = "{{ asset('assets/css/patient_style.css') }}">

    <!--@livewireStyles-->

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>
</head>

<body>
    <!--header section starts-->
    <header class="header">
        <div class=banner>
            <div class="logo"> <i class="fas fa-tooth"></i> Odontologijos klinika</div>
            <div class="cnt">+3706700013</div>
            <div class="cne">info@odklinika.com</div>
        </div>
        <nav class="navbar">
            <a href="{{ route('procedures') }}">Procedūros</a>
            @if(Route:: has('login'))

            @auth
            <a href="{{route('appointments')}}">Vizitų istorija</a>
            <a href="{{route('treatments')}}">Gydymo planas</a>
            <a href="{{route('profile')}}" class="mr-2">Paskyra</a>
            <a href="{{route('reservation')}}" class="book" type="submit">Rezervuoti vizitą</a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class = "logout" type="submit">Atsijungti</button>
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