@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-3">
                @include('server.partials.site_nav')
                @include('server.partials.server_nav', ['server' => $site->server])
            </div>
            <div class="col-9">
                <div class="mb-4">
                    <a class="btn btn-outline-primary" href="{{ route('server.show', $site->server) }}">
                        <i class="fas fa-arrow-left"></i> Back to server
                    </a>
                </div>

                <h2 class="mb-4">
                    <i class="fas fa-globe mr-3"></i> <a target="_blank" href="{{ $site->url() }}">{{ $site->domain }}</a>

                    <form class="float-right" action="{{ route('server.site.delete', $site) }}" method="POST">
                        @method('DELETE')
                        @csrf

                        <button class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </h2>

                <div class="card">
                    <table class="table">
                        <col width="200px">
                        <col>
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
                        @can('deploy', $site)
                            <a href="{{ route('server.site.deploy.config', [$site->server_id, $site]) }}" class="float-right btn btn-sm btn-primary ml-3">Config</a>

                            <form class="float-right" action="{{ route('server.site.deploy', [$site->server_id, $site]) }}"
                                  method="POST">
                                @csrf

                                <button class="btn btn-warning btn-sm"><i class="fas fa-play-circle mr-2"></i> Deploy!</button>
                            </form>
                        @endcan
                    </div>
                    @if(!$site->hasEnvironmentVariables())
                    <div class="alert alert-warning">
                        Site doesn't have environment variables
                        <a href="{{ route('server.site.deployments.index', [$site->server_id, $site]) }}" class="btn btn-warning btn-sm">Configure</a>
                    </div>
                    @endif
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
            </div>
        </div>


    </div>
@endsection
