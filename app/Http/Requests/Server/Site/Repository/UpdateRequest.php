<?php

namespace App\Http\Requests\Server\Site\Repository;

use App\Models\Server\Site;
use App\Models\User\SourceProvider;
use App\Services\SourceProviders\Factory;
use App\Validation\Rules\Server\Site\RepositoryName;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UpdateRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('update', $this->getSite());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'repository_provider' => [
                'required',
                'string',
                Rule::exists('user_source_providers', 'type')->where('user_id', $this->getSite()->server->user_id),
            ],
            'repository' => [
                'required',
                'string',
                new RepositoryName(),
            ],
            'repository_branch' => 'required|string|alpha_dash',
        ];
    }

    /**
     * @return Site
     */
    public function persist(): Site
    {
        $provider = $this->user()->sourceProviders()->where('type', $this->repository_provider)->firstOrFail();

        $isValid = (new Factory())->make($provider)
            ->validRepository($this->repository, $this->repository_branch);

        if (!$isValid) {
            $validator = $this->getValidatorInstance();
            $validator->errors()->add('repository', 'Repository not found');

            $this->failedValidation($validator);
        }

        $site = $this->getSite();

        $site->update($this->validationData());

        return $site;
    }

    /**
     * @return Site
     */
    protected function getSite(): Site
    {
        return $this->site;
    }
}
