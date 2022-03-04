<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!--font awesome cdn link-->
    <link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!--custom css file link-->
    <link rel = "stylesheet" href = "../assets/css/styles.css">
    <a href="https://storyset.com/people">People illustrations by Storyset</a>

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
            <x-app-layout>
            </x-app-layout>

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



<!-- footer section ends -->


<!-- custom js file link-->
<script src = "../assets/js/script.js"></script>
</body>
</html>