@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="servers-list">
            @foreach($servers as $server)
                <div class="servers-list-item-wrapper">
                    <div class="servers-list-item__status">
                        <div class="status-indicator {{ $server->status }}"></div>
                    </div>
                    <div class="servers-list-item__name">
                        <a href="{{ route('server.show', $server) }}">{{ $server->name }}</a>
                        <br><small class="text-muted">{{ $server->team->name }}</small>
                    </div>
                    <div class="servers-list-item__address">
                        {{ $server->ip }}:{{ $server->ssh_port }}
                    </div>
                </div>
            @endforeach
        </div>
        @include('server.partials.create_form')
    </div>
@endsection
