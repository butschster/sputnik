@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">Task {{ $task->name }}</div>

            <table class="table">
                <tr>
                    <th>User</th>
                    <td>{{ $task->user }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>{{ $task->status }}</td>
                </tr>
                <tr>
                    <th>Success</th>
                    <td>{{ $task->isSuccessful() ? 'yes' : 'no' }}</td>
                </tr>
            </table>
        </div>

        <div class="card mt-3">
            <div class="card-header">Command</div>

            <pre class="card-body" style="white-space: pre-wrap;">{{ $task->script }}</pre>
        </div>

        <div class="card mt-3">
            <div class="card-header">Output</div>

            <pre class="card-body" style="white-space: pre-wrap;">{{ $task->output }}</pre>
        </div>
    </div>
@endsection
