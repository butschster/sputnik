<?php

namespace App\Http\Requests\Server;

use App\Models\Server;
use App\Models\User\Team;
use App\Validation\Rules\Server\Site\RepositoryName;
use App\Validation\Rules\Server\Site\RepositoryUrl;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('create', Server::class);
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
            'ssh_port' => 'nullable|digits_between:2,5',
            'sudo_password' => 'nullable|string',
        ];
    }

    /**
     * @param \Illuminate\Validation\Validator $validator
     * @return mixed
     */
    public function withValidator(\Illuminate\Validation\Validator $validator): void
    {

    }

    /**
     * @return Server
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function persist(): Server
    {
        $team = Team::findOrFail($this->team_id);
        if (!Gate::allows('store', [Server::class, $team])) {
            $this->failedAuthorization();
        }

        if (!$this->user()->can('server.create', $team)) {
            $this->failedAuthorization();
        }

        $serverFields = ['name', 'team_id', 'ip', 'ssh_port'];

        $data = Arr::only($this->validated(), $serverFields);
        $data['meta'] = Arr::except($this->validated(), $serverFields);

        return $this->user()->servers()->create($data);
    }
}
