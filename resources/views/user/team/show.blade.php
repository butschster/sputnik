@extends('layouts.app')

@section('content')
    <div class="container">
        @if(!$subscription->valid())
            <div class="alert alert-warning">
                Your subscription is expired. Please renew it.

                <form class="float-right" action="{{ route('user.subscription.renew') }}" method="POST">
                    @csrf
                    <button class="btn btn-success btn-sm">Renew</button>
                </form>
            </div>
        @endif

        <div class="card mb-4">
            <div class="card-header">Members</div>
            <div class="list-group list-group-flush">
                @foreach($users as $user)
                    <div class="list-group-item">
                        {{ $user->name }}

                        @role('owner')
                        <span class="badge badge-primary float-right">owner</span>
                        @endrole
                    </div>
                @endforeach
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                Current subscription: <strong>{{ $subscription->plan->name }}</strong>

                @if($subscription->onTrial())
                    <span class="badge badge-warning">Trial ends at {{ $subscription->trial_ends_at }}</span>
                @endif

                @if(!$subscription->cancelled())
                    <form class="float-right" action="{{ route('user.subscription.cancel', $team) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Cancel</button>
                    </form>
                @else
                    <span class="badge badge-danger">Canceled</span>
                @endif
            </div>

            <table class="table">
                <col width="200px">
                <col>
                <thead>
                <tr>
                    <th>Feature</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($subscription->plan->features as $feature)
                    <tr>
                        <th>
                            {{ $feature->code }}
                        </th>
                        <td>
                            @if($feature->isUnlimited())
                                <small>Unlimited</small>
                            @else
                                <small>{{ $team->getRemainingOf($feature->code) }} remains</small>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <form action="{{ route('team.subscribe', $team) }}" method="POST" class="card mt-5">
            @csrf

            <div class="card-body">
                <input id="card-holder-name" class="form-control" type="text" value="{{ $team->name }}">

                <!-- Stripe Elements Placeholder -->
                <div id="card-element"></div>
            </div>

            <div class="card-body">
                @include('user.partials.plans')
                <button type="button" id="card-button" data-secret="{{ $intent->client_secret }}" class="btn btn-primary btn-lg">
                    Change subscription
                </button>
            </div>
        </form>
    </div>

    <script src="https://js.stripe.com/v3/"></script>

    <script>
        const stripe = Stripe('{{ config('services.stripe.key') }}');

        const elements = stripe.elements();
        const cardElement = elements.create('card');

        cardElement.mount('#card-element');

        const cardHolderName = document.getElementById('card-holder-name');
        const cardButton = document.getElementById('card-button');
        const clientSecret = cardButton.dataset.secret;

        cardButton.addEventListener('click', async (e) => {
            const { setupIntent, error } = await stripe.handleCardSetup(
                clientSecret, cardElement, {
                    payment_method_data: {
                        billing_details: { name: cardHolderName.value }
                    }
                }
            );

            if (error) {
                console.log(error)
            } else {
                console.log(setupIntent)
            }
        });
    </script>
@endsection
