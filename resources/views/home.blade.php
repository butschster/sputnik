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
        </div>
    </div>
</div>
@endsection