@component('mail::message')
# New deployment is running on your server {{ $server->name }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
