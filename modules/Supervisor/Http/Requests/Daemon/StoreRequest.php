<?php

namespace Module\Supervisor\Http\Requests\Daemon;

use App\Models\Server;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Module\Supervisor\Models\Daemon;

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
        $daemon = new Daemon($this->validated());
        $daemon->server()->associate($this->getServer());
        $daemon->save();

        return $daemon;
    }

    /**
     * @return Server
     */
    protected function getServer(): Server
    {
        return $this->route('server');
    }
}
