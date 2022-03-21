<!DOCTYPE html>
<html>
<head>
    <!--font awesome cdn link-->
    <link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
        <div>
    </div>
        <div class = "txt-lg"><i id = icon class="fas fa-tooth"></i>Odontologijos klinika</div>
        <div class = "txt-lb"> Prisijungimas </div>
            <!--<x-jet-authentication-card-logo />-->
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div>
               <x-jet-label for="email" value="{{ __('El. paštas') }}" /></div>
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </id>

            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('Slaptažodis') }}" />
                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            </div>

            <!--<div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-jet-checkbox id="remember_me" name="remember" />
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>-->
            <x-jet-button class="ml-4">
                    {{ __('Prisijungti') }}
                </x-jet-button>
            <div class="flex items-center justify-end mt-4">
                
                @if (Route::has('password.request'))
               
                <div class = "lb-psw"> Pamiršote slaptažodį? <a class="text-smi" href="{{ route('password.request') }}">
                    {{ __('Priminti') }}
                    </a></div>
                @endif
                </div>
                <div class = "lb-psws"> Neturite paskyros? <a class="text-smi" href="{{ route('register') }}">
                {{ __('Registruotis') }}
                </a></div>

               
            
        </form>
    </x-jet-authentication-card>
</x-guest-layout>

<style>
    #icon {
        color: #16a085;
        margin-top: 1rem;   
    }
    .txt-lg{
        text-align: center;
        padding-top: 5px;
        padding-bottom: 80px;
        color: #16a085;
        font-size: 3.2rem;
        
    }
    .txt-lb{
        text-align: center;
        padding-top: 10px;
        font-size: 1.9rem;
        color: #444;
        font-weight: bold;
        
    }
    .ml-4{
       background-color: #16a085;
       border-radius: 12px;
       font-size: 1rem;
       margin-top: 30px;
       margin-left: 30%;
       margin-right: 30%
    }
    .ml-4:hover{
       background-color: #444;
    }
    .lb-psw{
        display: inline-block;  
        padding-bottom: 1rem;
        white-space: nowrap;
        padding: 15px 137px 0px 1px;
        color: #444;
        font-size: 1.12rem;
        font-weight: bold;
        float: left;    
    }
    .lb-psws{
        display: inline-block;  
        padding-bottom: 1rem;
        white-space: nowrap;
        padding: 5px 72px 0px 1px;
        color: #444;
        font-size: 1.12rem;
        font-weight: bold;      
    }
    .text-sm{
        text-decoration:none;
        color: #444;
        font-size: 1.1rem;
    }
    .text-smi{
        text-decoration:none;
        color: #16a085;
        font-size: 1.12rem;
        font-weight: bold;
        margin-left: 0.5rem;   
        
    }
    .text-smi:hover{
        text-decoration:none;
        color: #444;
    }
    .label{
        font-size: 5rem;
        color: #444;
    }
</style>