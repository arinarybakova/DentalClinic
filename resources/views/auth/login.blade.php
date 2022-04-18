
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
                <x-jet-input id="email" class="mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </id>

            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('Slaptažodis') }}" />
                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password"/>
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
        color: #2fbab8;
        margin-top: 1rem;   
    }
    .txt-lg{
        text-align: center;
        padding-top: 5px;
        padding-bottom: 80px;
        color: #2fbab8;
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
       background-color: #2fbab8;
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
        color: #2fbab8;
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
    .mt-1 .w-full{
        border-color: #2fbab8 !important;
        border-width: 1px !important;
    }
    /* For laptop 1024 Resolution */  
    @media only screen   
            and (min-device-width : 768px)   
            and (max-device-width : 1024px)  {
        #icon {
            margin-top: 1rem;
            font-size: 2rem;  
        }
        .txt-lg {
            text-align: center;
            padding-top: 5px;
            padding-bottom: 60px;
            font-size: 2.2rem;
        }
        .txt-lb{
            text-align: center;
            font-size: 1.6rem;
        }
    }

    /* For laptop 1366 Resolution */  
    @media only screen   
        and (min-width: 1030px)   
        and (max-width: 1366px) {
        
            #icon {
            margin-top: 1rem;
            font-size: 2rem;  
        }
        .txt-lg {
            text-align: center;
            padding-top: 5px;
            padding-bottom: 60px;
            font-size: 2.2rem;
        }
        .txt-lb{
            text-align: center;
            font-size: 1.6rem;
        }
    } 
    /* For mobile 640 Resolution */  
    @media only screen   
        and (min-device-width : 360px)   
        and (max-device-width : 640px){

    } 
    /* For mobile 480 Resolution */  
    @media only screen   
    and (min-device-width : 320px)   
    and (max-device-width : 480px){
        #icon {
            margin-top: 1rem;
            font-size: 1.5rem;  
        }
        .txt-lg {
            text-align: center;
            padding-top: 5px;
            padding-bottom: 10px;
            font-size: 1.5rem;
        }
        .txt-lb{
            text-align: center;
            font-size: 1rem;
        }
        .mt-1{
            max-width: 340px;
        }
        .text-sm{
            font-size: 0.8rem;
        }

    }
</style>