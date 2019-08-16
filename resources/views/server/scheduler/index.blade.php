@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-3">
                @include('server.partials.nav')
            </div>
            <div class="col-9">
                <div class="mb-4">
                    <a class="btn btn-outline-primary" href="{{ route('server.show', $server) }}">
                        <i class="fas fa-arrow-left"></i> Back to server
                    </a>
                </div>

                <h2 class="mb-4">
                    <i class="fas fa-clock mr-3"></i> Scheduler
                </h2>

                @can('store', [\App\Models\Server\CronJob::class, $server])
                    <div class="card">
                        <div class="card-header">New scheduled task</div>
                        <form action="{{ route('server.scheduler.store', $server) }}" method="POST" class="card-body">
                            @csrf
                            <input type="hidden" name="user" value="root">

                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                       value="{{ old('name', 'My awesome cron task') }}" required autofocus>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Command</label>
                                <input type="text" class="form-control @error('command') is-invalid @enderror"
                                       name="command"
                                       value="{{ old('command', 'apt-get update') }}" required autofocus>

                                @error('command')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Cron expression</label>
                                <input type="text" class="form-control @error('cron') is-invalid @enderror" name="cron"
                                       value="{{ old('cron', '* * * * *') }}" required autofocus>

                                <small id="passwordHelpBlock" class="form-text text-muted">
                                    You can use named expressions like [@hourly, @daily, @monthly]
                                </small>

                                @error('cron')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>


                            <div class="form-group mb-0">
                                <button class="btn btn-primary">Schedule</button>
                            </div>
                        </form>
                    </div>
                @endcan

                <div class="card mt-3">
                    <table class="table mb-0">
                        <col>
                        <col width="100px">
                        <col width="100px">
                        <col>
                        <col width="200px">
                        <col width="100px">
                        <thead class="thead-dark">
                        <tr>
                            <th>Name</th>
                            <th>Cron</th>
                            <th>User</th>
                            <th>Command</th>
                            <th>Next run</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        @foreach($jobs as $job)
                            <tr>
                                <th>{{ $job->name }} <br><small class="text-muted">{{ $job->id }}</small></th>
                                <th>{{ $job->cron }}</th>
                                <td>{{ $job->user }}</td>
                                <td>{{ $job->command }}</td>
                                <td>{{ $job->nextRunDate() }}</td>
                                <td><span class="badge badge-dark">{{ $job->taskStatus() }}</span></td>
                            </tr>
                        @endforeach
                    </table>

                </div>

            </div>
        </div>
    </div>
@endsection
