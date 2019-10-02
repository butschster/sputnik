<?php

namespace Module\OpenVPN\Http\Requests\Client;

use App\Models\Server;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Module\OpenVPN\Models\Client;

class StoreRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('store', [Client::class, $this->getServer()]);
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
     * @return Client
     */
    public function persist(): Client
    {
        $client = new Client($this->validated());
        $client->server()->associate($this->getServer());
        $client->save();

        return $client;
    }

    /**
     * @return Server
     */
    protected function getServer(): Server
    {
        return $this->route('server');
    }
}
