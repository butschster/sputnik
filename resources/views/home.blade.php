@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Servers</div>

                <table class="table">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>IP Address</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    @foreach($servers as $server)
                        <tr>
                            <th><a href="{{ route('server.show', $server) }}">{{ $server->name }}</a></th>
                            <td>{{ $server->ip }}</td>
                            <td>{{ $server->status }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>

            <div class="card mt-4">
                <div class="card-header">Create server</div>

                <form action="{{ route('server.store') }}" method="POST" class="card-body">
                    @csrf

                    <input type="hidden" name="php_version" value="73">
                    <input type="hidden" name="database_type" value="mysql">

                    <div class="form-group">
                        <label>Server name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', 'Test server') }}" required autofocus>

                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-9">
                            <label>IP Addrress</label>
                            <input type="text" class="form-control @error('ip') is-invalid @enderror" name="ip" value="{{ old('ip', '167.71.3.113') }}" required autofocus>

                            @error('ip')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group col-md-3">
                            <label>SSH port</label>
                            <input type="text" class="form-control @error('port') is-invalid @enderror" name="ssh_port" value="{{ old('port', 22) }}" required autofocus>

                            @error('port')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col">
                            <label>PHP version</label>

                            <select name="php_version" class="form-control @error('php_version') is-invalid @enderror">
                                <option value="72">PHP 7.2</option>
                                <option value="73" selected>PHP 7.3</option>
                            </select>

                            @error('php_version')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group col">
                            <label>Database</label>

                            <select name="database_type" class="form-control @error('database_type') is-invalid @enderror">
                                <option value="mysql" selected>MySQL</option>
                                <option value="mariadb" selected>MariaDB</option>
                                <option value="mysql8" selected>MySQL 8</option>
                                <option value="pgsql">PostgreSQL</option>
                            </select>

                            @error('database_type')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <button class="btn btn-primary">Создать</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
