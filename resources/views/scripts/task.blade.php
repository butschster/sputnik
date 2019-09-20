# ================================================
# Task {!! $task->id !!}
# ================================================

{!! $task->script !!}

EXIT_CODE=$?

@if($callback)
{!! callback_url('task.finished', ['task_id' => $task->id, 'exit_code' => '$EXIT_CODE']) !!}
@endif
