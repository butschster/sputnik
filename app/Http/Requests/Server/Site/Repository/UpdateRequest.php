<?php

namespace App\Http\Requests\Server\Site\Repository;

use App\Models\Server\Site;
use App\Validation\Rules\Server\Site\RepositoryName;
use App\Validation\Rules\Server\Site\RepositoryUrl;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

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
                'nullable',
                'string',
            ],
            'repository_branch' => 'required|string|alpha_dash',
        ];
    }

    /**
     * @param \Illuminate\Validation\Validator $validator
     * @return mixed
     */
    public function withValidator(\Illuminate\Validation\Validator $validator): void
    {
        $validator->sometimes('repository', ['required', 'string', new RepositoryUrl()], function ($input) {
            return empty($input->repository_provider);
        })->sometimes('repository', ['required', 'string', 'bail', new RepositoryName()], function ($input) {
            if (empty($this->repository_provider)) {
                return false;
            }

            return $this->user()->sourceProviders()->where('type', $this->repository_provider)->exists();
        })->after(function ($validator) {
            if (empty($this->repository)) {
                return false;
            }

            if (!empty($this->repository_provider)) {
                $provider = $this->user()->sourceProviders()->where('type', $this->repository_provider)->first();

                if (!$provider) {
                    $validator->errors()->add('repository_provider', 'Source provider not found');
                    return;
                }

                $isValid = $provider->getClient()->validRepository($this->repository, $this->repository_branch);

                if (!$isValid) {
                    $validator->errors()->add('repository', 'Repository not found');
                }
            }
        });
    }

    /**
     * @return Site
     */
    public function persist(): Site
    {
        $site = $this->getSite();

        $site->update($this->validated());

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
