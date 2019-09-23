<?php

namespace App\Http\Requests\Script;

use App\Jobs\Task\Run;
use App\Models\Script;
use App\Models\Server;
use App\Scripts\Server\CustomScript;
use App\Scripts\Server\Task;
use App\Services\Task\Factory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class ExecuteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules()
    {
        return [
            'server_id' => ['required', 'uuid', Rule::exists('servers', 'id')],
            'user' => [
                'required',
                'string',
                Rule::exists('server_users', 'name')->where('server_id', $this->server_id),
            ],
        ];
    }

    /**
     * @param Factory $taskFactory
     *
     * @return Task
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function persist(Factory $taskFactory): Task
    {
        $server = Server::findOrFail($this->server_id);

        if (!Gate::allows('execute', [$this->getScript(), $server])) {
            $this->failedAuthorization();
        }

        $task = $taskFactory->createFromScript(
            $server, $this->makeCustomScript()
        );

        event(new Run($task));

        $this->getScript()->servers()->attach($server, [
            'task_id' => $task->id,
            'created_at' => now(),
        ]);

        return $task;
    }

    /**
     * @return Script
     */
    protected function getScript(): Script
    {
        return $this->route('script');
    }

    /**
     * @return CustomScript
     */
    protected function makeCustomScript(): CustomScript
    {
        $script = new CustomScript($this->getScript()->script);
        $script->asUser($this->user);

        return $script;
    }
}
