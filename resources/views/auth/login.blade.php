
<!DOCTYPE html>
<html>
<head>
    <!--font awesome cdn link-->
    <link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
     <!--custom css file link-->
     <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1" >
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
                <x-jet-input id="email" class="inputF w-full " type="email" name="email" :value="old('email')"  required placeholder="Įveskite el. paštą" 
                oninvalid="this.setCustomValidity('Neteisingas el. pašto formatas')"
                oninput="this.setCustomValidity('')"/>
            

            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('Slaptažodis') }}" />
                <x-jet-input id="password" class="inputF w-full" type="password" name="password" autocomplete="current-password" required placeholder="Įveskite slaptažodį" 
                oninvalid="this.setCustomValidity('Laukas slaptažodis yra privalomas')"
                oninput="this.setCustomValidity('')"/>
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
        font-size: 2.2rem;
        
    }
    .txt-lb{
        text-align: center;
        padding-top: 10px;
        font-size: 1.6rem;
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
        margin-left: 0 !important; 
        margin-right: auto !important;
        color: #444;
        font-size: 1rem;
        font-weight: bold;
           
    }
    .lb-psws{
        display: inline-block;  
        padding-bottom: 1rem;
        white-space: nowrap;
        padding: 5px 72px 0px 1px;
        color: #444;
        font-size: 1rem;
        font-weight: bold;      
    }
    .text-sm{
        text-decoration:none;
        color: #444;
        font-size: 1rem;
    }
    .text-smi{
        text-decoration:none;
        color: #2fbab8;
        font-size: 1rem;
        font-weight: bold;
        margin-left: 0.5rem;   
        
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
    #icon {   
        margin-top: 1rem;   
    }
    .txt-lg{
        padding-top: 3px;
        padding-bottom: 60px;
        font-size: 2rem;
        
    }
    .txt-lb{
        padding-top: 10px;
        font-size: 1.4rem;  
    }
    .ml-4{
       background-color: #2fbab8;
       border-radius: 12px;
       font-size: 0.8rem;
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
        padding: 10px 185px 0px 1px !important;
        font-size: 0.9rem;
    }
    .lb-psws{
        display: inline-block;  
        padding-bottom: 1rem;
        white-space: nowrap;
        padding: 5px 72px 0px 1px;
        font-size: 0.9rem;    
    }
    .text-sm{
        font-size: 0.9rem;
    }
    .text-smi{
        font-size: 0.9rem;
        margin-left: 0.5rem;   
        
    }
} 
/* For laptop 1024 Resolution */  
@media only screen   
and (min-device-width : 768px)   
and (max-device-width : 1024px)  {
    #icon {   
        margin-top: 1rem;   
    }
    .txt-lg{
        padding-top: 3px;
        padding-bottom: 50px;
        font-size: 1.6rem;
        
    }
    .txt-lb{
        padding-top: 10px;
        font-size: 1.2rem;  
    }
    .ml-4{
       background-color: #2fbab8;
       border-radius: 12px;
       font-size: 0.8rem;
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
        padding: 10px 208px 0px 1px !important;
        font-size: 0.8rem;
    }
    .lb-psws{
        display: inline-block;  
        padding-bottom: 1rem;
        white-space: nowrap;
        padding: 5px 72px 0px 1px;
        font-size: 0.8rem;    
    }
    .text-sm{
        font-size: 0.8rem;
    }
    .text-smi{
        font-size: 0.8rem;
        margin-left: 0.5rem;        
    }
}
@media only screen   
and (min-device-width : 641px)   
and (max-device-width : 767px){
    #icon {   
        margin-top: 1rem;   
    }
    .txt-lg{
        padding-top: 3px;
        padding-bottom: 50px;
        font-size: 1.6rem;
        
    }
    .txt-lb{
        padding-top: 10px;
        font-size: 1.2rem;  
    }
    .ml-4{
       background-color: #2fbab8;
       border-radius: 12px;
       font-size: 0.8rem;
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
        padding: 10px 208px 0px 1px !important;
        font-size: 0.8rem;
    }
    .lb-psws{
        display: inline-block;  
        padding-bottom: 1rem;
        white-space: nowrap;
        padding: 5px 72px 0px 1px;
        font-size: 0.8rem;    
    }
    .text-sm{
        font-size: 0.8rem;
    }
    .text-smi{
        font-size: 0.8rem;
        margin-left: 0.5rem;        
    }
}
/* For mobile 640 Resolution */  
@media only screen   
and (min-device-width : 360px)   
and (max-device-width : 640px){
    #icon {   
        margin-top: 1rem;   
    }
    .txt-lg{
        padding-top: 3px;
        padding-bottom: 50px;
        font-size: 1.4rem;
        
    }
    .txt-lb{
        padding-top: 10px;
        font-size: 1rem;  
    }
    .ml-4{
       background-color: #2fbab8;
       border-radius: 12px;
       font-size: 0.7rem;
       margin-top: 30px;
       margin-left: 30%;
       margin-right: 30%;
    
        padding: 30px;
    }
    .ml-4:hover{
       background-color: #444;
    }
    /* priminti */
    .lb-psw{
        display: inline-block;  
        padding-bottom: 0.5rem;
        white-space: nowrap;
        margin-left: 0; 
        margin-right: auto;
        font-size: 0.8rem;
    }
    /* neturite paskyros */
    .lb-psws{
        display: inline-block;  
        padding-bottom: 0.5rem;
        white-space: nowrap;
        margin-left:auto !important;
        margin-right:auto !important;
        font-size: 0.8rem;    
    }
    .text-sm{
        font-size: 0.8rem;
    }
    .text-smi{
        font-size: 0.8rem;
        margin-left: 0.5rem;        
    }

} 
/* For mobile 480 Resolution */  
@media only screen   
and (min-device-width : 401px)   
and (max-device-width : 480px){

    #icon {   
        margin-top: 1rem;   
    }
    .txt-lg{
        padding-top: 3px;
        padding-bottom: 50px;
        font-size: 1.4rem;
        
    }
    .txt-lb{
        padding-top: 10px;
        font-size: 1rem;  
    }
    .ml-4{
       background-color: #2fbab8;
       border-radius: 12px;
       font-size: 0.7rem;
       margin-top: 30px;
       margin-left: 30%;
       margin-right: 30%;
    
        padding: 30px;
    }
    .ml-4:hover{
       background-color: #444;
    }
    /* priminti */
    .lb-psw{
        display: inline-block;  
        padding-bottom: 0.5rem;
        white-space: nowrap;
        margin-left: 0 !important; 
        margin-right: auto !important;
        font-size: 0.8rem;
        
    }
    /* neturite paskyros */
    .lb-psws{
        display: inline-block;  
        padding-bottom: 0.5rem;
        white-space: nowrap;
        margin-left:auto !important;
        margin-right:auto !important;
     
        
        font-size: 0.8rem;    
    }
    .text-sm{
        font-size: 0.8rem;
    }
    .text-smi{
        font-size: 0.8rem;
        margin-left: 0.5rem;        
    }    
}
@media only screen   
and (min-width: 1144px)   
and (max-width: 1231px) {

    


}
@media only screen   
and (min-width: 1025px)   
and (max-width: 1143px) {
    

}

