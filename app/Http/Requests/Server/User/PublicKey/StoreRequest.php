<?php

namespace App\Http\Requests\Server\User\PublicKey;

use App\Http\Requests\Sanitizer\SanitizesInput;
use App\Models\Server\User;
use Domain\SSH\Validation\Rules\PublicKey as PublicKeyRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    use SanitizesInput;

    /**
     * Filters to be applied to the input.
     * @return array
     */
    public function filters()
    {
        return [
            'key' => 'trim|remove_new_lines',
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
        $userId = $this->getServerUser()->id;

        return [
            'name' => [
                'required',
                'string',
                Rule::unique('server_user_public_keys')->where('user_id', $userId),
            ],
            'key' => [
                'required',
                'string',
                new PublicKeyRule,
                Rule::unique('server_user_public_keys')->where('user_id', $userId),
            ],
        ];
    }

    /**
     * @return User\PublicKey
     */
    public function persist(): User\PublicKey
    {
        return $this->getServerUser()->addPublicKey(
            $this->name, $this->input('key')
        );
    }

    /**
     * @return User
     */
    protected function getServerUser(): User
    {
        return $this->route('user');
    }
}
