@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                Server {{ $server->name }}
            </div>

            <div class="alert-warning alert mb-0 p-4">
                Sorry, your OS {{ $sysInfo->getFullName() }} currently is not supported!


                <form class="mt-3" action="{{ route('server.delete', $server) }}" method="POST">
                    @method('DELETE')
                    @csrf

                    <button class="btn btn-lg btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
@endsection
