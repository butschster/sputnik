@extends('layouts.app')

@section('content')
    @if(!$subscription->valid())
        <div class="alert alert-warning">
            Your subscription is expired. Please renew it.

            <form class="float-right" action="{{ route('user.subscription.renew') }}" method="POST">
                @csrf
                <button class="btn btn-success btn-sm">Renew</button>
            </form>
        </div>
    @endif

    <div class="user-block">
        <h2>Members</h2>

        <div class="user-block__list">
            @foreach($users as $user)
                <div class="user-block__item">
                    <div class="user-info">
                        <img src="https://api.adorable.io/avatars/161/abott@adorable.png" alt="" class="user-info--avatar">
                        <div class="user-info--name">
                            <a href="{{ route('user.profile') }}">{{ $user->name }}</a>
                            <div class="user-info--email">
                                {{ $user->email }}
                            </div>
                        </div>
                    </div>

                    @if($user->hasRole('owner', $team))
                        <span class="user-block__item--role">owner</span>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    @include('user.partials.plans')

    <div class="card mb-4">
        <div class="card-header">
            Payment method
            <p>This will replace your current payment method.</p>
        </div>
        <div class="card-body">
            <form action="" class="mt-8">
                <div class="flex">
                    <div class="form-group flex-1 mr-5">
                        <input type="text" id="card" class="form-control" name="card" autofocus
                               placeholder="Card number">
                    </div>
                    <div class="form-group mr-5">
                        <input type="text" id="date" class="form-control" name="date"
                               placeholder="MM/YY">
                    </div>
                    <div class="form-group">
                        <input type="text" id="cvc" class="form-control" name="cvc"
                               placeholder="CVC">
                    </div>
                </div>
                <div class="form-group mt-2">
                    <button class="btn btn-primary btn-lg">Update</button>
                </div>
            </form>
        </div>
    </div>


    <div class="border-gray-300 bg-gray-100 py-8 px-8 my-12 flex items-center">
        <div class="flex-1">
            <h2>Cancel subscription</h2>
            <p>Pavel, just before you go, here are some courses we've got coming up that you might be interested in.</p>
        </div>
        <div>
            <form action="">
                <button class="btn btn-lg btn-danger">
                    Cancel :(
                </button>
            </form>
        </div>
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
            const {setupIntent, error} = await stripe.handleCardSetup(
                clientSecret, cardElement, {
                    payment_method_data: {
                        billing_details: {name: cardHolderName.value}
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
