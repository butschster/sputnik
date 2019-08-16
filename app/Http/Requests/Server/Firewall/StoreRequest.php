<?php

namespace App\Http\Requests\Server\Firewall;

use App\Models\Server;
use App\Models\Server\Firewall\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class StoreRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('store', [Rule::class, $this->getServer()]);
    }

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
        return $this->getServer()->firewallRules()->create(
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
