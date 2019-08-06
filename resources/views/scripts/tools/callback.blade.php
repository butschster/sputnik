# Rewrite Script Into Another File

cat > {!! $path !!} << '{!! $token !!}'
{!! $task->script !!}

{!! $token !!}

# Invoke Script File

@if ($task->timeout() > 0)
    timeout {!! $task->timeout() !!}s bash {!! $path !!}
@else
    bash {!! $path !!}
@endif

# Call Home With ID & Status Code

STATUS=$?

{!! callback_url('task.finished', ['task_id' => $task->id, 'exit_code' => '$STATUS']) !!}
