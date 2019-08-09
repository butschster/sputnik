@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Servers</div>

                <table class="table mb-0">
                    <thead class="table-dark">
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
                            <td><span class="badge badge-dark">{{ $server->status }}</span></td>
                        </tr>
                    @endforeach
                </table>
            </div>

            @include('server.partials.create_form')
        </div>
    </div>
</div>
@endsection
