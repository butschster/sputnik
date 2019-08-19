@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
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

        <div class="card mt-4">
            <div class="card-header">Teams</div>

            <div class="list-group list-group-flush">
                @foreach($teams as $team)
                <a href="{{ route('team.show', $team) }}" class="list-group-item">
                    {{ $team->name }}
                </a>
                @endforeach
            </div>
        </div>
    </div>
@endsection
