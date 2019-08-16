@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-3">
                @include('server.partials.nav')
            </div>
            <div class="col-9">
                <h2 class="mb-4">
                    <i class="fas fa-hdd mr-3"></i> {{ $server->name }}
                    <span class="badge float-right @if($server->isConfigured()) badge-success @else badge-warning @endif">{{ $server->status }}</span>
                </h2>
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-clipboard-list fa-lg mr-3"></i>
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


                <div class="card mt-3">
                    <div class="card-header">
                        <i class="fas fa-tasks fa-lg mr-3"></i> Server tasks
                    </div>

                    <table class="table table-hover mb-0">
                        <col>
                        <col width="100px">
                        @foreach($server->tasks as $task)
                            <tr>
                                <td><small class="badge">{{ $task->created_at }}</small> <a
                                            href="{{ route('task.show', $task) }}"><strong>{{ $task->name }}</strong></a>
                                </td>
                                <td class="text-right"><span class="badge badge-dark">{{ $task->status }}</span></td>
                            </tr>
                        @endforeach
                    </table>
                </div>

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
            </div>
        </div>
    </div>
@endsection
