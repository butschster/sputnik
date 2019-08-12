<?php

namespace App\Http\Requests\Server\Site;

use App\Models\Server\Site;
use App\Validation\Rules\Server\Site\PublicPath;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'domain' => ['required', 'string', Rule::unique('server_sites')],
            'public_dir' => ['required', 'string', PublicPath::class]
        ];
    }

    /**
     * @return Site
     */
    public function persist(): Site
    {
        $server = $this->route('server');

        return $server->sites()->create(
            $this->validationData()
        );
    }
}
