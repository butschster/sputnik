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
                    <i class="fas fa-list mr-3"></i> Deployments

                    @can('deploy', $site)
                    <form class="float-right" action="{{ route('server.site.deploy', [$site->server_id, $site]) }}"
                          method="POST">
                        @csrf

                        <button class="btn btn-warning"><i class="fas fa-play-circle mr-2"></i> Deploy!</button>
                    </form>
                    @endcan
                </h2>

                <div class="card mt-3">
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
                        @foreach($deployments as $deployment)
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
        </div>
    </div>
@endsection
