@extends('layouts.app')

@section('sidebar')
    @include('server.partials.server_nav')
@endsection

@section('content')

    <h1 class="mb-4">
        <i class="fas fa-hdd mr-3"></i> {{ $server->name }}
        <br><small class="text-muted">{{ $server->team->name }}</small>

        <span
            class="badge float-right @if($server->isConfigured()) badge-success @else badge-warning @endif">{{ $server->status }}</span>
    </h1>
    <div class="card">
        <div class="card-header">
            <i class="fas fa-clipboard-list mr-3"></i>
            System information
            <a href="{{ route('server.config', $server) }}" class="btn btn-sm btn-primary float-right">Configuration
                script</a>
        </div>
        @if($server->isPending())
            <div class="alert alert-warning mb-0">
                <code>wget -O sputnik.sh "{{ route('server.install_script', $server) }}"; bash
                    sputnik.sh</code>
            </div>
        @endif

        @if($server->isConfiguring())
            <div class="progress rounded-0">
                <div class="progress-bar progress-bar-striped progress-bar-animated"
                     role="progressbar" aria-valuenow="75"
                     aria-valuemin="0" aria-valuemax="100"
                     style="width: 45%"></div>
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
                <td>{{ $server->php_version }} </td>
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

    @include('server.partials.tasks', ['tasks' => $server->tasks])

    <div class="card mt-3">
        <div class="card-header">
            <i class="fas fa-archive fa-lg mr-3"></i>
            Server Events
        </div>

        <table class="table table-hover mb-0">
            <col>
            <col width="200px">
            @foreach($server->events as $event)
                <tr>
                    <th>{{ $event->message }}</th>
                    <td class="text-right"><small class="badge">{{ $event->created_at }}</small></td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
