@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">Current subscription: <strong>{{ $subscription->plan->name }}</strong></div>

            <table class="table">
                <col width="200px">
                <col>
                <thead>
                <tr>
                    <th>Feature</th>
                    <th>Remains</th>
                </tr>
                </thead>
                <tbody>
                @foreach($subscription->plan->features as $feature)
                    <tr>
                        <th>
                            {{ $feature->name }}
                        </th>
                        <td>
                            @if($feature->isUnlimited())
                                Unlimited
                            @else
                                {{ $subscription->getRemainingOf($feature->code) }}
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="card mt-4">
            <div class="card-header">Source Control</div>

            <div class="card-body">
                <a class="btn btn-outline-dark" href="{{ route('login.github') }}">
                    <i class="fab fa-github mr-1"></i>
                    Github
                </a>
                <a class="btn btn-outline-dark" href="{{ route('login.bitbucket') }}">
                    <i class="fab fa-bitbucket mr-1"></i>
                    Bitbucket
                </a>
            </div>
        </div>
    </div>
@endsection
