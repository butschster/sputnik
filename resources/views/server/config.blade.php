@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">Server configuration script</div>

            <pre class="card-body" style="white-space: pre-wrap;">{!! $script !!}</pre>
        </div>
    </div>
@endsection
