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
            {{ __('Pamiršote slaptažodį? Jei taip, įrašykite savo el. pašto adresą ir mes atsiųsime Jums slaptažodžio nustatymo nuorodą. Paspaudus šią nuorodą galėsite susikurti naują slaptažodį') }}
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
                <x-jet-input id="email" class="inputF w-full" type="email" name="email" :value="old('email')" required placeholder="Įveskite el. paštą" 
                oninvalid="this.setCustomValidity('Neteisingas el. pašto formatas')"
                oninput="this.setCustomValidity('')"/>
            </div>

            <div class="flex items-center justify-end mt-4">
                <div class = "reset">
                <x-jet-button>
                    {{ __('Išsiųsti slaptažodžio nustatymo nuorodą') }}
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
        font-size: 2rem;
        
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
    .inputF{
        border: 1px solid #e5e4e2 !important;
        box-shadow: 2px 2px 2px 2px #f4f0ec !important;
    }

@media only screen   
and (min-width: 1030px)   
and (max-width: 1366px) {

    .txt-lg{
        text-align: center;
        padding-top: 5px;
        padding-bottom: 80px;
        color: #2fbab8;
        font-size: 2rem;
        
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
   
} 
/* For laptop 1024 Resolution */  
@media only screen   
and (min-device-width : 768px)   
and (max-device-width : 1024px)  {

    .txt-lg{
        text-align: center;
        padding-top: 5px;
        padding-bottom: 80px;
        color: #2fbab8;
        font-size: 1.8rem;
        
    }
    .txt-lb{
        text-align: center;
        padding-top: 10px;
        font-size: 1.2rem;
        color: #444;
        font-weight: bold;
        
    }
    .text-sm{
        text-decoration:none;
        color: #444;
        font-size: 1rem;
    }
    
}
@media only screen   
and (min-device-width : 641px)   
and (max-device-width : 767px){

    .txt-lg{
        text-align: center;
        padding-top: 5px;
        padding-bottom: 80px;
        color: #2fbab8;
        font-size: 1.8rem;
        
    }
    .txt-lb{
        text-align: center;
        padding-top: 10px;
        font-size: 1.2rem;
        color: #444;
        font-weight: bold;
        
    }
    .text-sm{
        text-decoration:none;
        color: #444;
        font-size: 0.9rem;
    }
    
}
/* For mobile 640 Resolution */  
@media only screen   
and (min-device-width : 430px)   
and (max-device-width : 640px){
    .txt-lg{
        text-align: center;
        padding-top: 5px;
        padding-bottom: 80px;
        color: #2fbab8;
        font-size: 1.6rem;
        
    }
    .txt-lb{
        text-align: center;
        padding-top: 10px;
        font-size: 1.2rem;
        color: #444;
        font-weight: bold;
        
    }
    .text-sm{
        text-decoration:none;
        color: #444;
        font-size: 0.9rem;
    }
    .inputF{
        border: 1px solid #e5e4e2 !important;
        box-shadow: 2px 2px 2px 2px #f4f0ec !important;
        font-size: 0.8rem;
    }

} 
/* For mobile 480 Resolution */  
@media only screen   
and (min-device-width : 200px)   
and (max-device-width : 430px){

    .txt-lg{
        text-align: center;
        padding-top: 5px;
        padding-bottom: 80px;
        color: #2fbab8;
        font-size: 1.6rem;
        
    }
    .txt-lb{
        text-align: center;
        padding-top: 10px;
        font-size: 1.2rem;
        color: #444;
        font-weight: bold;
        
    }
    .text-sm{
        text-decoration:none;
        color: #444;
        font-size: 0.9rem;
    }
    .inputF{
        border: 1px solid #e5e4e2 !important;
        box-shadow: 2px 2px 2px 2px #f4f0ec !important;
        font-size: 0.6rem !important;
    }
}
</style>