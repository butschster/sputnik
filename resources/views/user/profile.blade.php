@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">Hello {{ $user->name }}</div>

            <div class="card-body">
                <h4>Current subscription: <strong>{{ $user->activeSubscription()->plan->name }}</strong></h4>
            </div>
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