@media only screen   
and (min-device-width : 320px)   
and (max-device-width : 400px){

    #icon {   
        margin-top: 1rem;   
    }
    .txt-lg{
        padding-top: 3px;
        padding-bottom: 30px;
        font-size: 1rem;
        
    }
    .txt-lb{
        padding-top: 10px;
        font-size: 1rem;  
    }
    .ml-4{
       background-color: #2fbab8;
       border-radius: 12px;
       font-size: 0.7rem;
       margin-top: 30px;
       margin-left: 30%;
       margin-right: 30%;
    
        padding: 30px;
    }
    .ml-4:hover{
       background-color: #444;
    }
    /* priminti */
    .lb-psw{
        display: inline-block;  
        padding-bottom: 0.5rem;
        white-space: nowrap;
        margin-left: 10px; 
        margin-right: auto;
        font-size: 0.8rem;
        left: 0 !important;
      
        
    }
    /* neturite paskyros */
    .lb-psws{
        display: inline-block;  
        padding-bottom: 0.5rem;
        white-space: nowrap;
          
        font-size: 0.8rem;    
    }
    .text-sm{
        font-size: 0.8rem;
    }
    .text-smi{
        font-size: 0.8rem;
        margin-left: 0.5rem;        
    }
}
@media only screen   
and (min-device-width : 180px)   
and (max-device-width : 327px){

    #icon {   
        margin-top: 0.6rem;   
    }
    .txt-lg{
        padding-top: 3px;
        padding-bottom: 30px;
        font-size: 0.8rem;
        
    }
    .txt-lb{
        padding-top: 10px;
        font-size: 1rem;  
    }
    .ml-4{
       background-color: #2fbab8;
       border-radius: 12px;
       font-size: 0.5rem;
       margin-top: 30px;
       margin-left: 30%;
       margin-right: 30%;
    
        padding: 30px;
    }
    .ml-4:hover{
       background-color: #444;
    }
    /* priminti */
    .lb-psw{
        padding-bottom: 0.5rem;
        font-size: 0.7rem;  
    }
    /* neturite paskyros */
    .lb-psws{ 
        padding-bottom: 0.5rem;
        font-size: 0.7rem;    
    }
    .text-sm{
        font-size: 0.7rem;
    }
    .text-smi{
        font-size: 0.7rem;
        margin-left: 0.5rem;        
    }
}
</style>