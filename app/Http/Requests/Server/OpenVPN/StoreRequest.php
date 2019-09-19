<?php

namespace App\Http\Requests\Server\OpenVPN;

use App\Models\OpenVPNServer;
use App\Models\Server;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('store', [Server\OpenVPN\Client::class, $this->getServer()]);
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
                Rule::unique('openvpn_clients')->where('server_id', $this->getServer()->id)
            ]
        ];
    }

    /**
     * @return Server\OpenVPN\Client
     */
    public function persist(): Server\OpenVPN\Client
    {
        return $this->getServer()->clients()->create(
            $this->validated()
        );
    }

    /**
     * @return OpenVPNServer
     */
    protected function getServer(): OpenVPNServer
    {
        return $this->route('openvpn');
    }
}
