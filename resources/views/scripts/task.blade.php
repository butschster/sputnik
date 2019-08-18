
# ================================================
# Task {!! $task->id !!}
# ================================================

{!! $task->script !!}

EXIT_CODE=$?

{!! callback_url('task.finished', ['task_id' => $task->id, 'exit_code' => '$EXIT_CODE']) !!}
