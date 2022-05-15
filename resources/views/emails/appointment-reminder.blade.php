@component('mail::message')

Sveiki,
Primename, kad <b>{{ $visitDate }} ({{ $visitDentist }})</b> laukiame Jūsų Odontologijos klinikoje.

{{ config('app.mailFooter') }}<br>
{{ config('app.mailFooter2') }}
@endcomponent
