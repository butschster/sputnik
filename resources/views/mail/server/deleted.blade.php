@component('mail::message')
# Your server {{ $server->name }} has been deleted!

Thanks,<br>
{{ config('app.name') }}
@endcomponent
