@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-body flex items-center">
            <img src="https://api.adorable.io/avatars/161/abott@adorable.png" alt="" class="h-32 rounded-full">
            <div class="ml-10 flex-1">
                <a href="#" class="btn btn-default btn-lg float-right">Edit profile</a>

                <h2>{{ $user->name }}</h2>
                <div class="text-gray-700">Member since {{ $user->created_at->format('d/m/Y') }}</div>
            </div>
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

    <section class="section mt-12">
        <div class="section-header">
            Source Control
        </div>

        <div class="section-body">
            <a class="btn btn-outline mr-5" href="{{ route('login.github') }}">
                <i class="fab fa-github mr-1"></i>
                Github
            </a>
            <a class="btn btn-outline" href="{{ route('login.bitbucket') }}">
                <i class="fab fa-bitbucket mr-1"></i>
                Bitbucket
            </a>
        </div>
    </section>

    <section class="section flex items-center mt-16 pt-12">
        <div class="flex-1">
            <div class="section-header">
                Deactivate account
                <p class="text-gray-600">This will remove your account from all teams and disable your account.</p>
            </div>
        </div>
        <div>
            <form action="">
                <button class="btn btn-danger">
                    Deactivate account
                </button>
            </form>
        </div>
    </section>
@endsection
