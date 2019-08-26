@extends('layouts.app')

@section('sidebar')
    @include('server.partials.server_nav')
@endsection

@section('content')

    <div class="flex mb-4">
        <h1 class="flex-1">
            <i class="fas fa-clock mr-3"></i> Supervisor
        </h1>

        <div class="mb-4">
            <a class="btn btn-outline" href="{{ route('server.show', $server) }}">
                <i class="fas fa-arrow-left"></i> Back to server
            </a>
        </div>
    </div>

    @can('store', [\App\Models\Server\Daemon::class, $server])
        <section class="section pb-8 my-10">
            <div class="section-header">
                New daemon
            </div>

            <form action="{{ route('server.supervisor.store', $server) }}" method="POST" class="section-body">
                @csrf
                <input type="hidden" name="user" value="root">

                <div class="flex">
                    <div class="form-group flex-1 form-group-labeled is-required mr-6 @error('command') is-invalid @enderror">
                        <input type="text" class="form-control"
                               name="command" id="command"
                               value="{{ old('command') }}" placeholder="Command">
                        <label for="command">Command</label>

                        @error('command')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group form-group-labeled is-required mr-6 @error('processes') is-invalid @enderror">
                        <input type="number" class="form-control"
                               name="processes" id="processes"
                               value="{{ old('processes', 1) }}">
                        <label for="processes">Number of processes</label>

                        @error('processes')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group mb-0">
                        <button class="btn btn-primary">Start</button>
                    </div>
                </div>
            </form>
        </section>
    @endcan

    <h4>Supervisor</h4>
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

    @include('server.partials.tasks')
@endsection
