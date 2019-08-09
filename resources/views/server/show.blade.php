@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                Server {{ $server->name }}

                <span
                    class="badge @if($server->isConfigured()) badge-success @else badge-warning @endif">{{ $server->status }}</span>

                <a href="{{ route('server.config', $server) }}" class="btn btn-sm btn-primary float-right">Configuration
                    script</a>
            </div>
            @if(!$server->isConfigured())
                <div class="alert alert-warning mb-0">
                    <code>wget -O sputnik.sh "{{ route('server.install_script', $server) }}"; bash sputnik.sh</code>
                </div>
            @endif
            <table class="table">
                <col width="200px">
                <col>
                <tr>
                    <th>Name</th>
                    <td>{{ $server->name }}</td>
                </tr>
                @if($sysInfo)
                    <tr>
                        <th>OS</th>
                        <td>
                            {{ $sysInfo->getOs() }}
                            {{ $sysInfo->getVersion() }}
                            [{{ $sysInfo->getArchitecture() }} bits]

                            @if($sysInfo->isSupported())
                                <span class="badge badge-success">Supported</span>
                            @else
                                <span class="badge badge-danger">Not supported</span>
                            @endif
                        </td>
                    </tr>
                @endif
                <tr>
                    <th>SSH Port</th>
                    <td>{{ $server->ssh_port }}</td>
                </tr>
                <tr>
                    <th>IP Address</th>
                    <td>{{ $server->ip }}</td>
                </tr>
                <tr>
                    <th>PHP Version</th>
                    <td>{{ $server->php_version }}</td>
                </tr>
                <tr>
                    <th>Database</th>
                    <td>{{ $server->database_type }}</td>
                </tr>
                <tr>
                    <th>Webserver</th>
                    <td>{{ $server->webserver_type }}</td>
                </tr>
            </table>
        </div>

        @include('server.partials.firewall')
        @include('server.partials.scheduler')
        @include('server.partials.keys')


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
