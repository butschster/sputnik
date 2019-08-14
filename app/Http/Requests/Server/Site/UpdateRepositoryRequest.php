<?php

namespace App\Http\Requests\Server\Site;

use App\Models\Server\Site;
use App\Validation\Rules\Server\Site\RepositoryName;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRepositoryRequest extends FormRequest
{
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
                Rule::exists('user_source_providers', 'type')->where('user_id', $this->getSite()->server->user_id)
            ],
            'repository' => [
                'required',
                'string',
                new RepositoryName()
            ],
            'repository_branch' => 'required|string|alpha_dash'
        ];
    }

    /**
     * @return Site
     */
    public function persist(): Site
    {
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
