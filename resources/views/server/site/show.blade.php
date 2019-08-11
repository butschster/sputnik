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
                    <td><a target="_blank" href="{{ $site->url() }}">{{ $site->domain }}</a></td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>{{ $site->task->status }}</td>
                </tr>
            </table>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                Git repository details

                <form class="float-right" action="{{ route('server.site.deploy', [$site->server_id, $site]) }}" method="POST">
                    @csrf

                    <button class="btn btn-warning"><i class="fas fa-play-circle mr-2"></i> Deploy!</button>
                </form>
            </div>
            <form action="{{ route('server.site.update_repository', [$site->server_id, $site]) }}" method="POST"
                  class="card-body">
                @csrf

                <div class="form-group">
                    <label>Repository</label>
                    <input type="text" class="form-control @error('repository') is-invalid @enderror" name="repository"
                           value="{{ old('repository', $site->repository) }}" required autofocus>

                    @error('repository')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Branch</label>
                    <input type="text" class="form-control @error('repository_branch') is-invalid @enderror"
                           name="repository_branch" value="{{ old('repository_branch', $site->repository_branch) }}"
                           required autofocus>

                    @error('repository_branch')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group mb-0">
                    <button class="btn btn-primary">Update</button>
                </div>
            </form>
            <div class="alert bg-white rounded-0 mb-0">
                <p>Use this public key for access deployment</p>
                <code class="card-body">{{ $site->server->public_key }}</code>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                Environment variables
            </div>
            <form action="{{ route('server.site.environment', [$site->server_id, $site]) }}" method="POST">
                @csrf

                <table class="table">
                    <col width="200px">
                    <col>
                    <thead>
                    <tr>
                        <th>Key</th>
                        <th>Value</th>
                    </tr>
                    </thead>
                    @if($site->environment)
                    <tbody>
                    @foreach($site->environment as $key => $value)
                        <tr>
                            <th>{{ $key }}</th>
                            <td>{{ $value }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                    @endif
                    <tfoot>
                    <tr>
                        <td>
                            <input type="text" class="form-control @error('key') is-invalid @enderror" name="key" value="{{ old('key') }}" required>

                            @error('key')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </td>
                        <td>
                            <input type="text" class="form-control @error('value') is-invalid @enderror" name="value" value="{{ old('value') }}" required>

                            @error('value')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <button class="btn btn-primary">Store</button>
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </form>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                Deployment Trigger URL
            </div>
            <div class="alert bg-white rounded-0 mb-0">
                <p>Using a custom Git service, or want a service like Travis CI to run your tests before your
                    application is deployed to Forge? It's simple. When you commit fresh code, or when your continuous
                    integration service finishes testing your application, instruct the service to make a GET or POST
                    request to the following URL. Making a request to this URL will trigger your Forge deployment
                    script:</p>
                <code>{{ $site->hooksHandlerUrl() }}</code>
            </div>
        </div>
    </div>
@endsection
