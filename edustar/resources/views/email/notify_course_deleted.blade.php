@component('mail::message')
Hi {{ $user_name }} !!
<br>


{{ $x }}
<br>
<br>

Thanks,<br>
{{ config('app.name') }}
@endcomponent