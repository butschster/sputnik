<?php

namespace App\Http\Actions\Task;

use App\Jobs\Task\Finish;
use App\Models\Server\Task;
use Illuminate\Validation\Rule;
use Lorisleiva\Actions\Action;

class FinishTask extends Action
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'task_id' => ['required', Rule::exists('server_tasks', 'id')],
            'exit_code' => 'nullable|numeric'
        ];
    }

    public function handle()
    {
        $task = Task::findOrFail($this->task_id);

        abort_unless($task->isRunning(), 404);

        dispatch(
            new Finish($task, (int) $this->exit_code)
        );
    }
}
