@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-3">
                @include('server.partials.nav')
            </div>
            <div class="col-9">
                <div class="mb-4">
                    <a class="btn btn-outline-primary" href="{{ route('server.show', $server) }}">
                        <i class="fas fa-arrow-left"></i> Back to server
                    </a>
                </div>

                <h2 class="mb-4">
                    <i class="fas fa-users mr-3"></i> Server users
                </h2>

                @if($server->isConfigured())
                <div class="card">
                        <div class="card-header">Create a new user</div>
                        <form action="{{ route('server.user.store', $server) }}" method="POST" class="card-body">
                            @csrf

                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                       value="{{ old('name') }}" required autofocus>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
                                @enderror
                            </div>

                            <div class="form-group mb-0">
                                <button class="btn btn-primary">Create</button>
                            </div>
                        </form>
                </div>
                @endif

                <div class="card mt-3">
                    <table class="table mb-0">
                        <col>
                        <col width="100px">
                        <col width="100px">
                        <col width="100px">
                        <thead class="thead-dark">
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
                                    <a href="{{ route('server.user.download', [$server, $user]) }}" class="btn btn-primary btn-sm"><i class="fas fa-download"></i></a>
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
                </div>
            </div>
        </div>
    </div>
@endsection
