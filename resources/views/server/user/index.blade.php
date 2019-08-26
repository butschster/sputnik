@extends('layouts.app')

@section('sidebar')
    @include('server.partials.server_nav')
@endsection

@section('content')
    <div class="flex mb-4">
        <h1 class="flex-1">
            Server users
        </h1>

        <div class="mb-4">
            <a class="btn btn-outline" href="{{ route('server.show', $server) }}">
                <i class="fas fa-arrow-left"></i> Back to server
            </a>
        </div>
    </div>

    @if($server->isConfigured())
        <section class="section mb-16 mt-8">
            <div class="section-header">
                Create a new user
                <p>Enter a domain that you own below and start managing your DNS within your DigitalOcean account.</p>
            </div>
            <form action="{{ route('server.user.store', $server) }}" method="POST">
                @csrf

                <div class="flex">
                    <div class="form-group form-group-labeled is-required flex-1 mr-6 @error('name') is-invalid @enderror">
                        <input type="text" class="form-control" name="name" id="name"
                               value="{{ old('name') }}" autofocus placeholder="Name">
                        <label for="name">Name</label>

                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group form-group-labeled mr-6 @error('password') is-invalid @enderror">
                        <input type="password" class="form-control" name="password" id="password"
                               value="{{ old('password') }}" placeholder="Password">
                        <label for="password">Password</label>

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group mb-0">
                        <button class="btn btn-primary">Create</button>
                    </div>
                </div>
            </form>
        </section>
    @endif

    <h4>Users</h4>
    <table class="table mb-10">
        <col>
        <col width="200px">
        <col width="200px">
        <col width="100px">
        <thead>
        <tr>
            <th>Name</th>
            <th>Sudo password</th>
            <th>Home</th>
            <th></th>
        </tr>
        </thead>
        @foreach($users as $user)
            <tr>
                <th>{{ $user->name }}</th>
                <td>{{ $user->sudo_password }}</td>
                <td>{{ $user->homeDir() }}</td>
                <td class="text-right">
                    <a href="{{ route('server.user.download', [$server, $user]) }}"
                       class="btn btn-primary btn-sm"><i
                                class="fas fa-download"></i></a>
                    @if(!$user->isSystem())
                        <form class="float-right" action="{{ route('server.user.delete', [$server, $user]) }}"
                              method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                        </form>
                    @endif
                </td>
            </tr>
        @endforeach
    </table>

    @include('server.partials.tasks')
@endsection
