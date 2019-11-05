@component('mail::message')
# Your server {{ $server->name }} has successful configured!

Thanks,<br>
{{ config('app.name') }}
@endcomponent
