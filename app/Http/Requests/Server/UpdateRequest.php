<?php

namespace App\Http\Requests\Server;

use App\Models\Server;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class UpdateRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('update', $this->getServer());
    }

    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
        ];
    }

    /**
     * @return Server
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function persist(): Server
    {
        $this->getServer()->update($this->validated());

        return $this->getServer();
    }

    /**
     * @return Server
     */
    protected function getServer(): Server
    {
        return $this->route('server');
    }
}
