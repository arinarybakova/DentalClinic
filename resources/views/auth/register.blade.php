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
        <div class = "txt-lb"> Registracija </div>
        <x-jet-validation-errors class="mb-4" />
        </x-slot>
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mt-4">
                <x-jet-label for="firstname" value="{{ __('Vardas') }}" />
                <x-jet-input id="firstname" class="block mt-1 w-full" type="text" name="name" :value="old('firstname')" required autofocus autocomplete="firstname" />
            </div>
            <div class="mt-4">
                <x-jet-label for="lastname" value="{{ __('Pavardė') }}" />
                <x-jet-input id="lastname" class="block mt-1 w-full" type="text" name="lastname" :value="old('lastname')" required autofocus autocomplete="lastname" />
            </div>

            <div class="mt-4">
                <x-jet-label for="email" value="{{ __('El. paštas') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            </div>
            
            <div>
                <x-jet-label for="phone" value="{{ __('Tel. numeris') }}" />
                <x-jet-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" required autofocus autocomplete="phone" />
            </div>

            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('Slaptažodis') }}" />
                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-jet-label for="password_confirmation" value="{{ __('Pakartokite slaptažodį') }}" />
                <x-jet-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
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
        font-size: 3.2rem;     
    }
    .mt-4{
       margin-bottom: 1rem;
    }
    .txt-lb{
        text-align: center;
        padding-top: 8px;
        font-size: 1.9rem;
        color: #444;
        font-weight: bold;     
    }
    .ml-4{
       background-color: #2fbab8;
       border-radius: 12px;
       font-size: 1rem;
       margin-top: 15px;
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
        padding: 5px 76px 0px 1px;
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
</style>