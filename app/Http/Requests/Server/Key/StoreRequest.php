<?php

namespace App\Http\Requests\Server\Key;

use App\Http\Requests\SanitizesInput;
use App\Models\Server\Key;
use App\Validation\Rules\Server\PublicKey;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    use SanitizesInput;

    /**
     *  Filters to be applied to the input.
     * @return void
     */
    public function filters()
    {
        return [
            'content' => 'trim|remove_new_lines',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     * TODO add check unique with servers public keys
     *
     * @return array
     */
    public function rules()
    {
        $serverID = $this->route('server')->id;

        return [
            'name' => [
                'required',
                'string',
                Rule::unique('server_keys')->where('server_id', $serverID),
            ],
            'content' => [
                'required',
                'string',
                new PublicKey,
                //Rule::unique('servers', 'public_key'),
                Rule::unique('server_keys')->where('server_id', $serverID),
            ],
        ];
    }

    /**
     * @return Key
     */
    public function persist(): Key
    {
        $server = $this->route('server');

        return $server->addPublicKey(
            $this->name, $this->input('content')
        );
    }
}
