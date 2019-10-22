<?php

namespace Module\Mysql\Http\Requests\Database;

use App\Models\Server;
use App\Repositories\Server\RecordRepository;
use App\Validation\Rules\Server\ModuleInstalled;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Module\Mysql\Models\Database;

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
        $server = $this->getServer();

        return [
            'module' => [
                'required',
                new ModuleInstalled($server)
            ],
            'name' => [
                'required',
                'string',
                'alpha_dash',
                Rule::unique('server_records', 'meta->name')
                    ->where('server_id', $server->id)
                    ->where('module_id', $server->getModule($this->module)->id)
                    ->where('key', 'database'),
            ],
            'password' => [
                'nullable',
                'string',
            ],
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

        $model = new Database(
            Arr::except($data, 'module')
        );

        $record = $repository->store(
            $this->getServer(),
            $model->setModule($this->module)
        );

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
