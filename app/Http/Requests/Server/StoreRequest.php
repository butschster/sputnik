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
            'type' => ['required', 'string', Rule::in(config('configurations.server_types', []))],
            'name' => 'required|string',
            'team_id' => ['required', 'uuid', Rule::exists('teams', 'id')],
            'ip' => ['required', 'ipv4', Rule::unique('servers')],
            'ssh_port' => 'nullable|digits_between:2,5',
            'sudo_password' => 'nullable|string',
            'php_version' => ['nullable', Rule::in(config('configurations.php', []))],
            'database_type' => ['nullable', Rule::in(config('configurations.database', []))],
            'webserver_type' => ['nullable', Rule::in(config('configurations.webserver', []))],
        ];
    }

    /**
     * @param \Illuminate\Validation\Validator $validator
     * @return mixed
     */
    public function withValidator(\Illuminate\Validation\Validator $validator): void
    {
        $validator->sometimes(['php_version', 'database_type', 'webserver_type'], ['required'], function ($input) {
            return $input->type == Server::TYPE_WEBSERVER;
        });

        $validator->sometimes('vpn_port', ['required', 'digits_between:2,4'], function ($input) {
            return $input->type == Server::TYPE_OPENVPN;
        });

        $validator->sometimes('vpn_protocol', ['required', 'string', Rule::in(['udp', 'tcp'])], function ($input) {
            return $input->type == Server::TYPE_OPENVPN;
        });

        $validator->sometimes('dns', ['required', 'string', Rule::in(['current', 'google', 'opendns', 'verisign'])], function ($input) {
            return $input->type == Server::TYPE_OPENVPN;
        });
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

        $serverFields = ['type', 'name', 'team_id', 'ip', 'ssh_port'];

        $data = Arr::only($this->validated(), $serverFields);
        $data['meta'] = Arr::except($this->validated(), $serverFields);

        return $this->user()->servers()->create($data);
    }
}
