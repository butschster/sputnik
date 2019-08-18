<?php

namespace App\Http\Requests\Server\Database;

use App\Models\Server;
use App\Models\Server\Database;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('store', [Database::class, $this->getServer()]);
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
                'alpha_dash',
                Rule::unique('server_databases')->where('server_id', $this->route('server')->id)
            ],
            'password' => [
                'nullable',
                'string',
            ]
        ];
    }

    /**
     * @return Database
     */
    public function persist(): Database
    {
        return $this->getServer()->databases()->create(
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
