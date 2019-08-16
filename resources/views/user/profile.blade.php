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
                    <th></th>
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
                                <small>Unlimited</small>
                            @elseif($feature->type == 'feature')
                                <i class="fas fa-check text-success"></i>
                            @else
                                <small>{{ $subscription->getRemainingOf($feature->code) }} remains</small>
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
