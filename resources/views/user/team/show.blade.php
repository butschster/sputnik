@extends('layouts.app')

@section('content')
    <div class="container">
        @if(!$subscription->isActive())
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
                @elseif(!$subscription->isEnded())
                    <span class="badge badge-primary">Ends at {{ $subscription->ends_at }}</span>
                @endif

                @if(!$subscription->isCanceled())
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

        <form action="{{ route('team.subscribe', $team) }}" method="POST">
            @csrf
            @include('user.partials.plans')
            <button class="btn btn-primary btn-lg">Change subscription</button>
        </form>
    </div>
@endsection
