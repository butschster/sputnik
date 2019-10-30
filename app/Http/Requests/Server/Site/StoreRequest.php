<?php

namespace App\Http\Requests\Server\Site;

use App\Models\Server;
use App\Models\Server\Site;
use Domain\Module\Contracts\Registry;
use Domain\Module\Entities\Module\Repository;
use Domain\Module\Validation\Rules\ModuleInstalled;
use Domain\Site\Validation\Rules\Domain;
use Domain\Site\Validation\Rules\PublicPath;
use Domain\SourceProvider\Validation\Rules\RepositoryName;
use Domain\SourceProvider\Validation\Rules\RepositoryUrl;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('store', [Site::class, $this->getServer()]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'webserver' => [
                'required',
                'string',
                new ModuleInstalled($this->getServer()),
            ],
            'domain' => [
                'required',
                'string',
                Rule::unique('server_sites'),
                new Domain(),
            ],
            'is_proxy' => ['bool'],
            'public_dir' => ['required', 'string', new PublicPath()],
        ];
    }

    /**
     * @param \Illuminate\Validation\Validator $validator
     * @return mixed
     */
    public function withValidator(\Illuminate\Validation\Validator $validator): void
    {
        $validator->sometimes('processor', ['required', 'string', new ModuleInstalled($this->getServer())], function ($input) {
            return empty($input->is_proxy);
        })->sometimes('proxy_address', ['required', 'url'], function ($input) {
            return !empty($input->is_proxy);
        });
    }

    /**
     * @return Site
     */
    public function persist(): Site
    {
        $data = $this->validated();

        $site = new Site(
            Arr::except($this->validated(), ['webserver', 'processor'])
        );

        $site->webServer()->associate(
            $this->getServer()->getModule($data['webserver'])
        );

        if (isset($data['processor'])) {
            $site->processor()->associate(
                $this->getServer()->getModule($data['processor'])
            );
        }

        $site->server()->associate($this->getServer());
        $site->user()->associate($this->user());
        $site->save();

        return $site;
    }

    /**
     * @return Server
     */
    protected function getServer(): Server
    {
        return $this->route('server');
    }

    /**
     * @return Registry
     */
    protected function getModulesRegistry(): Registry
    {
        return app(Repository::class);
    }
}
