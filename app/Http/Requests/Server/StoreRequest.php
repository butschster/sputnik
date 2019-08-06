<?php

namespace App\Http\Requests\Server;

use App\Models\Server;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'ip' => 'required|ipv4',
            'port' => 'nullable|digits_between:2,4',
            'sudo_password' => 'nullable|string',
            // TODO: move versions into config
            'php_version' => ['required', Rule::in(['73', '72', '71', '70', '56'])],
            // TODO: move database types into config
            'database_type' => ['required', Rule::in(['mysql', 'mysql8', 'mariadb', 'pgsql'])],
            'meta' => 'array'
        ];
    }

    /**
     * @return Server
     */
    public function persist(): Server
    {
        return $this->user()->servers()->create(
            $this->validated()
        );
    }
}
