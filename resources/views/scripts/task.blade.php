
# ================================================
# Task {!! $task->id !!}
# ================================================

{!! $task->script !!}

STATUS=$?
{!! callback_url('task.finished', ['task_id' => $task->id, 'exit_code' => '$STATUS']) !!}
