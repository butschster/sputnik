<?php

namespace App\Http\Requests\Server\Site;

use App\Models\Server\Site;
use App\Validation\Rules\Server\Site\RepositoryUrl;
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
            'repository' => ['required', 'string', RepositoryUrl::class],
            'repository_branch' => 'required|string|alpha_dash'
        ];
    }

    /**
     * @return Site
     */
    public function persist(): Site
    {
        $site = $this->route('site');

        $site->update($this->validationData());

        return $site;
    }
}
