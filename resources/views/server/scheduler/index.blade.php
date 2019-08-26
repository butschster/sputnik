@extends('layouts.app')

@section('sidebar')
    @include('server.partials.server_nav')
@endsection

@section('content')
    <div class="flex mb-4">
        <h1 class="flex-1">
            Scheduler
        </h1>

        <div class="mb-4">
            <a class="btn btn-outline" href="{{ route('server.show', $server) }}">
                <i class="fas fa-arrow-left"></i> Back to server
            </a>
        </div>
    </div>

    @can('store', [\App\Models\Server\CronJob::class, $server])
    <section class="section pb-8 my-10">
        <div class="section-header">
            New scheduled task
            <p>You can easily schedule cron jobs on your server</p>
        </div>
        <form action="{{ route('server.scheduler.store', $server) }}" method="POST">
            @csrf
            <input type="hidden" name="user" value="root">

            <div class="form-group form-group-labeled is-required @error('name') is-invalid @enderror">
                <input type="text" class="form-control" name="name" id="name"
                       value="{{ old('name', 'My awesome cron task') }}" placeholder="Name">
                <label for="name">Name</label>

                @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group form-group-labeled is-required @error('command') is-invalid @enderror">
                <input type="text" class="form-control"
                       name="command" id="command" value="{{ old('command', 'apt-get update') }}" placeholder="Command">
                <label for="command">Command</label>

                @error('command')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group form-group-labeled is-required @error('cron') is-invalid @enderror">
                <input type="text" class="form-control" name="cron" id="cron"
                       value="{{ old('cron', '* * * * *') }}" placeholder="Cron expression">
                <label for="cron">Cron expression</label>

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
    </section>
    @endcan

    <div class="mt-10">
        <h4>Scheduled jobs</h4>
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

    @include('server.partials.tasks')
@endsection
