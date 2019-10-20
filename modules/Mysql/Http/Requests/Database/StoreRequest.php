<?php

namespace Module\Mysql\Http\Requests\Database;

use App\Models\Server;
use App\Repositories\Server\RecordRepository;
use App\Validation\Rules\Server\ModuleInstalled;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Module\Mysql\Events\Database\Created;

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
            'name' => [
                'required',
                'string',
                'alpha_dash',
                Rule::unique('server_mysql_databases')->where('server_id', $this->route('server')->id),
            ],
            'password' => [
                'nullable',
                'string',
            ],
            'module' => [
                'required',
                new ModuleInstalled($this->getServer())
            ]
        ];
    }

    /**
     * @return Server\Record
     */
    public function persist(): Server\Record
    {
        $repository = new RecordRepository();

        $data = $this->validated();

        if (!$this->password) {
            $data['password']= Str::random();
        }

        $record = $repository->store(
            $this->getServer(),
            $this->module,
            'database',
            $data
        );

        event(new Created($record));

        return $record;
    }

    /**
     * @return Server
     */
    protected function getServer(): Server
    {
        return $this->route('server');
    }
}
