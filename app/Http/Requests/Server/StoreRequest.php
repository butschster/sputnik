<?php

namespace App\Http\Requests\Server;

use App\Models\Server;
use App\Models\User\Team;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('store', Server::class);
    }

    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'team_id' => ['required', 'uuid', Rule::exists('teams', 'id')],
            'ip' => ['required', 'ipv4', Rule::unique('servers')],
            'ssh_port' => 'nullable|digits_between:2,4',
            'sudo_password' => 'nullable|string',
            'php_version' => ['required', Rule::in(config('configurations.php', []))],
            'database_type' => ['required', Rule::in(config('configurations.database', []))],
            'meta' => 'nullable|array',
        ];
    }

    /**
     * @return Server
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function persist(): Server
    {
        $team = Team::findOrFail($this->team_id);
        if(!$this->user()->can('server.create', $team)) {
            $this->failedAuthorization();
        }

        return $this->user()->servers()->create(
            $this->validated()
        );
    }
}
