<?php

namespace App\Http\Actions\Task;

use App\Models\Server\Task;
use Domain\Task\Jobs\Finish;
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

    /**
     * Finish task which has status running
     */
    public function handle(): void
    {
        $task = Task::findOrFail($this->task_id);

        $task->update([
            'exit_code' => (int) $this->exit_code
        ]);

        // If task is not run, it shouldn't be finished
        abort_unless($task->isRunning(), 404);

        dispatch(
            new Finish($task, (int) $this->exit_code)
        );
    }
}
