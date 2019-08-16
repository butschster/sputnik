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
                    <th>Path</th>
                    <td>{{ $site->path() }}</td>
                </tr>
                <tr>
                    <th>Public path</th>
                    <td>{{ $site->publicPath() }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td><span class="badge badge-dark">{{ $site->taskStatus() }}</span></td>
                </tr>
            </table>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                Git repository details

                <a href="{{ route('server.site.deploy.config', [$site->server_id, $site]) }}" class="float-right btn btn-sm btn-primary ml-3">Config</a>

                @can('deploy', $site)
                <form class="float-right" action="{{ route('server.site.deploy', [$site->server_id, $site]) }}"
                      method="POST">
                    @csrf

                    <button class="btn btn-warning btn-sm"><i class="fas fa-play-circle mr-2"></i> Deploy!</button>
                </form>
                @endcan
            </div>
            <form action="{{ route('server.site.repository.update', [$site->server_id, $site]) }}" method="POST">
                @csrf

                <div class="form-group bg-light p-3 shadow">
                    <label class="mr-4">Source provider</label>

                    {{--
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio"
                               name="repository_provider"
                               id="providerCustom"
                               value=""
                               class="custom-control-input"
                               @if(!$site->repository_provider)
                                   checked
                                @endif
                        >
                        <label class="custom-control-label" for="providerCustom">Custom</label>
                    </div>
                    --}}
                    @foreach($site->server->user->sourceProviders as $provider)
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio"
                                   name="repository_provider"
                                   id="provider{{ $provider->type }}"
                                   value="{{ $provider->type }}"
                                   class="custom-control-input"
                                   @if($provider->type == $site->repository_provider)
                                       checked
                                   @endif
                            >
                            <label class="custom-control-label" for="provider{{ $provider->type }}">
                                <i class="fab fa-{{ $provider->type }}"></i>
                                {{ $provider->name }}
                            </label>
                        </div>
                    @endforeach

                    <a class="ml-3 btn btn-sm btn-outline-primary float-right" href="{{ route('user.profile') }}"><i class="fas fa-cog"></i> Configure</a>

                    @error('repository_provider')
                    <span class="text-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="card-body">
                <div class="row">
                    <div class="form-group col-9">
                        <label>Repository</label>
                        <input type="text" class="form-control @error('repository') is-invalid @enderror" name="repository"
                               value="{{ old('repository', $site->repository) }}" required autofocus>

                        @error('repository')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                        @enderror
                    </div>

                    <div class="form-group col-3">
                        <label>Branch</label>
                        <input type="text" class="form-control @error('repository_branch') is-invalid @enderror"
                               name="repository_branch" value="{{ old('repository_branch', $site->repositoryBranch()) }}"
                               required autofocus>

                        @error('repository_branch')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group mb-0">
                    <button class="btn btn-primary">Update</button>
                </div>

                </div>
            </form>
            <div class="card-header border-top">
                Use this public key for access deployment

                @if($site->sourceProvider)
                <form class="float-right" action="{{ route('server.site.repository.add_key', [$site->server_id, $site]) }}" method="POST">
                    @csrf
                    <button class="btn btn-sm btn-primary">Register</button>
                </form>
                @endif
            </div>
            <pre class="card-body bg-dark text-white mb-0" style="white-space: normal;">{{ $site->server->public_key }}</pre>
            <div class="card-header">
                Deployment Trigger URL

                @if($site->sourceProvider)
                    <form class="float-right" action="{{ route('server.site.repository.add_webhook', [$site->server_id, $site]) }}" method="POST">
                        @csrf
                        <button class="btn btn-sm btn-primary">Register</button>
                    </form>
                @endif
            </div>
            <div class="alert bg-white rounded-0 mb-0">
                Using a custom Git service, or want a service like Travis CI to run your tests before your
                application is deployed to Forge? It's simple. When you commit fresh code, or when your continuous
                integration service finishes testing your application, instruct the service to make a GET or POST
                request to the following URL. Making a request to this URL will trigger your Forge deployment
                script:
            </div>
            <pre class="card-body bg-dark text-white mb-0" style="white-space: normal;">{{ $site->hooksHandlerUrl() }}</pre>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                Environment variables

                <form class="float-right" action="{{ route('server.site.environment.upload', [$site->server_id, $site]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="file">
                    <button class="btn btn-sm btn-primary">Upload</button>
                </form>
            </div>
            @if($site->environment)
                <table class="table">
                    <col width="200px">
                    <col>
                    <col width="100px">
                    <thead>
                    <tr>
                        <th>Key</th>
                        <th>Value</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($site->environment as $key => $value)
                        <tr>
                            <th>{{ $key }}</th>
                            <td>{{ $value }}</td>
                            <td class="text-right">
                                <form class="float-right"
                                      action="{{ route('server.site.environment.delete', [$site->server_id, $site]) }}"
                                      method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="key" value="{{ $key }}">
                                    <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
            <form action="{{ route('server.site.environment.update', [$site->server_id, $site]) }}" method="POST">
                @csrf
                <table class="table mb-0">
                    <col width="200px">
                    <col>
                    <col width="100px">

                    <tr>
                        <td>
                            <input type="text" class="form-control @error('key') is-invalid @enderror" name="key"
                                   value="{{ old('key') }}" required>

                            @error('key')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </td>
                        <td colspan="2">
                            <input type="text" class="form-control @error('value') is-invalid @enderror" name="value"
                                   value="{{ old('value') }}" required>

                            @error('value')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <button class="btn btn-primary" type="submit">Store</button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <i class="fas fa-database mr-3"></i> Deployments
            </div>

            <table class="table mb-0">
                <col>
                <col width="100px">
                <col width="100px">
                <thead class="thead-dark">
                <tr>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
                </thead>
                @foreach($site->deployments as $deployment)
                    <tr>
                        <th>
                            @if($deployment->task)
                            <a href="{{ route('task.show', $deployment->task) }}">{{ $deployment->branch }}</a>
                            @else
                            {{ $deployment->branch }}
                            @endif
                        </th>
                        <td><span class="badge badge-dark">{{ $deployment->status }}</span></td>
                        <td class="text-right"><small class="badge">{{ $deployment->created_at }}</small></td>
                    </tr>
                @endforeach
            </table>
        </div>

    </div>
@endsection
