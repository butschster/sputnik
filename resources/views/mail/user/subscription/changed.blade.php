@component('mail::message')
# Your subscription plan has been updated.

Thank you for using our service!

**New plan:** {{ $plan->name }}

@if($subscription->onTrial())
**Trial ends at:** {{ $subscription->trial_ends_at }}
@endif

Thanks,<br>
{{ config('app.name') }}
@endcomponent
