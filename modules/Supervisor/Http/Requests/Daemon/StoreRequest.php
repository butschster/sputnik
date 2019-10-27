<?php

namespace Module\Supervisor\Http\Requests\Daemon;

use App\Models\Server;
use Domain\Record\Repositories\RecordRepository;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Module\Supervisor\Models\Daemon;

class StoreRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('store', [Server\Record::class, $this->getServer()]);
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
            'user' => 'required|string',
            'directory' => 'nullable|string',
        ];
    }

    /**
     * @return Server\Record
     */
    public function persist(): Server\Record
    {
        $repository = new RecordRepository();

        return $repository->store(
            $this->getServer(),
            new Daemon($this->validated())
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
