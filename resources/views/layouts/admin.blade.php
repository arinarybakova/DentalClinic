<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1" >
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') | {{ config('app.name', 'Laravel') }}</title>
    
    <!--font awesome cdn link-->
    <link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <!--custom css file link-->
    <link rel = "stylesheet" href = "{{ asset('assets/css/admin_style.css') }}">
    <link href ="{{ mix('css/app.css') }}" type="text/css" rel="stylesheet"/>
    
    <script src="{{ mix('/js/app.js') }}" defer></script>
</head>
<body>
        <input type ="checkbox" id="nav-toggle">
        @include ('admin.sidebar')
        <div class="main-content">
            @include ('admin.header')
            <main id="app">
                @yield('content')
            </main>
        </div>
</body>
</html>
