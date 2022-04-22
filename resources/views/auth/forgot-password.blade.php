<!DOCTYPE html>
<html>
<head>
    <!--font awesome cdn link-->
    <link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
     <!--custom css file link-->     
</head>
<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            
        <div class = "txt-lg"><i id = icon class="fas fa-tooth"></i>Odontologijos klinika</div>
        <div class = "txt-lb"> Slaptažodžio priminimas </div>
            <!--<x-jet-authentication-card-logo />-->
        </x-slot>
        

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Pamiršote slaptažodį? Jei taip, įrašykite savo el. pašto adresą ir mes atsiųsime Jums slaptažodžio atstatymo nuorodą.') }}
        </div>

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <x-jet-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="block">
                <x-jet-label for="email" value="{{ __('El. paštas') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <div class="flex items-center justify-end mt-4">
                <div class = "reset">
                <x-jet-button>
                    {{ __('Išsiųsti slaptažodžio atstatymo nuorodą') }}
                </x-jet-button>
                </div>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
<style>
    #icon {
        color: #2fbab8;
        margin-top: 1rem;   
    }
    .txt-lg{
        text-align: center;
        padding-top: 5px;
        padding-bottom: 80px;
        color: #2fbab8;
        font-size: 2.2rem;
        
    }
    .txt-lb{
        text-align: center;
        padding-top: 10px;
        font-size: 1.4rem;
        color: #444;
        font-weight: bold;
        
    }
    .text-sm{
        text-decoration:none;
        color: #444;
        font-size: 1rem;
    }
</style>