<?php

namespace App\Http\Requests\Server\Module;

use App\Contracts\Server\Module;
use App\Contracts\Server\Modules\Registry;
use App\Jobs\Server\Module\Install;
use App\Models\Server;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class RunActionRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('update', $this->getServer());
    }

    /**
     * @return array
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function rules()
    {
        return [
            'modules' => 'required|array',
            'modules.*.key' => ['required', 'string', Rule::in($this->modulesRegistry()->getKeys())],
        ];
    }

    /**
     * @param \Illuminate\Validation\Validator $validator
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function withValidator(\Illuminate\Validation\Validator $validator): void
    {
        $modules = collect($this->modules)->pluck('key');

        $this->modulesRegistry()->modules()->filter(function (Module $module) use ($modules, $validator) {
            $prefix = 'modules.' . $module->key().'.';
            if ($modules->contains($module->key())) {
                $rules = $module->getFields()->getValidationRules($prefix);
                if (empty($rules)) {
                    return;
                }

                $validator->addRules($rules);
                $validator->addCustomAttributes($module->getFields()->getValidationLabels($prefix));
            }
        });
    }

    public function persist()
    {
        $server = $this->getServer();

        foreach ($this->modules as $module) {
            dispatch(
                new Install($server, $module['key'], Arr::except($module, 'key'))
            );
        }
    }

    /**
     * @return Registry
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function modulesRegistry(): Registry
    {
        return $this->container->make(Registry::class);
    }

    /**
     * @return Server
     */
    public function getServer(): Server
    {
        return $this->route('server');
    }
}
