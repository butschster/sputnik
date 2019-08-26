@extends('layouts.app')

@section('sidebar')
    @include('server.partials.server_nav')
@endsection

@section('content')
    <div class="flex mb-4">
        <h1 class="flex-1">
            <i class="fas fa-database mr-3"></i> Database
        </h1>

        <div class="mb-4">
            <a class="btn btn-outline" href="{{ route('server.show', $server) }}">
                <i class="fas fa-arrow-left"></i> Back to server
            </a>
        </div>
    </div>

    @can('store', [\App\Models\Server\Database::class, $server])
        <section class="section pb-8 mb-10">
            <div class="section-header">
                Create a new one
                <p>You can easily mange databases on your server</p>
            </div>
            <form action="{{ route('server.database.store', $server) }}" method="POST" class="section-body">
                @csrf

                <div class="flex">
                    <div class="form-group w-3/4 form-group-labeled mr-6 is-required @error('name') is-invalid @enderror">
                        <input type="text" class="form-control" name="name" id="name"
                               value="{{ old('name') }}" placeholder="Name">
                        <label for="name">Name</label>

                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group w-1/4 form-group-labeled mr-6 @error('password') is-invalid @enderror">
                        <input type="text" class="form-control" name="password" id="password"
                               value="{{ old('password') }}" placeholder="Password (Optional)">
                        <label for="password">Password (Optional)</label>

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <button class="btn btn-primary">Store</button>
                    </div>
                </div>
            </form>
        </section>
    @endcan

    <h4>Databases</h4>
    <table class="table">
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
                    <form class="float-right"
                          action="{{ route('server.database.delete', [$database->server_id, $database]) }}"
                          method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>

    @include('server.partials.tasks')
@endsection
