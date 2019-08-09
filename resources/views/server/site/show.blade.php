@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="mb-2">
            <a class="btn btn-link" href="{{ route('server.show', $site->server) }}">
                <i class="fas fa-arrow-left"></i> Back to server
            </a>
        </div>
        <div class="card">
            <div class="card-header">
                Site <strong>{{ $site->domain }}</strong>

                <form class="float-right" action="{{ route('server.site.delete', $site) }}" method="POST">
                    @method('DELETE')
                    @csrf

                    <button class="btn btn-sm btn-danger">Delete</button>
                </form>
            </div>
            <table class="table">
                <col width="200px">
                <col>
                <tr>
                    <th>Domain</th>
                    <td>{{ $site->domain }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>{{ $site->task->status }}</td>
                </tr>
            </table>
        </div>
    </div>
@endsection
