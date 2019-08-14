@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">Site deployment script</div>

            <pre class="card-body language-shell" style="white-space: pre-wrap;">{{ $script }}</pre>
        </div>
    </div>
@endsection
