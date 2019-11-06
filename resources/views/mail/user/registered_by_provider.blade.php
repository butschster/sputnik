@component('mail::message')
# Thanks for registering on our website SputnikCloud.com!

Dear {{ $user->name }},

We're happy you're here.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
