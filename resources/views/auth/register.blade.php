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
            <div>
        </div>
        <div class = "txt-lg"><i id = icon class="fas fa-tooth"></i>Odontologijos klinika</div>
        <div class = "txt-lb"> Registracija </div>
        
        </x-slot>
        <x-jet-validation-errors class="mb-4" />
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mt-4">
                <x-jet-label for="firstname" value="{{ __('Vardas') }}" />
                <x-jet-input id="firstname" class="inputF w-full" type="text" name="name" :value="old('firstname')" required placeholder="Įveskite vardą" 
                oninvalid="this.setCustomValidity('Laukas vardas yra privalomas')"
                oninput="this.setCustomValidity('')"/>
            </div>
            <div class="mt-4">
                <x-jet-label for="lastname" value="{{ __('Pavardė') }}" />
                <x-jet-input id="lastname" class="inputF w-full" type="text" name="lastname" :value="old('lastname')" required placeholder="Įveskite pavardę" 
                oninvalid="this.setCustomValidity('Laukas pavardė yra privalomas')"
                oninput="this.setCustomValidity('')"/>
            </div>

            <div class="mt-4">
                <x-jet-label for="email" value="{{ __('El. paštas') }}" />
                <x-jet-input id="email" class="inputF w-full" type="email" name="email" :value="old('email')" required placeholder="Įveskite el. paštą" 
                oninvalid="this.setCustomValidity('Neteisingas el. pašto formatas')"
                oninput="this.setCustomValidity('')"/>
            </div>
            
            <div>
                <x-jet-label for="phone" value="{{ __('Tel. numeris') }}" />
                <x-jet-input id="phone" class="inputF w-full" type="text" name="phone" :value="old('phone')" required placeholder="Įveskite tel. numerį" 
                oninvalid="this.setCustomValidity('Laukas tel. numeris yra privalomas')"
                oninput="this.setCustomValidity('')"/>
            </div>

            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('Slaptažodis') }}" />
                <x-jet-input id="password" class="inputF w-full" type="password" name="password" required placeholder="Įveskite slaptažodį" 
                oninvalid="this.setCustomValidity('Laukas slaptažodis yra privalomas')"
                oninput="this.setCustomValidity('')"/>
            </div>

            <div class="mt-4">
                <x-jet-label for="password_confirmation" value="{{ __('Pakartokite slaptažodį') }}" />
                <x-jet-input id="password_confirmation" class="inputF w-full" type="password" name="password_confirmation" required placeholder="Dar kartą įveskite slaptažodį" 
                oninvalid="this.setCustomValidity('Laukas pakartokite slaptažodį yra privalomas')"
                oninput="this.setCustomValidity('')"/>
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-jet-label for="terms">
                        <div class="flex items-center">
                            <x-jet-checkbox name="terms" id="terms"/>

                            <div class="ml-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-jet-label>
                </div>
            @endif
            <x-jet-button class="ml-4">
                    {{ __('Registruotis') }}
                </x-jet-button>
            <div class="flex items-center justify-end mt-4">
            <div class = "lb-psws"> Turite paskyrą? <a class="text-smi" href="{{ route('login') }}">
                    {{ __('Prisijungti') }}
                </a></div>      
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

    .lb-psws{
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

       /* For laptop 1366 Resolution */  
@media only screen   
and (min-width: 1030px)   
and (max-width: 1366px) {

    .txt-lg{
        padding-top: 5px;
        padding-bottom: 12px;
        font-size: 1.8rem;     
    }
    .mt-4{
       margin-bottom: 0.8rem;
    }
    .txt-lb{
        padding-top: 8px;
        font-size: 1.4rem;    
    }
    .ml-4{
       font-size: 0.9rem;
       margin-top: 30px !important;
    }

    .lb-psws{
        padding-bottom: 0.5rem;
        font-size: 1rem;
        margin-top: 0.5rem;     
    }
    .text-sm{
        font-size: 1rem;
    }
    .text-smi{
        font-size: 1rem;
        margin-left: 0.5rem;   
        margin-top: 0.5rem;    
    } 
} 
/* For laptop 1024 Resolution */  
@media only screen   
and (min-device-width : 768px)   
and (max-device-width : 1024px)  {
    .txt-lg{
        padding-top: 5px;
        padding-bottom: 12px;
        font-size: 1.6rem;     
    }
    .mt-4{
       margin-bottom: 0.8rem;
    }
    .txt-lb{
        padding-top: 8px;
        font-size: 1.2rem;    
    }
    .ml-4{
       font-size: 0.8rem;
       margin-top: 30px !important;
    }

    .lb-psws{
        padding-bottom: 0.5rem;
        font-size: 1rem;
        margin-top: 0.5rem;     
    }
    .text-sm{
        font-size: 1rem;
    }
    .text-smi{
        font-size: 1rem;
        margin-left: 0.5rem;   
        margin-top: 0.5rem;    
    } 
}
@media only screen   
and (min-device-width : 641px)   
and (max-device-width : 767px){

    .txt-lg{
        padding-top: 5px;
        padding-bottom: 12px;
        font-size: 1.6rem;     
    }
    .mt-4{
       margin-bottom: 0.8rem;
    }
    .txt-lb{
        padding-top: 8px;
        font-size: 1.2rem;    
    }
    .ml-4{
       font-size: 0.8rem;
       margin-top: 30px !important;
    }

    .lb-psws{
        padding-bottom: 0.5rem;
        font-size: 1rem;
        margin-top: 0.5rem;     
    }
    .text-sm{
        font-size: 1rem;
    }
    .text-smi{
        font-size: 1rem;
        margin-left: 0.5rem;   
        margin-top: 0.5rem;    
    }     
}
/* For mobile 640 Resolution */  
@media only screen   
and (min-device-width : 360px)   
and (max-device-width : 640px){

    .txt-lg{
        padding-top: 5px;
        padding-bottom: 12px;
        font-size: 1.6rem;     
    }
    .mt-4{
       margin-bottom: 0.8rem;
    }
    .txt-lb{
        padding-top: 8px;
        font-size: 1.2rem;    
    }
    .ml-4{
       font-size: 0.8rem;
       margin-top: 30px !important;
    }

    .lb-psws{
        padding-bottom: 0.5rem;
        font-size: 1rem;
        margin-top: 0.5rem;     
    }
    .text-sm{
        font-size: 1rem;
    }
    .text-smi{
        font-size: 1rem;
        margin-left: 0.5rem;   
        margin-top: 0.5rem;    
    } 
} 
</style>