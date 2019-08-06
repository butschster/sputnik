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
            <div class="card-header">Server firewall</div>

            <table class="table">
                <col>
                <col width="100px">
                <col width="100px">
                <col width="100px">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Port</th>
                    <th>From</th>
                    <th>Policy</th>
                </tr>
                </thead>
                @foreach($server->firewallRules as $rule)
                    <tr>
                        <th>{{ $rule->name }}</th>
                        <th>{{ $rule->port }} [{{ $rule->protocol }}]</th>
                        <td>{{ $rule->from }}</td>
                        <td>{{ $rule->policy }}</td>
                    </tr>
                @endforeach
            </table>
        </div>

        <div class="card mt-3">
            <div class="card-header">SSH keys</div>

            <table class="table">
                <col>
                <col width="300px">
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
                <col>
                <col width="100px">
                <col width="200px">
                @foreach($server->tasks as $task)
                    <tr>
                        <th><a href="{{ route('task.show', $task) }}">{{ $task->name }}</a></th>
                        <td>{{ $task->status }}</td>
                        <th>{{ $task->created_at }}</th>
                    </tr>
                @endforeach
            </table>
        </div>

        <div class="card mt-3">
            <div class="card-header">Server Events</div>

            <table class="table">
                <col>
                <col width="200px">
                @foreach($server->events as $event)
                    <tr>
                        <td>{{ $event->message }}</td>
                        <th>{{ $event->created_at }}</th>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection
