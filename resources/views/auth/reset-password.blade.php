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
            <!--<x-jet-authentication-card-logo />-->
          
        <div class = "txt-lg"><i id = icon class="fas fa-tooth"></i>Odontologijos klinika</div>
        <div class = "txt-lb"> Slaptažodžio sukūrimas </div>
        
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="block">
                <x-jet-label for="email" value="{{ __('El. paštas') }}" />
                <x-jet-input id="email" class="inputF w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus />
            </div>

            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('Slaptažodis') }}" />
                <x-jet-input id="password" class="inputF w-full" type="password" name="password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-jet-label for="password_confirmation" value="{{ __('Pakartoti slaptažodį') }}" />
                <x-jet-input id="password_confirmation" class="inputF w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-jet-button class="ml-4">
                    {{ __('Sukurti slaptažodį') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
<style>
    #icon {
        color: #2fbab8;
        margin-top: 0.3rem;   
    }
    .txt-lg{
        text-align: center;
        padding-top: 5px;
        padding-bottom: 12px;
        color: #2fbab8;
        font-size: 2rem;     
    }
    .mt-4{
       margin-bottom: 1rem;
    }
    .txt-lb{
        text-align: center;
        padding-top: 8px;
        font-size: 1.4rem;
        color: #444;
        font-weight: bold;     
    }
    .ml-4{
       background-color: #2fbab8;
       border-radius: 12px;
       font-size: 0.9rem;
       text-align: center;
       margin: auto;
       display: flex;
       margin-top: 35px !important;
    }
    .ml-4:hover{
       background-color: #444;
    }

    .mt-4 .password{
        display: inline-block;  
        padding-bottom: 0.5rem;
        white-space: nowrap;
        margin-left: 0 !important; 
        margin-right: auto !important;
        color: #444;
        font-size: 1rem;
        font-weight: bold;
        margin-top: 0.5rem;     
    }
    .text-sm{
        text-decoration:none;
        color: #444;
        font-size: 1rem;
    }
    .text-smi{
        text-decoration:none;
        color: #2fbab8;
        font-size: 1.1rem;
        font-weight: bold;
        margin-left: 0.5rem;   
        margin-top: 0.5rem;    
    }
    .text-smi:hover{
        text-decoration:none;
        color: #444;
    }
    
    .inputF{
        border: 1px solid #e5e4e2 !important;
        box-shadow: 2px 2px 2px 2px #f4f0ec !important;
    }
</style>