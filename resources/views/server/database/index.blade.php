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
                    <i class="fas fa-database mr-3"></i> Database
                </h2>

                @can('store', [\App\Models\Server\Database::class, $server])
                <div class="card">
                        <div class="card-header">Create a new one</div>
                        <form action="{{ route('server.database.store', $server) }}" method="POST" class="card-body">
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

                            <div class="form-group">
                                <label>Password (Optional)</label>
                                <input type="text" class="form-control @error('password') is-invalid @enderror" name="password"
                                       value="{{ old('password') }}">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group mb-0">
                                <button class="btn btn-primary">Store</button>
                            </div>
                        </form>
                </div>
                @endcan
                <div class="card mt-3">
                    <table class="table mb-0">
                        <col>
                        <col width="100px">
                        <col width="100px">
                        <col width="100px">
                        <col width="50px">
                        <thead class="thead-dark">
                        <tr>
                            <th>Name</th>
                            <th>User</th>
                            <th>Password</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                        </thead>
                        @foreach($databases as $database)
                            <tr>
                                <th>{{ $database->name }}</th>
                                <th>{{ $database->name }}</th>
                                <td>{{ $database->password }}</td>
                                <td><span class="badge badge-dark">{{ $database->taskStatus() }}</span></td>
                                <td>
                                    <form class="float-right" action="{{ route('server.database.delete', [$database->server_id, $database]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>

                @include('server.partials.tasks')
            </div>
        </div>
    </div>
@endsection
