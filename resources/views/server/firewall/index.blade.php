@extends('layouts.app')

@section('sidebar')
    @include('server.partials.server_nav')
@endsection

@section('content')
    <div class="flex mb-4">
        <h1 class="flex-1">
            <i class="fas fa-shield-alt mr-3"></i> Server firewall
        </h1>

        <div class="mb-4">
            <a class="btn btn-outline" href="{{ route('server.show', $server) }}">
                <i class="fas fa-arrow-left"></i> Back to server
            </a>
        </div>
    </div>

    <section class="section mb-16 mt-8">
        <div class="section-header">
            Create a new user
            <p>Enter a domain that you own below and start managing your DNS within your DigitalOcean account.</p>
        </div>
    </section>

    <form action="{{ route('server.firewall.store', $server) }}" method="POST">
        @csrf
        <table class="table mb-0">
            <col>
            <col width="100px">
            <col width="200px">
            <col width="130px">
            <col width="100px">
            <thead class="thead-dark">
            <tr>
                <th>Name</th>
                <th>Port</th>
                <th>From</th>
                <th>Policy</th>
                <th>Status</th>
            </tr>
            </thead>
            @foreach($rules as $rule)
                <tr @if(!$rule->isSuccessful()) class="bg-warning" @endif>
                    <th>{{ $rule->name }} <br><small class="text-muted">{{ $rule->id }}</small></th>
                    <th>{{ $rule->port }} @if($rule->protocol)[{{ $rule->protocol }}]@endif</th>
                    <td>{{ $rule->from }}</td>
                    <td><span class="badge">{{ $rule->policy }}</span></td>
                    <td><span class="badge badge-dark">{{ $rule->taskStatus() }}</span></td>
                </tr>
            @endforeach

            <tr>
                <th>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                           value="{{ old('name') }}" required autofocus>

                    @error('name')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </th>
                <th>
                    <input type="number" minlength="2" maxlength="4"
                           class="form-control @error('port') is-invalid @enderror" name="port"
                           value="{{ old('port') }}" required autofocus>

                    @error('port')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </th>
                <th>
                    <input type="text" class="form-control @error('from') is-invalid @enderror" name="from"
                           value="{{ old('from') }}" autofocus>

                    @error('from')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </th>
                <td>
                    <select name="policy" class="form-control @error('policy') is-invalid @enderror">
                        <option value="allow">Allow</option>
                        <option value="deny">deny</option>
                    </select>
                    @error('policy')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </td>
                <td>
                    <button class="btn btn-primary">Create</button>
                </td>
            </tr>
        </table>
    </form>

    @include('server.partials.tasks')
@endsection
