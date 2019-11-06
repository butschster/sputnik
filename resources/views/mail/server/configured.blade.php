@component('mail::message')
# Your server {{ $server->name }} has been successful configured!

Thanks,<br>
{{ config('app.name') }}
@endcomponent
