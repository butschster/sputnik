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
                    <a class="btn btn-outline-primary" href="{{ route('server.site.show', [$site->server, $site]) }}">
                        <i class="fas fa-arrow-left"></i> Back to site
                    </a>
                </div>


                <h2 class="mb-4">
                    <i class="fas fa-globe mr-3"></i> Environment variables
                </h2>

                <div class="card">
                    <div class="card-header">
                        Upload from file
                    </div>
                    <form class="card-body"
                          action="{{ route('server.site.environment.upload', [$site->server_id, $site]) }}"
                          method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="file">
                        <button class="btn btn-sm btn-primary">Upload</button>
                    </form>
                </div>

                <div class="card mt-4">
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
                    <form action="{{ route('server.site.environment.update', [$site->server_id, $site]) }}"
                          method="POST">
                        @csrf
                        <table class="table mb-0">
                            <col width="200px">
                            <col>
                            <col width="100px">

                            <tr>
                                <td>
                                    <input type="text" class="form-control @error('key') is-invalid @enderror"
                                           name="key"
                                           value="{{ old('key') }}" required>

                                    @error('key')
                                    <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                                    @enderror
                                </td>
                                <td colspan="2">
                                    <input type="text" class="form-control @error('value') is-invalid @enderror"
                                           name="value"
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
                                    <button class="btn btn-primary" type="submit">Save</button>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>


    </div>
@endsection
