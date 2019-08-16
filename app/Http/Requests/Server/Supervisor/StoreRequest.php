<?php

namespace App\Http\Requests\Server\Supervisor;

use App\Models\Server;
use App\Models\Server\Daemon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('store', [Daemon::class, $this->getServer()]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'command' => 'required|string',
            'processes' => 'required|numeric|min:1|max:100',
            'user' => 'required',
            'directory' => 'nullable|string',
        ];
    }

    /**
     * @return Daemon
     */
    public function persist(): Daemon
    {
        return $this->getServer()->daemons()->create(
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
