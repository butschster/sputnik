@component('mail::message')
# There is a new alert on your server {{ $alert->server->name }}.

**Type:** {{ $alert->type }}
**Problem:** {{ $alert->message() }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
