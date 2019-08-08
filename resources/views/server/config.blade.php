@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">Server configuration script</div>

            <pre class="card-body">{!! $script !!}</pre>
        </div>
    </div>
@endsection
