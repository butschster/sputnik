<?php

namespace App\Http\Requests\Server\Database;

use App\Models\Server\Database;
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
            'name' => [
                'required',
                'string',
                'alpha_dash',
                Rule::unique('server_databases')->where('server_id', $this->route('server')->id)
            ],
        ];
    }

    /**
     * @return Database
     */
    public function persist(): Database
    {
        $server = $this->route('server');

        return $server->databases()->create(
            $this->validationData()
        );
    }
}
