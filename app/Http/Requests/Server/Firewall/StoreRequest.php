<?php

namespace App\Http\Requests\Server\Firewall;

use App\Models\Server\Firewall\Rule;
use Illuminate\Foundation\Http\FormRequest;

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
            'name' => 'required|string',
            'port' => 'required|numeric|digits:2,4',
            'from' => 'nullable|ip',
            'policy' => 'required|in:allow,deny',
        ];
    }

    /**
     * @return Rule
     */
    public function persist(): Rule
    {
        $server = $this->route('server');

        return $server->firewallRules()->create(
            $this->validationData()
        );
    }
}
