<?php

namespace App\Http\Requests\Server\Key;

use App\Models\Server\Key;
use App\Rules\Server\Key\PublicKey;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
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
            'content' => [
                'required',
                'string',
                new PublicKey,
                Rule::unique('server_keys')->where('server_id', $this->route('server')->id),
            ],
        ];
    }

    /**
     * @return Key
     */
    public function persist(): Key
    {
        $server = $this->route('server');

        return $server->addPublicKey($this->name, $this->content);
    }
}
