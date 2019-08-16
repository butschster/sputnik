<?php

namespace App\Http\Requests\Server\User;

use App\Models\Server;
use App\Models\Server\Site;
use App\Validation\Rules\Server\Site\PublicPath;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('store', [Server\User::class, $this->getServer()]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => [
                'required',
                'string',
                Rule::unique('server_users')->where('server_id', $this->getServer()->id)
            ]
        ];
    }

    /**
     * @return Site
     */
    public function persist(): Site
    {
        return $this->getServer()->users()->create(
            $this->validationData()
        );
    }

    /**
     * @return Server
     */
    protected function getServer(): Server
    {
        return $this->route('server');
    }
}
