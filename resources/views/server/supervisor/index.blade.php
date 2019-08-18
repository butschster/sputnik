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
                    <i class="fas fa-clock mr-3"></i> Supervisor
                </h2>

                @can('store', [\App\Models\Server\Daemon::class, $server])
                    <div class="card">
                        <div class="card-header">New daemon</div>
                        <form action="{{ route('server.supervisor.store', $server) }}" method="POST" class="card-body">
                            @csrf
                            <input type="hidden" name="user" value="root">

                            <div class="form-group">
                                <label>Command</label>
                                <input type="text" class="form-control @error('command') is-invalid @enderror"
                                       name="command"
                                       value="{{ old('command') }}" required autofocus>

                                @error('command')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Number of processes</label>
                                <input type="number" class="form-control @error('processes') is-invalid @enderror"
                                       name="processes"
                                       value="{{ old('processes', 1) }}" required autofocus>

                                @error('processes')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group mb-0">
                                <button class="btn btn-primary">Start</button>
                            </div>
                        </form>
                    </div>
                @endcan

                <div class="card mt-3">
                    <div class="card-header">
                        <i class="fas fa-clock fa-lg mr-3"></i> Supervisor
                    </div>
                    <table class="table mb-0">
                        <col>
                        <col width="100px">
                        <col>
                        <col width="50px">
                        <col width="100px">
                        <col width="50px">
                        <thead class="thead-dark">
                        <tr>
                            <th>Command</th>
                            <th>User</th>
                            <th>Directory</th>
                            <th>Procs</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                        </thead>
                        @foreach($daemons as $daemon)
                            <tr>
                                <th>{{ $daemon->command }} <br><small class="text-muted">{{ $daemon->id }}</small></th>
                                <td>{{ $daemon->user }}</td>
                                <td>{{ $daemon->directory }}</td>
                                <td>{{ $daemon->processes }}</td>
                                <td><span class="badge badge-dark">{{ $daemon->taskStatus() }}</span></td>
                                <td>
                                    <form class="float-right"
                                          action="{{ route('server.supervisor.delete', [$daemon->server_id, $daemon]) }}"
                                          method="POST">
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
