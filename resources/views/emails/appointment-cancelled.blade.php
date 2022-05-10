@component('mail::message')

Sveiki,
Jūsų vizitas <b>{{ $visitDate }} ({{ $visitDentist }})</b> buvo atšauktas. Prašome prisijungti prie sistemos ir rezervuoti naują vizitą.

{{ config('app.mailFooter') }}<br>
{{ config('app.mailFooter2') }}
@endcomponent
