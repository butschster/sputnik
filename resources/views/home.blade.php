@extends('layouts.app')

@section('content')
    <div class="mb-16">
        @include('server.partials.create_form')
    </div>

    <section class="servers-list">
        <h4>Servers</h4>
        <div class="servers-list-items">
        @foreach($servers as $server)
            <div class="servers-list-item-wrapper">
                <div class="servers-list-item__status">
                    <div class="status-indicator {{ $server->status }}"></div>
                </div>
                <div class="servers-list-item__name">
                    <a href="{{ route('server.show', $server) }}">{{ $server->name }}</a>
                    <div class="servers-list-item__address">{{ $server->ip }}</div>
                </div>
                <div class="servers-list-item__project">
                    {{ $server->team->name }}
                </div>
            </div>
        @endforeach
        </div>
    </section>
@endsection
