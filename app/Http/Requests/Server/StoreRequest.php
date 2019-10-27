<?php

namespace App\Http\Requests\Server;

use Domain\Module\Contracts\Entities\Action;
use Domain\Module\Contracts\Entities\Module;
use Domain\Module\Contracts\Registry;
use App\Models\Server;
use App\Models\User\Team;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

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
     * @return array
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'team_id' => ['required', 'uuid', Rule::exists('teams', 'id')],
            'ip' => ['required', 'ipv4', Rule::unique('servers')],
            'ssh_port' => 'nullable|digits_between:2,5',
            'sudo_password' => 'nullable|string',
            'modules' => 'nullable|array',
            'modules.*.key' => ['required', 'string', Rule::in($this->modulesRegistry()->getKeys())],
        ];
    }

    /**
     * @param Validator $validator
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function withValidator(Validator $validator): void
    {
        $modules = collect($this->modules)->pluck('key');

        $this->modulesRegistry()->modules()->filter(function (Module $module) use ($modules, $validator) {
            return $modules->contains(
                $module->key()
            );
        })->filter(function(Module $module) {
            return $module->hasAction('install');
        })->map(function(Module $module) {
            return $module->getAction('install');
        })->filter(function(Action $action) {
            return $action instanceof Action\HasFields;
        })->each(function (Action $action) use($validator) {
            $prefix = 'modules.' . $action->getModule()->key().'.';

            $rules = $action->getFields()->getValidationRules($prefix);
            if (empty($rules)) {
                return;
            }

            $validator->addRules($rules);
            $validator->addCustomAttributes($action->getFields()->getValidationLabels($prefix));
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

        $serverFields = ['name', 'team_id', 'ip', 'ssh_port'];

        $data = Arr::only($this->validated(), $serverFields);
        $data['meta'] = Arr::except($this->validated(), $serverFields);

        return $this->user()->servers()->create($data);
    }

    /**
     * @return Registry
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function modulesRegistry(): Registry
    {
        return $this->container->make(Registry::class);
    }
}
