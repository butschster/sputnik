@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">Server Metadata</div>

            <table class="table">
                <tr>
                    <th>Name</th>
                    <td>{{ $server->name }}</td>
                </tr>
                <tr>
                    <th>SSH Port</th>
                    <td>{{ $server->ssh_port }}</td>
                </tr>
                <tr>
                    <th>IP Address</th>
                    <td>{{ $server->ip }}</td>
                </tr>
            </table>
        </div>

        <div class="card mt-3">
            <div class="card-header">Status <strong>{{ $server->status }}</strong></div>

            @if(!$server->isConfigured())
                <div class="card-body">
                    <code>wget -O sputnik.sh "{{ route('server.install_script', $server) }}"; bash sputnik.sh</code>
                </div>
            @endif
        </div>

        <div class="card mt-3">
            <div class="card-header">SSH keys</div>

            <table class="table">
                @foreach($server->keys as $key)
                    <tr>
                        <th>{{ $key->name }}</th>
                        <td>{{ $key->fingerprint() }}</td>
                    </tr>
                @endforeach
            </table>
        </div>

        <div class="card mt-3">
            <div class="card-header">Sputnik Public Key</div>

            <code class="card-body">{{ $server->public_key }}</code>
        </div>

        <div class="card mt-3">
            <div class="card-header">Server tasks</div>

            <table class="table">
                @foreach($server->tasks as $task)
                    <tr>
                        <th><a href="{{ route('task.show', $task) }}">{{ $task->name }}</a></th>
                        <th>{{ $task->created_at }}</th>
                        <td>{{ $task->status }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection
