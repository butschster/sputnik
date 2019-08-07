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
            'ip' => ['required', 'ipv4', Rule::unique('servers')],
            'ssh_port' => 'nullable|digits_between:2,4',
            'sudo_password' => 'nullable|string',
            'php_version' => ['required', Rule::in(config('configurations.php', []))],
            'database_type' => ['required', Rule::in(config('configurations.database', []))],
            'meta' => 'nullable|array'
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
